<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;   // <-- add this line

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
        
        // update the stored balance column so it stays in sync with computed value
        // (this is mostly for convenience when inspecting the DB directly)
        $calculated = $wallet->transactions()
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as total")
            ->value('total');
        $wallet->balance = $calculated ?? 0;
        $wallet->save();
        
        return response()->json($transaction, 201);
    }
}
