<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())->with('category')->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();
        return view('goals.create', compact('wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'nullable|date',
            'priority' => 'required|string'
        ]);

        Goal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('goals.index')->with('success', 'Goal created successfully!');
    }

    public function contribute(Request $request, Goal $goal)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'wallet_id' => 'required|exists:wallets,id'
        ]);

         $goal->increment('current_amount', $request->amount);

        $wallet = Wallet::where('id', $request->wallet_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance in wallet!');
        }

        $wallet->balance -= $request->amount;
        $wallet->save();

        $goal->current_amount += $request->amount;
        $goal->save();

        return redirect()->route('goals.index')->with('success', 'Contribution added successfully!');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return back()->with('success', 'Goal deleted successfully.');
    }
    
}
