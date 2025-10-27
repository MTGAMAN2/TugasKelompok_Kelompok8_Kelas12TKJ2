@extends('layouts.app')

@section('content-body')
<div class="p-6">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Budgets</h1>
    <a href="{{ route('budgets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow">➕ New Budget</a>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    @forelse($budgets as $b)
      @php
        $spent = $b->spent();
        $progress = $b->progress();
        $status = $b->status();
        $barClass = $status === 'over' ? 'bg-red-600' : ($status === 'warning' ? 'bg-yellow-500' : 'bg-green-500');
      @endphp

      <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border dark:border-gray-700">
        <div class="flex justify-between items-start">
          <div>
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $b->category->name }}</div>
            <h3 class="text-lg font-semibold mt-1">{{ $b->name ?: ('Budget - '.$b->category->name) }}</h3>
          </div>
          <div class="text-right">
            <div class="text-sm text-gray-500">Limit</div>
            <div class="font-bold">Rp {{ number_format($b->limit_amount,0,',','.') }}</div>
          </div>
        </div>

        <div class="mt-3">
          <div class="text-sm text-gray-500">Spent: Rp {{ number_format($spent,0,',','.') }}</div>
          <div class="w-full bg-gray-200 dark:bg-gray-700 h-3 rounded mt-2 overflow-hidden">
            <div class="{{ $barClass }} h-3 rounded" style="width: {{ $progress }}%"></div>
          </div>
          <div class="mt-2 text-xs text-gray-400">Progress: {{ $progress }}%</div>
        </div>

        <div class="mt-3 flex gap-2">
          <a href="{{ route('budgets.edit', $b) }}" class="text-indigo-600">Edit</a>
          <form action="{{ route('budgets.destroy', $b) }}" method="POST" onsubmit="return confirm('Delete budget?')">
            @csrf @method('DELETE')
            <button class="text-red-600">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="md:col-span-2 text-center text-gray-500">No budgets yet. Create one to track expenses per category.</div>
    @endforelse
  </div>
</div>
@endsection
