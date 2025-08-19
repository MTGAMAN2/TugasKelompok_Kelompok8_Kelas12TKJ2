<?php

namespace App\Http\Controllers;

use App\Models\{Wallet, Category, Transaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function create()
    {
        return view('transactions.purchase', [
            'wallets'=>Wallet::where('user_id',auth()->id())->get(),
            'categories'=>Category::where('type','expense')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wallet_id'=>'required|exists:wallets,id',
            'category_id'=>'required|exists:categories,id',
            'amount'=>'required|numeric|min:0.01',
            'note'=>'nullable|string|max:255',
            'transacted_at'=>'required|date'
        ]);

        $data['user_id'] = $request->user()->id;
        $data['type'] = 'expense';

        DB::transaction(function() use ($data){
            $t = Transaction::create($data);
            $wallet = \App\Models\Wallet::lockForUpdate()->find($data['wallet_id']);
            if($wallet->balance < $t->amount){
                throw new \Exception('Saldo tidak cukup');
            }
            $wallet->balance -= $t->amount;  // langsung terpotong
            $wallet->save();
        });

        return redirect()->route('dashboard')->with('success','Pembelian berhasil, saldo otomatis terpotong ✔');
    }
}
