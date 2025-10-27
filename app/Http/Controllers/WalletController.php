<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();
        $total = $wallets->sum('balance');
        return view('wallets.index', compact('wallets','total'));
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'balance' => 'required|numeric|min:0'
        ]);

        Wallet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'balance' => $request->balance
        ]);

        return redirect()->route('wallets.index')->with('success', 'Wallet berhasil ditambahkan.');
    }

public function transfer(Request $request)
{
    $data = $request->validate([
        'from_wallet_id' => 'required|exists:wallets,id',
        'to_wallet_id'   => 'required|different:from_wallet_id|exists:wallets,id',
        'amount'         => 'required|numeric|min:1',
        'transacted_at'  => 'required|date',
        'note'           => 'nullable|string|max:255',
    ]);

    $from = Wallet::findOrFail($data['from_wallet_id']);
    $to   = Wallet::findOrFail($data['to_wallet_id']);

    if ($from->user_id !== Auth::id() || $to->user_id !== Auth::id()) {
        abort(403, 'Kamu tidak memiliki akses ke salah satu wallet ini.');
    }

    if ($from->balance < $data['amount']) {
        return back()->withErrors(['amount' => 'Saldo tidak cukup']);
    }

    $from->balance -= $data['amount'];
    $to->balance   += $data['amount'];

    $from->save();
    $to->save();

    \App\Models\Transaction::create([
        'user_id'       => Auth::id(),
        'wallet_id'     => $from->id,
        'type'          => 'transfer',
        'amount'        => $data['amount'],
        'note'          => $data['note'],
        'transacted_at' => $data['transacted_at'],
    ]);

    return back()->with('success', 'Transfer berhasil!');
}

public function edit(Wallet $wallet)
{
    if ($wallet->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    return view('wallets.form', compact('wallet'));
}

public function update(Request $request, Wallet $wallet)
{
    if ($wallet->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'name' => 'required|string',
        'balance' => 'nullable|numeric|min:0'
    ]);

    $wallet->update([
        'name' => $request->name,
    ]);

    return redirect()->route('wallets.index')->with('success', 'Wallet berhasil diperbarui.');
}

public function destroy(Wallet $wallet)
{
    if ($wallet->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $wallet->delete();
    return redirect()->route('wallets.index')->with('success', 'Wallet berhasil dihapus.');
}
}
