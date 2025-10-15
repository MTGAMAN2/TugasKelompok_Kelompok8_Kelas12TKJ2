<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $wallets = Wallet::where('user_id', $userId)->get();
        $categories = Category::where(function ($query) use ($userId) {
        $query->where('user_id', $userId)
              ->orWhereNull('user_id');
        })->get();

        $transactions = Transaction::with(['wallet', 'category'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('transactions.index', compact('wallets', 'categories', 'transactions'));
    }

    public function create()
    {
        $userId = Auth::id();

        $wallets = Wallet::where('user_id', $userId)->get();
        $categories = Category::where(function ($query) use ($userId) {
        $query->where('user_id', $userId)
              ->orWhereNull('user_id');
        })->get();

        return view('transactions.form', [
            'isEdit' => false,
            'wallets' => $wallets,
            'categories' => $categories,
            'transaction' => null,
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $data = $request->validate([
            'wallet_id'   => 'required|exists:wallets,id',
            'category_id' => 'nullable|exists:categories,id',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required',
            'description' => 'nullable|string',
            'transacted_at' => 'nullable|date',
        ]);

        $wallet = Wallet::where('id', $data['wallet_id'])
            ->where('user_id', $userId)
            ->firstOrFail();

        if (!empty($data['category_id'])) {
            $category = Category::where('id', $data['category_id'])
                ->where('user_id', $userId)
                ->firstOrFail();
        }

        $amount = preg_replace('/[^0-9]/', '', $data['amount']);
        $data['amount'] = $amount;
        $data['user_id'] = $userId;
        $data['transacted_at'] = $data['transacted_at'] ?? now();

        $transaction = Transaction::create($data);

        if ($data['type'] === 'income') {
            $wallet->balance += $amount;
        } else {
            $wallet->balance -= $amount;
        }
        $wallet->save();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(Transaction $transaction)
    {
        $userId = Auth::id();
        abort_if($transaction->user_id !== $userId, 403);

        $wallets = Wallet::where('user_id', $userId)->get();
        $categories = Category::where('user_id', $userId)->get();

        return view('transactions.form', [
            'isEdit' => true,
            'wallets' => $wallets,
            'categories' => $categories,
            'transaction' => $transaction,
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $userId = Auth::id();
        abort_if($transaction->user_id !== $userId, 403);

        $data = $request->validate([
            'wallet_id'   => 'required|exists:wallets,id',
            'category_id' => 'nullable|exists:categories,id',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required',
            'description' => 'nullable|string',
        ]);

        $wallet = Wallet::where('id', $data['wallet_id'])
            ->where('user_id', $userId)
            ->firstOrFail();

        if (!empty($data['category_id'])) {
            $category = Category::where('id', $data['category_id'])
                ->where('user_id', $userId)
                ->firstOrFail();
        }

        if ($transaction->type === 'income') {
            $wallet->balance -= $transaction->amount;
        } else {
            $wallet->balance += $transaction->amount;
        }

        $newAmount = preg_replace('/[^0-9]/', '', $data['amount']);
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

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        $userId = Auth::id();
        abort_if($transaction->user_id !== $userId, 403);

        $wallet = Wallet::where('id', $transaction->wallet_id)
            ->where('user_id', $userId)
            ->first();

        if ($wallet) {
            if ($transaction->type === 'income') {
                $wallet->balance -= $transaction->amount;
            } else {
                $wallet->balance += $transaction->amount;
            }
            $wallet->save();
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
