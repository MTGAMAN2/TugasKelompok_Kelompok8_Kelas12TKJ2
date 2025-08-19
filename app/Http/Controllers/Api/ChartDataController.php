<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ChartDataController extends Controller
{
    public function summary(Request $request)
    {
        $user = $request->user();
        $from = now()->subMonths(5)->startOfMonth();
        $to   = now()->endOfMonth();

        $data = Transaction::where('user_id',$user->id)
            ->whereBetween('transacted_at', [$from, $to])
            ->get()
            ->groupBy(fn($t) => $t->transacted_at->format('Y-m'))
            ->map(function($rows){
                return [
                    'income'  => $rows->where('type','income')->sum('amount'),
                    'expense' => $rows->where('type','expense')->sum('amount'),
                ];
            });

        return response()->json($data);
    }
}
