<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $wallets = Wallet::where('user_id',$request->user()->id)->paginate(10);
        return view('wallets.index', compact('wallets'));
    }

    public function create(){ return view('wallets.form'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:100',
            'type'=>'required|string|max:50',
            'balance'=>'required|numeric|min:0'
        ]);
        $data['user_id'] = $request->user()->id;
        Wallet::create($data);
        return redirect()->route('wallets.index')->with('success','Wallet created');
    }

    public function edit(Wallet $wallet){ $this->authorizeWallet($wallet); return view('wallets.form', compact('wallet')); }

    public function update(Request $request, Wallet $wallet)
    {
        $this->authorizeWallet($wallet);
        $wallet->update($request->validate([
            'name'=>'required','type'=>'required','balance'=>'required|numeric|min:0'
        ]));
        return back()->with('success','Wallet updated');
    }

    public function destroy(Wallet $wallet)
    {
        $this->authorizeWallet($wallet);
        $wallet->delete();
        return back()->with('success','Wallet deleted');
    }

    private function authorizeWallet(Wallet $wallet)
    {
        abort_if($wallet->user_id !== auth()->id(), 403);
    }
}
