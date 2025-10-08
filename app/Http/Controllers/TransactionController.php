<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category; 
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $wallets = Wallet::all();
        $categories = Category::all();
        $transactions = Transaction::with('wallet')->latest()->get();
        return view('transactions.index', compact('wallets', 'categories', 'transactions'));
    }

    public function create()
    {
        $wallets = Wallet::all();
        $categories = Category::all(); 
        return view('transactions.index', compact('wallets', 'categories', 'transactions'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'wallet_id'   => 'required|exists:wallets,id',
        'category_id' => 'required|exists:categories,id',
        'type'        => 'required|in:income,expense',
        'amount'      => 'required',
        'description' => 'nullable|string',
        'transacted_at' => 'nullable|date', 
    ]);

    $wallet = Wallet::findOrFail($data['wallet_id']);
    $amount = preg_replace('/[^0-9]/', '', $data['amount']);
    $data['amount'] = $amount;
    $data['user_id'] = auth()->id(); // associate user
    $data['transacted_at'] = $data['transacted_at'] ?? now(); 

    $transaction = Transaction::create($data);

    if ($data['type'] === 'income') {
        $wallet->balance += $amount;
    } else {
        $wallet->balance -= $amount;
    }

    $wallet->save();

    return redirect()->route('transactions.index')->with('success', 'Transaction added and wallet updated!');
}

    public function edit(Transaction $transaction)
    {
        $wallets = Wallet::all();
        $categories = Category::all(); 
        return view('transactions.form', [
            'isEdit' => true,
            'wallets' => $wallets,
            'categories' => $categories, 
            'transaction' => $transaction,
        ]);
    }

    public function update(Request $request, Transaction $transaction)
{
    $data = $request->validate([
        'wallet_id'   => 'required|exists:wallets,id',
        'category_id' => 'required|exists:categories,id',
        'type'        => 'required|in:income,expense',
        'amount'      => 'required',
        'description' => 'nullable|string',
    ]);

    $wallet = Wallet::findOrFail($data['wallet_id']);
    $oldAmount = $transaction->amount;
    $newAmount = preg_replace('/[^0-9]/', '', $data['amount']);

    if ($transaction->type === 'income') {
        $wallet->balance -= $oldAmount;
    } else {
        $wallet->balance += $oldAmount;
    }

    $transaction->update([
        ...$data,
        'amount' => $newAmount,
    ]);

    if ($data['type'] === 'income') {
        $wallet->balance += $newAmount;
    } else {
        $wallet->balance -= $newAmount;
    }

    $wallet->save();

    return redirect()->route('transactions.index')->with('success', 'Transaction updated and wallet recalculated!');
}


    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted!');
    }
}
