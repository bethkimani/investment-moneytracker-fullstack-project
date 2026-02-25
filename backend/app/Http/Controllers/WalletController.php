<?php
namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(User $user)
    {
        $wallets = $user->wallets()->with('transactions')->get();
        return response()->json($wallets);
    }

    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $wallet = $user->wallets()->create($validated);
        $wallet->load('transactions');
        
        return response()->json($wallet, 201);
    }

    public function show(Wallet $wallet)
    {
        $wallet->load('transactions');
        $wallet->refresh(); // Recalculate balance
        
        return response()->json($wallet);
    }
}
