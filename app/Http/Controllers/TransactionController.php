<?php

namespace App\Http\Controllers;

use App\Models\{Transaction, Wallet, Category, Vendor, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $q = Transaction::with(['wallet','category','vendor'])
            ->where('user_id',$user->id)
            ->orderByDesc('transacted_at');

        if ($request->filled('type')) $q->where('type',$request->type);
        if ($request->filled('category_id')) $q->where('category_id',$request->category_id);
        if ($request->filled('wallet_id')) $q->where('wallet_id',$request->wallet_id);
        if ($request->filled('date_from')) $q->whereDate('transacted_at','>=',$request->date_from);
        if ($request->filled('date_to')) $q->whereDate('transacted_at','<=',$request->date_to);

        $transactions = $q->paginate(15)->withQueryString();
        $wallets = Wallet::where('user_id',$user->id)->get();
        $categories = Category::where(fn($c)=>true)->get();
        return view('transactions.index', compact('transactions','wallets','categories'));
    }

    public function create()
    {
        return view('transactions.form', [
            'wallets'=>Wallet::where('user_id',auth()->id())->get(),
            'categories'=>Category::all(),
            'vendors'=>Vendor::where('user_id',auth()->id())->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wallet_id'=>'required|exists:wallets,id',
            'category_id'=>'nullable|exists:categories,id',
            'vendor_id'=>'nullable|exists:vendors,id',
            'type'=>'required|in:income,expense,transfer',
            'amount'=>'required|numeric|min:0.01',
            'transacted_at'=>'required|date',
            'note'=>'nullable|string|max:255',
            'attachment'=>'nullable|file|max:2048'
        ]);

        $data['user_id'] = $request->user()->id;

        if($request->hasFile('attachment')){
            $data['attachment_path'] = $request->file('attachment')->store('uploads/attachments','public');
        }

        DB::transaction(function() use ($data){
            $t = Transaction::create($data);
            $wallet = Wallet::lockForUpdate()->find($t->wallet_id);

            if($t->type === 'income'){
                $wallet->balance += $t->amount;
            } elseif($t->type === 'expense'){
                $wallet->balance -= $t->amount;
            }
            $wallet->save();

            AuditLog::create([
                'user_id'=>$t->user_id,
                'action'=>'created_transaction',
                'details'=>json_encode(['transaction_id'=>$t->id])
            ]);
        });

        return redirect()->route('transactions.index')->with('success','Transaction saved');
    }

    public function destroy(Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);
        DB::transaction(function() use ($transaction){
            $wallet = Wallet::lockForUpdate()->find($transaction->wallet_id);
            if($transaction->type === 'income'){
                $wallet->balance -= $transaction->amount;
            } elseif($transaction->type === 'expense'){
                $wallet->balance += $transaction->amount;
            }
            $wallet->save();
            $transaction->delete();
        });
        return back()->with('success','Transaction deleted and wallet adjusted');
    }
}
