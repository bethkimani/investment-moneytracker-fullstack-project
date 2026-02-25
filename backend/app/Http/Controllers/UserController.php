<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('wallets')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = User::create($validated);
        $user->load('wallets');
        
        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        $user->load(['wallets' => function ($query) {
            $query->with('transactions')->select('id', 'user_id', 'name', 'balance');
        }]);
        
        return response()->json($user);
    }
}
