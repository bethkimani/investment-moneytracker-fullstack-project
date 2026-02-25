<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('wallets.transactions')->get();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::create($validated)->load('wallets.transactions');

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        $user->load('wallets.transactions');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'total_balance' => $user->total_balance,
            'wallets' => $user->wallets->map(function ($wallet) {
                return [
                    'id' => $wallet->id,
                    'name' => $wallet->name,
                    'balance' => $wallet->balance,
                ];
            })->values(),
        ]);
    }
}
