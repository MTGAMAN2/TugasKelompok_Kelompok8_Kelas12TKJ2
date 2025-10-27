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
        $userId = Auth::id();
        $budgets = Budget::with('category')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->orderBy('name')->get();
        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'nullable|string|max:255',
            'limit_amount'   => 'required|numeric|min:0',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'alert_threshold'=> 'nullable|integer|min:0|max:100',
            'notes'          => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['alert_threshold'] = $data['alert_threshold'] ?? 80;

        Budget::create($data);

        return redirect()->route('budgets.index')->with('success', 'Budget berhasil dibuat.');
    }

    public function edit(Budget $budget)
    {
        abort_if($budget->user_id !== Auth::id(), 403);
        $categories = Category::where('user_id', Auth::id())->orderBy('name')->get();
        return view('budgets.edit', compact('budget','categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        abort_if($budget->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'nullable|string|max:255',
            'limit_amount'   => 'required|numeric|min:0',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'alert_threshold'=> 'nullable|integer|min:0|max:100',
            'notes'          => 'nullable|string',
        ]);

        $budget->update($data);

        return redirect()->route('budgets.index')->with('success', 'Budget diperbarui.');
    }

    public function destroy(Budget $budget)
    {
        abort_if($budget->user_id !== Auth::id(), 403);
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget dihapus.');
    }
}
