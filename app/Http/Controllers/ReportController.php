<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('wallet')
            ->whereHas('wallet', fn($q) => $q->where('user_id', Auth::id()));

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $transactions = $query->latest()->get();

        return view('reports.index', compact('transactions'));
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
                $t->type,
                $t->amount,
                $t->description,
                $t->created_at
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function exportPdf()
    {
        $transactions = Transaction::with('wallet')
            ->whereHas('wallet', fn($q) => $q->where('user_id', Auth::id()))
            ->get();

        $pdf = Pdf::loadView('reports.pdf', compact('transactions'));
        return $pdf->download('report.pdf');
    }
}
