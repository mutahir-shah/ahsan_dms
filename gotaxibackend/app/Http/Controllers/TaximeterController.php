<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\Helper;


class TaximeterController extends Controller
{
    public function meterhistory()
    {
        $taximeter = DB::table('taximeter_user_requests')->select('id', 'provider_id', 'distance', 'amount', 'created_at')->get();

        return view('admin.request.taximeter')->with('requests', $taximeter);
    }


}