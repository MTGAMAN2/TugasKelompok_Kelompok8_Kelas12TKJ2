<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan & tahun dari request, jika tidak ada pakai default saat ini
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // Ambil transaksi berdasarkan bulan dan tahun
        $query = Transaction::with('wallet')
            ->whereHas('wallet', fn($q) => $q->where('user_id', Auth::id()))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        $transactions = $query->latest()->get();

        // Kirim variabel ke view
        return view('reports.index', compact('transactions', 'year', 'month'));
    }

    public function exportCsv()
    {
        $transactions = Transaction::with('wallet')
            ->whereHas('wallet', fn($q) => $q->where('user_id', Auth::id()))
            ->get();

        $filename = 'report.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Wallet', 'Type', 'Amount', 'Description', 'Date']);

        foreach ($transactions as $t) {
            fputcsv($handle, [
                $t->wallet->name,
                ucfirst($t->type),
                number_format($t->amount, 2),
                $t->description,
                $t->created_at->format('Y-m-d H:i:s')
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function print(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $transactions = \App\Models\Transaction::with('wallet')
            ->whereHas('wallet', fn($q) => $q->where('user_id', Auth::id()))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        return view('reports.print', compact('transactions', 'totalIncome', 'totalExpense', 'year', 'month'));
    }


}
