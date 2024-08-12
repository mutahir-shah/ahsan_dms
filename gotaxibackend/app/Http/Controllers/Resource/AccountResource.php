<?php

namespace App\Http\Controllers\Resource;

use App\Account;
use App\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Http\Response;

class AccountResource extends Controller
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
        $accounts = Account::orderBy('created_at', 'desc')->get();
        return view('admin.account-manager.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.account-manager.create');
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
            'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:accounts,mobile',
            'email' => 'required|unique:accounts,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $Account = $request->all();
            $Account['password'] = bcrypt($request->password);

            $Account = Account::create($Account);

            return back()->with('flash_success', translateKeyword('Account Manager Details Saved Successfully'));

        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Account Manager Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Dispatcher $account
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Account $account
     * @return Response
     */
    public function edit($id)
    {
        try {
            $account = Account::findOrFail($id);
            return view('admin.account-manager.edit', compact('account'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Account $account
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {

            $Account = Account::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|max:255',
                'mobile' => 'required|regex:/[+][0-9 ]{10,15}/|min:5|max:15|unique:accounts,mobile,' . $Account->id,
            ]);
            $Account->name = $request->name;
            $Account->mobile = str_replace(' ', '', $request->mobile);
            $Account->save();

            return redirect()->route('admin.account-manager.index')->with('flash_success', translateKeyword('Account Manager Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Account Manager Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Account $dispatcher
     * @return Response
     */
    public function destroy($id)
    {

        try {
            Account::find($id)->delete();
            return back()->with('message', translateKeyword('Account Manager deleted successfully'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Account Not Found'));
        }
    }

}
