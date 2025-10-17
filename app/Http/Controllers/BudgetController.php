<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with('category')
            ->where('user_id', Auth::id())
            ->get();

         $categories = Category::all();

        return view('budgets.index', compact('budgets', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'limit' => 'required|numeric|min:0'
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'limit' => $request->limit,
            'spent' => 0
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget berhasil ditambahkan.');
    }
}
