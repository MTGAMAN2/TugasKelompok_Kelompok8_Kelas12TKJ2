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
        ]);

        
        $data['amount'] = preg_replace('/[^0-9]/', '', $data['amount']);

        Transaction::create($data);

        return redirect()->route('transactions.index')->with('success', 'Transaction added!');
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

        $data['amount'] = preg_replace('/[^0-9]/', '', $data['amount']);

        $transaction->update($data);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted!');
    }
}
