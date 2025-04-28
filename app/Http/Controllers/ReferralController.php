<?php

namespace App\Http\Controllers;

use App\Models\FreeCleaning;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function allReferredUsers($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'User not found'
            ]);
        }

        $totalReferList = Referral::with('user')->where('parent_id', $id)->latest()->get();

        $userCoinData = FreeCleaning::where('user_id', $user->id)->first();
        $userCoinData['remaining_coins'] = $userCoinData->earn_coins - $userCoinData->used_coins;

        return response()->json([
            'ok' => true,
            'message' => 'All referrals data showing',
            'user' => $user,
            'totalRefer' => count($totalReferList),
            'userCoinData' => $userCoinData,
            'totalReferList' => $totalReferList,
        ]);
    }
}
