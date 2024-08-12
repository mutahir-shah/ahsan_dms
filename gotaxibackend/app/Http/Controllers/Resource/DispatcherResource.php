<?php

namespace App\Http\Controllers\Resource;

use App\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Http\Response;

class DispatcherResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => ['update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $dispatchers = Dispatcher::orderBy('created_at', 'desc')->get();
        return view('admin.dispatcher.index', compact('dispatchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.dispatcher.create');
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
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:dispatchers,mobile',
            'email' => 'required|unique:dispatchers,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $Dispatcher = $request->all();
            $Dispatcher['password'] = bcrypt($request->password);

            $Dispatcher = Dispatcher::create($Dispatcher);

            return back()->with('flash_success', translateKeyword('Dispatcher Details Saved'));

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Dispatcher Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function edit($id)
    {
        try {
            $dispatcher = Dispatcher::findOrFail($id);
            return view('admin.dispatcher.edit', compact('dispatcher'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {

            $dispatcher = Dispatcher::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|max:255',
                'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:dispatchers,mobile,' . $dispatcher->id,
            ]);
            $dispatcher->name = $request->name;
            $dispatcher->mobile = str_replace(' ', '', $request->mobile);
            $dispatcher->save();

            return redirect()->route('admin.dispatch-manager.index')->with('flash_success', translateKeyword('Dispatcher Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Dispatcher Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function destroy($id)
    {

        try {
            Dispatcher::find($id)->delete();
            return back()->with('message', translateKeyword('Dispatcher deleted successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Dispatcher Not Found'));
        }
    }

}
