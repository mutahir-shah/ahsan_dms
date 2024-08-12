<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use anlutro\LaravelSettings\Facade as Setting;
use Exception;
use App\Helpers\Helper;

use App\ServiceType;
use App\Blog;
use App\BankAccount;
use App\Http\Controllers\SendPushNotification;
use App\WithdrawalMoney;
use Illuminate\Http\Response;

class AdminBankResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function new_account(Request $request)
    {
        $bank = BankAccount::where('status', 'WAITING')->get();
        if ($request->ajax()) {
            return $bank;
        } else {
            return view('admin.bank.new_account', compact('bank'));
        }
    }

    public function bank_approve($id)
    {
        BankAccount::where('id', $id)->update(['status' => 'APPROVED']);
        return back()->with('flash_success', translateKeyword('Account Approved Successfully'));

    }

    public function approved_account(Request $request)
    {

        if ($request->ajax()) {

            return BankAccount::where('id', $request->id)->update(['status' => 'APPROVED']);
            return back()->with('flash_success', translateKeyword('Approved created Successfully'));

        } else {

            $bank = BankAccount::where('status', 'APPROVED')->get();

            return view('admin.bank.approved_account', compact('bank'));

        }

    }


    public function approved_withdraw(Request $request)
    {

        if ($request->ajax()) {

            $withDrawal = WithdrawalMoney::find($request->id);
            $withDrawal->status = 'APPROVED';
            $withDrawal->save();
            $withDrawal ? (new SendPushNotification)->WithdrawalRequest($withDrawal->provider_id) : 'N/A';
            return $withDrawal;
        } else {

            $bank = WithdrawalMoney::where('status', 'APPROVED')->get();
            return view('admin.bank.approved_withdraw', compact('bank'));

        }
    }

    public function disapproved_withdraw(Request $request)
    {

        if ($request->ajax()) {

            return WithdrawalMoney::where('id', $request->id)->update(['status' => 'DISAPPROVED']);
        } else {

            $bank = WithdrawalMoney::where('status', 'DISAPPROVED')->get();
            return view('admin.bank.disapproved_withdraw', compact('bank'));

        }
    }

    public function new_withdraw(Request $request)
    {
        $bank = WithdrawalMoney::where('status', 'WAITING')->get();


        if ($request->ajax()) {

            $withdraw = WithdrawalMoney::where('id', $request->id)->first();
            $bankDetail = BankAccount::where('id', $withdraw->bank_account_id)->first();

            $arr = [];

            $arr[0]['account_name'] = $bankDetail ? $bankDetail->account_name : 'N/A';
            $arr[0]['bank_name'] = $bankDetail ? $bankDetail->bank_name : 'N/A';
            $arr[0]['account_number'] = $bankDetail ? $bankDetail->account_number : 'N/A';
            $arr[0]['routing_number'] = $bankDetail ? $bankDetail->routing_number : 'N/A';
            $arr[0]['withdraw_request_amount'] = $bankDetail ? $withdraw->amount : 'N/A';
            $arr[0]['request_date'] = $bankDetail ? $bankDetail->created_at : 'N/A';
            $arr[0]['country'] = $bankDetail ? $bankDetail->country : 'N/A';
            $arr[0]['IFSC_code'] = $bankDetail ? $bankDetail->IFSC_code : 'N/A';
            $arr[0]['MICR_code'] = $bankDetail ? $bankDetail->MICR_code : 'N/A';
            $arr[0]['withdrawId'] = $withdraw->id;

            return $arr;

        } else {
            return view('admin.bank.new_withdraw', compact('bank'));
        }


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!'). ' ' .'meemcolart@gmail.com');
        }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'mimes:ico,png,jpeg,jpg'
        ]);

        try {
            $service = $request->all();

            if ($request->hasFile('image')) {
                $image = $request->image->store('website');
                $image = asset('storage/' . $image);
                $service['image'] = $image;
            }

            $service = Blog::create($service);

            return back()->with('flash_success', translateKeyword('New Blog post created'));
        } catch (Exception $e) {
            // dd("Exception", $e);
            return back()->with('flash_error', translateKeyword('Account Not Found'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceType $serviceType
     * @return Response
     */
    public function show($id)
    {
        try {
            return ServiceType::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Account Not Found'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceType $serviceType
     * @return Response
     */
    public function edit($id)
    {

        try {
            $service = BankAccount::findOrFail($id);
            return view('admin.bank.edit', compact('service'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Account Not Found'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ServiceType $serviceType
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!'). ' ' .'meemcolart@gmail.com');
        }

        /*$this->validate($request, [
            'account_name' => 'required|max:255',
            'bank_name' => 'required',
            'account_number' => 'required|numeric|max:20',
            'routing_number' => 'required|numeric|max:20',
			
        ]);*/

        try {

            $service = BankAccount::findOrFail($id);
            $service->paypal_id = $request->paypal_id;
            $service->account_name = $request->account_name;
            $service->bank_name = $request->bank_name;
            $service->account_number = $request->account_number;
            $service->routing_number = $request->has('routing_number') ? $request->routing_number : '0';
            $service->country = $request->country;
            $service->save();

            return redirect('account/approved_account')->with('flash_success', translateKeyword('Account Updated Successfully'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Account Not Found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceType $serviceType
     * @return Response
     */
    public function destroy($id)
    {
        if (Setting::get('demo_mode', 0) == 1) {
            return back()->with('flash_error', translateKeyword('Disabled for demo purposes!').' '.'meemcolart@gmail.com');
        }

        try {
            BankAccount::find($id)->delete();
            return back()->with('message', 'Account deleted successfully');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', translateKeyword('Account Not Found'));
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Account Not Found'));
        }
    }
}
