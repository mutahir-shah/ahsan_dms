<?php

namespace App\Http\Controllers\Resource;

use App\Admin;
use App\User;
use App\UserRequests;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use anlutro\LaravelSettings\Facade as Setting;
use App\Role;
use Illuminate\Support\Facades\Auth;
use App\Services\LogService;
class AdminResource extends Controller
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
     * @return Response
     */
    public function index()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.MANAGEUSERS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.MANAGEUSERS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.MANAGEUSERS'));
        $status_permission = Helper::CheckPermission(config('const.STATUS'), config('const.MANAGEUSERS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.MANAGEUSERS'));
       
        $admins = Admin::with('role')
        ->where('id', '!=', $admin_id)
        ->when($data_permission != 1, function ($query) use ($admin_id) {
            return $query->where('created_by', $admin_id);
        })
        ->orderBy('created_at', 'desc')
        ->get();


        return view('admin.admins.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user_id = Auth::guard('admin')->user()->id;
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.MANAGEUSERS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.MANAGEUSERS'));
        if($add_permission == 0){
            abort(401);
        }
        $roles = Role::when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();
    
        return view('admin.admins.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:admins,email|email|max:255',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            $admin = $request->all();
            $admin['updated_by'] = Auth::guard('admin')->id();
            $admin['password'] = bcrypt($request->password);
            if ($request->hasFile('picture')) {
                $admin['picture'] = $request->picture->store('admin/profile');
            }
            $admin = Admin::create($admin);
            $this->logService->log('Admins', 'create', 'Admin Created.', $admin);

            return back()->with('flash_success', translateKeyword('Admin Created Successfully!'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Admin Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $admin
     * @return Response
     */
    public function show($id)
    {
        try {
            $admin = Admin::findOrFail($id);
            return view('admin.admins.user-details', compact('user'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $admin
     * @return Response
     */
    public function edit($id)
    {
        try {
            $user_id = Auth::guard('admin')->user()->id;
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.MANAGEUSERS'));
            $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.MANAGEUSERS'));
            if($edit_permission == 0){
                abort(401);
            }
            $roles = Role::when($data_permission != 1, function ($query) use ($user_id) {
                return $query->where('created_by', $user_id);
            })
            ->get();
                $admin = Admin::findOrFail($id);
            
            return view('admin.admins.edit', get_defined_vars());
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $admin
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'picture' => 'simetimes|mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try {

            $admin = Admin::findOrFail($id);

            if ($request->hasFile('picture')) {
                Storage::delete($admin->picture);
                $admin->picture = $request->picture->store('user/profile');
            }

            $pass = '';

            $admin->name = $request->name;
            $admin->role_id = $request->role_id;
            $admin->updated_by = Auth::guard('admin')->id();

            if ($request->password != '') {
                $pass = Hash::make($request->password);
                $admin->password = $pass;
            }


            $admin->save();
            $admin = Admin::findOrFail($id);
            $this->logService->log('Admins', 'update', 'Admin Updated.', $admin);

            return redirect()->route('admin.admin.index')->with('flash_success', translateKeyword('Admin Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Admin Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $admin
     * @return Response
     */
    public function destroy($id)
    {

        try {
            $admin_id = Auth::guard('admin')->user()->id;

            if ($admin_id != $id) {
                $admin = Admin::find($id);
                $this->logService->log('Admins', 'delete', 'Admin Deleted.', $admin);
                $admin->delete();
                return back()->with('flash_success', translateKeyword('Admin deleted successfully'));

            } else {
                return back()->with('flash_error', translateKeyword('Admin cannot be deleted'));
            }


        } catch (Exception $e) {
            return $e->getMessage();
            return back()->with('flash_error', translateKeyword('user_not_found'));
        }
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param User $admin
     * @return Response
     */
    public function massDestroy(Request $request)
    {

        try {
            foreach($request->deleteids_arr as $id) {
                $admin = Admin::find($id);
                $this->logService->log('Admins', 'delete', 'Admin Deleted.', $admin);
                $admin->delete();
            }

            // return back()->with('flash_success', 'Admins deleted successfully');
            return 'admins deleted successfully';
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('user_not_found'));
        }
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function approve($id)
    {
        $admin = Admin::find($id);
        $this->logService->log('Admins', 'status', 'Admin Status Updated.', $admin);
        $admin->update(['status' => 1]);
        return back()->with('flash_success', translateKeyword('Admin Approved'));
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param Provider $provider
     * @return Response
     */
    public function disapprove($id)
    {
        $admin = Admin::find($id);
        $this->logService->log('Admins', 'status', 'Admin Status Updated.', $admin);
        $admin->update(['status' => 0]);
        return back()->with('flash_success', translateKeyword('Admin Approved'));
    }


}
