<?php

namespace App\Http\Controllers;
use App\BlockUserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BlockUserController extends Controller
{
    public function index()
    {
        $blocked_users = BlockUserProvider::with(['user'])
            ->where('provider_id', Auth::user()->id)
            ->where('blocked_by', 'PROVIDER')
            ->get();

        return [ 'success' => true, 'users' => $blocked_users ];
    }

    public function toggleBlock(Request $request, $user_id)
    {
        $blocked_provider = BlockUserProvider::where('user_id', $user_id)
            ->where('provider_id', Auth::user()->id)
            ->where('blocked_by', 'PROVIDER')
            ->first();
        
        if ($blocked_provider)
            $blocked_provider->delete();
        else
            BlockUserProvider::create([
                'user_id' => $user_id,
                'provider_id' => Auth::user()->id,
                'blocked_by' => 'PROVIDER',
                'block_reason' => $request->block_reason ? $request->block_reason : null
            ]);


        return ['success' => true];
    }

}
