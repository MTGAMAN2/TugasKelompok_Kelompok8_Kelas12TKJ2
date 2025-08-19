<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.index');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $user = $request->user();
        $fileName = 'transactions_'.now()->format('Ymd_His').'.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$fileName"];

        $callback = function() use ($user){
            $handle = fopen('php://output','w');
            fputcsv($handle, ['Tanggal','Tipe','Kategori','Wallet','Jumlah','Catatan']);
            Transaction::with(['category','wallet'])->where('user_id',$user->id)->chunk(500, function($rows) use ($handle){
                foreach($rows as $t){
                    fputcsv($handle, [
                        $t->transacted_at->format('Y-m-d'),
                        $t->type,
                        $t->category->name ?? '-',
                        $t->wallet->name,
                        $t->amount,
                        $t->note
                    ]);
                }
            });
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
