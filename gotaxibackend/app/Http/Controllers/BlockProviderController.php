<?php

namespace App\Http\Controllers;
use App\BlockUserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BlockProviderController extends Controller
{
    public function index()
    {
        $blocked_providers = BlockUserProvider::with(['provider'])
            ->where('user_id', Auth::user()->id)
            ->where('blocked_by', 'USER')
            ->get();

        return [ 'success' => true, 'providers' => $blocked_providers ];
    }

    public function toggleBlock(Request $request, $provider_id)
    {
        $blocked_provider = BlockUserProvider::where('provider_id', $provider_id)
            ->where('user_id', Auth::user()->id)
            ->where('blocked_by', 'USER')
            ->first();
        
        if ($blocked_provider)
            $blocked_provider->delete();
        
        else
            BlockUserProvider::create([
                'provider_id' => $provider_id,
                'user_id' => Auth::user()->id,
                'blocked_by' => 'USER',
                'block_reason' => $request->block_reason ? $request->block_reason : null
            ]);


        return [ 'success' => true, 'provider' => [] ];
    }

}
