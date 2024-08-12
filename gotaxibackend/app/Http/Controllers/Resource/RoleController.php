<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Module;
use App\Privilege;
use App\Role;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\LogService;
use App\Helpers\Helper;

class RoleController extends Controller
{
    protected $logService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('demo', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::guard('admin')->id();
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.USERROLES'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.USERROLES'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.USERROLES'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.USERROLES')); 

        $roles = Role::when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();
    
        return view('admin.roles.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.USERROLES'));
        if($add_permission == 0){
            abort(401);
        }
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        $request['created_by'] = Auth::guard('admin')->id();
        $role = Role::create($request->all());
        //Saving Privilages Here
        $modules = Module::orderBy('sort','asc')->get();

        foreach($modules as $module)
        {
            Privilege::create([
                'role_id' => $role->id,
                'module_id' => $module->id,
            ]);
        }
        $this->logService->log('UserRoles', 'create', 'User Role Created.', $role);
        return redirect()->route('admin.role.show', $role->id);     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::with('priviliges.module')->find($id);
        $modules = Module::with('operations')->where('parent', 0)->where('type', '!=', 3)->orderBy('sort', 'asc')->get();
        return view('admin.roles.show', get_defined_vars());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.USERROLES'));
        if($edit_permission == 0){
            abort(401);
        }
        $role = Role::find($id);
        return view('admin.roles.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(isset($request->role_id)){
            foreach($request->module_id as $key => $item)
            {
                Privilege::where(['id' => $item])
                ->update([
                    'is_view' => isset($request->is_view[$key])  ? $request->is_view[$key] : 0,
                    'is_view_all_data' => isset($request->is_view_all_data[$key])  ? $request->is_view_all_data[$key] : 0,
                    'is_add' => isset($request->is_add[$key])  ?  $request->is_add[$key] : 0,
                    'is_edit' => isset($request->is_edit[$key])  ? $request->is_edit[$key] : 0,
                    'is_notify' => isset($request->is_notify[$key])  ? $request->is_notify[$key] : 0,
                    'is_status' => isset($request->is_status[$key])  ? $request->is_status[$key] : 0,
                    'is_delete' => isset($request->is_delete[$key])  ? $request->is_delete[$key] : 0,
                ]);
            }
                $this->logService->log('UserRoles', 'update', 'User Role Permissions Updated.', $request->all());

                return back()->with('flash_success', translateKeyword('Permissions Updated Successfully'));
        }

        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
        ]);
        $request['updated_by'] = Auth::guard('admin')->id();
        Role::find($id)->update($request->all());
        $role = Role::find($id);
        $this->logService->log('UserRoles', 'update', 'User Role Updated.', $role);
        return back()->with('flash_success', translateKeyword('Role Updated Successfully'));  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $this->logService->log('UserRoles', 'delete', 'User Role Deleted.', $role);
        $role->delete();
        return back()->with('flash_success', translateKeyword('Role Deleted Successfully'));
    }
}
