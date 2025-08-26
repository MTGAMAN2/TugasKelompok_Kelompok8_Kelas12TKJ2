<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'nullable|date'
        ]);

        Goal::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'saved_amount' => 0,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('goals.index')->with('success', 'Goal berhasil ditambahkan.');
    }

    public function contribute(Request $request, Goal $goal)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:1'
        ]);

        DB::transaction(function () use ($request, $goal) {
            $wallet = Wallet::where('user_id', Auth::id())->findOrFail($request->wallet_id);

            if ($wallet->balance < $request->amount) {
                abort(400, 'Saldo tidak cukup.');
            }

            // transaksi expense dari wallet
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $request->amount,
                'type' => 'expense',
                'description' => 'Contribute to goal: '.$goal->title
            ]);

            $wallet->decrement('balance', $request->amount);
            $goal->increment('saved_amount', $request->amount);

            if ($goal->saved_amount >= $goal->target_amount) {
                \Log::info("Goal {$goal->title} telah tercapai oleh user ".Auth::id());
            }
        });

        return redirect()->route('goals.index')->with('success', 'Kontribusi berhasil.');
    }
}
