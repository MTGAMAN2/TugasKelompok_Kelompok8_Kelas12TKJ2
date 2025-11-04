@extends('layouts.app')

@section('content-body')
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold dark:text-white">Categories</h1>
        <a href="{{ route('categories.create') }}"
    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-purple-700">
    <i class="fas fa-plus text-white mr-1"></i> Add Category
</a>
    </div>


    <form class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="date" name="from" value="{{ $from }}"
            class="border rounded px-3 py-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
        <input type="date" name="to" value="{{ $to }}"
            class="border rounded px-3 py-2 dark:bg-gray-700 dark:text-white dark:border-gray-600">
        <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-gray-900">Apply Range</button>
        <a href="{{ route('categories.index') }}"
        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600">
            Reset
        </a>
    </form>

  
    <div class="bg-white dark:bg-gray-800 rounded shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="text-left px-4 py-2 dark:text-gray-200">Name</th>
                    <th class="text-right px-4 py-2 dark:text-gray-200">
                        Expense ({{ \Carbon\Carbon::parse($from)->format('d M') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }})
                    </th>
                    <th class="px-4 py-2 text-right"></th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $c)
                <tr class="border-t dark:border-gray-600">
                    <td class="px-4 py-2 dark:text-white">{{ $c->name }}</td>
                    <td class="px-4 py-2 text-right dark:text-gray-200">
                        Rp {{ number_format($stats[$c->id]->total ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('categories.edit',$c) }}"
                        class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('categories.destroy',$c) }}"
                            method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Delete category?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        No categories.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
