<?php

namespace App\Http\Controllers\Resource;

use App\Promocode;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\PromocodePassbook;
use App\PromocodeUsage;
use Illuminate\Http\Response;
use App\Helpers\Helper;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;

class PromocodeResource extends Controller
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
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user_id = Auth::guard('admin')->id();
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.PROMOCODES'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.PROMOCODES'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.PROMOCODES'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.PROMOCODES'));

        $promocodes = Promocode::orderBy('created_at', 'desc')
        ->when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();
    
        return view('admin.promocode.index', get_defined_vars());
    }

    public function usage()
    {
        $user_id = Auth::guard('admin')->id();
        $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.PROMOCODES'));
        if($view_permission == 1){
            abort(401);
        }
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.PROMOCODES'));

       $promocodes = Promocode::orderBy('created_at', 'desc')
        ->when($data_permission != 1, function ($query) use ($user_id) {
            return $query->where('created_by', $user_id);
        })
        ->get();

        return view('admin.promocode.usage', get_defined_vars());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.PROMOCODES'));
        if($add_permission == 0){
            abort(401);
        }
        return view('admin.promocode.create');
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
            'promo_code' => 'required|max:100|unique:promocodes',
            'discount' => 'required|numeric',
            'expiration' => 'required',
            'max_count' => 'required',
        ]);

        try {
            $user_id = Auth::guard('admin')->id();
            $request->promo_code = strtoupper($request->promo_code);
            $request['created_by'] = $user_id;
            $promocode = Promocode::create($request->all());
            $this->logService->log('Promocodes', 'create', 'Promocode Created.', $promocode);

            return back()->with('flash_success', translateKeyword('Promocode Saved Successfully'));

        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Promocode Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Promocode $promocode
     * @return Response
     */
    public function show($id)
    {
        try {
            $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.PROMOCODES'));
            if($view_permission == 0){
                abort(401);
            }
            return Promocode::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Promocode $promocode
     * @return Response
     */
    public function edit($id)
    {
        try {
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.PROMOCODES'));
            if($edit_permission == 0){
                abort(401);
            }
            $promocode = Promocode::findOrFail($id);
            return view('admin.promocode.edit', compact('promocode'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Promocode $promocode
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'promo_code' => 'required|max:100',
            'discount' => 'required|numeric',
            'expiration' => 'required',
            'max_count' => 'required',
        ]);

        try {

            $promo = Promocode::findOrFail($id);

            $promo->promo_code = strtoupper($request->promo_code);
            $promo->discount = $request->discount;
            $promo->expiration = $request->expiration;
            $promo->status = $request->expiration > date("Y-m-d") ? 'ADDED' : 'EXPIRED';
            $promo->max_count = $request->max_count;
            $promo->updated_by = Auth::guard('admin')->id();
            $promo->save();
            $this->logService->log('Promocodes', 'update', 'Promocode Updated.', $promo->save());
            return redirect()->route('admin.promocode.index')->with('flash_success', translateKeyword('Promocode Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Promocode Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Promocode $promocode
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $promocode = Promocode::find($id);
            PromocodeUsage::where('promocode_id', $id)->delete();
            PromocodePassbook::where('promocode_id', $id)->delete();

            $this->logService->log('Promocodes', 'delete', 'Promocode Deleted.', $promocode);
            $promocode->delete();
            return back()->with('message', translateKeyword('Promocode deleted successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Promocode Not Found'));
        }
    }
}
