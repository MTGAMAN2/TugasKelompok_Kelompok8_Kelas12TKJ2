@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 text-white">
    <h1 class="text-2xl font-semibold mb-6">Budgets</h1>

    {{-- Create Budget --}}
    <div class="bg-gray-800 rounded shadow p-4 mb-6">
        <form method="POST" action="{{ route('budgets.store') }}" class="grid md:grid-cols-4 gap-3">
            @csrf

            <select name="category_id" class="border rounded px-3 py-2 bg-gray-700 text-white" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <input name="amount" type="number" step="0.01" min="0.01"
                class="border rounded px-3 py-2 bg-gray-700 text-white"
                placeholder="Jumlah Budget (Rp)" required>

            <input name="start_date" type="date"
                class="border rounded px-3 py-2 bg-gray-700 text-white" required>

            <input name="end_date" type="date"
                class="border rounded px-3 py-2 bg-gray-700 text-white" required>

            <button class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded col-span-4 md:col-span-1">
                Create Budget
            </button>
        </form>
    </div>

    {{-- List Budgets --}}
    <div class="grid md:grid-cols-2 gap-4">
        @forelse($budgets as $b)
            @php
                $spent = $b->transactions->sum('amount');
                $p = $b->amount > 0 ? round($spent / $b->amount * 100) : 0;
            @endphp

            <div class="bg-gray-800 rounded shadow p-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-lg">{{ $b->category->name ?? 'Tanpa Kategori' }}</h3>
                    <form action="{{ route('budgets.destroy',$b) }}" method="POST" onsubmit="return confirm('Delete budget?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-600">Delete</button>
                    </form>
                </div>

                <div class="mt-2 text-gray-300">
                    Limit: Rp {{ number_format($b->amount,0,',','.') }}
                </div>
                <div class="mt-1 text-gray-400 text-sm">
                    Periode: {{ $b->start_date }} → {{ $b->end_date }}
                </div>

                {{-- Progress Bar --}}
                <div class="w-full bg-gray-700 rounded h-4 mt-3">
                    <div class="h-4 rounded
                        {{ $p < 70 ? 'bg-green-500' : ($p < 100 ? 'bg-yellow-500' : 'bg-red-600') }}"
                        style="width: {{ min($p,100) }}%">
                    </div>
                </div>

                <div class="mt-1 text-sm text-gray-400">
                    Terpakai: Rp {{ number_format($spent,0,',','.') }} ({{ $p }}%)
                </div>
            </div>
        @empty
            <div class="text-gray-400">Belum ada budget.</div>
        @endforelse
    </div>
</div>
@endsection
