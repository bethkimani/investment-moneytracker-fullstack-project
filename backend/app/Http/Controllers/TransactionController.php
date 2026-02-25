<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Wallet $wallet)
    {
        $transactions = $wallet->transactions()->orderBy('created_at', 'desc')->get();
        return response()->json($transactions);
    }

    public function store(Request $request, Wallet $wallet)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(['income', 'expense'])],
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000'
        ]);

        $transaction = $wallet->transactions()->create($validated);
        
        // Recalculate wallet balance
        $wallet->refresh();
        
        return response()->json($transaction, 201);
    }
}
