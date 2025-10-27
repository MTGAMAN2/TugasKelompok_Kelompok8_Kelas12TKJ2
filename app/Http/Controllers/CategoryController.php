<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $categories = Category::orderBy('name')->get();

        // Statistik pengeluaran per kategori (bulan ini, bisa diubah via query)
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to   = $request->get('to', now()->endOfMonth()->toDateString());

        $stats = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transacted_at', [$from, $to])
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->get()
            ->keyBy('category_id');

        return view('categories.index', [
            'categories' => $categories,
            'stats' => $stats,
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function create() { return view('categories.form'); }

    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:100']);
        // assign the current user as owner (keeps categories scoped), and default type to 'expense'
        $data['user_id'] = $request->user()->id ?? Auth::id();
        $data['type'] = $request->get('type', 'expense');
        Category::create($data);
        return redirect()->route('categories.index')->with('success','Category created');
    }

    public function edit(Category $category) { return view('categories.form', compact('category')); }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name'=>'required|string|max:100']);
        $category->update($data);
        return redirect()->route('categories.index')->with('success','Category updated');
    }

    public function destroy(Category $category)
    {
        // Optional: cek transaksi terkait
        // if ($category->transactions()->exists()) return back()->with('error','Category has transactions');
        $category->delete();
        return back()->with('success','Category deleted');
    }
}
