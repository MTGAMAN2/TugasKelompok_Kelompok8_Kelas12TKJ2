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

    // Kurangi saldo wallet asal
    if ($from->balance < $data['amount']) {
        return back()->withErrors(['amount' => 'Saldo tidak cukup']);
    }

    $from->balance -= $data['amount'];
    $to->balance   += $data['amount'];

    $from->save();
    $to->save();

    // Kalau mau simpan ke tabel transaksi
    \App\Models\Transaction::create([
        'wallet_id'     => $from->id,
        'type'          => 'transfer',
        'amount'        => $data['amount'],
        'note'          => $data['note'],
        'transacted_at' => $data['transacted_at'],
    ]);

    return back()->with('success', 'Transfer berhasil!');
}
}
