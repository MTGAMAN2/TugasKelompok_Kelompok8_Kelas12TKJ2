<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Ringkas bulan berjalan
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        $income = Transaction::where('user_id',$user->id)
            ->whereBetween('transacted_at',[$start,$end])
            ->where('type','income')->sum('amount');

        $expense = Transaction::where('user_id',$user->id)
            ->whereBetween('transacted_at',[$start,$end])
            ->where('type','expense')->sum('amount');

        $topCategories = Transaction::select('categories.name', DB::raw('SUM(amount) as total'))
            ->join('categories','categories.id','=','transactions.category_id')
            ->where('transactions.user_id',$user->id)
            ->where('transactions.type','expense')
            ->whereBetween('transacted_at',[$start,$end])
            ->groupBy('categories.name')->orderByDesc('total')->limit(5)->get();

        return view('dashboard.index', compact('income','expense','topCategories'));
    }
}