@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Goals</h1>
    </div>

    {{-- Create Goal --}}
    <div class="bg-white rounded shadow p-4 mb-6">
        <form method="POST" action="{{ route('goals.store') }}" class="grid md:grid-cols-4 gap-3">
            @csrf
            <input name="name" class="border rounded px-3 py-2" placeholder="Goal name (e.g. New Laptop)" required>
            <input name="target_amount" type="number" step="0.01" min="0.01" class="border rounded px-3 py-2" placeholder="Target (Rp)" required>
            <input name="due_date" type="date" class="border rounded px-3 py-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Create Goal</button>
        </form>
    </div>

    {{-- List Goals --}}
    <div class="grid md:grid-cols-2 gap-4">
        @forelse($goals as $g)
            <div class="bg-white rounded shadow p-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">{{ $g->name }}</h3>
                    <form action="{{ route('goals.destroy',$g) }}" method="POST" onsubmit="return confirm('Delete goal?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </div>
                <div class="text-gray-600 mt-2">Target: Rp {{ number_format($g->target_amount,0,',','.') }}</div>
                <div class="text-gray-600">Saved: Rp {{ number_format($g->current_amount,0,',','.') }}</div>
                <div class="text-gray-600">Progress:
                    @php $p = $g->target_amount>0 ? round($g->current_amount/$g->target_amount*100) : 0; @endphp
                    {{ $p }}%
                </div>
                <div class="mt-2 w-full bg-gray-200 rounded h-2">
                    <div class="bg-green-600 h-2 rounded" style="width: {{ min(100,$p) }}%"></div>
                </div>
                <div class="text-sm text-gray-500 mt-2">Due: {{ $g->due_date ? \Carbon\Carbon::parse($g->due_date)->format('d M Y') : '-' }}</div>

                {{-- Contribute --}}
                <div class="mt-4">
                    <form method="POST" action="{{ route('goals.contribute', $g) }}" class="grid md:grid-cols-4 gap-3">
                        @csrf
                        <select name="wallet_id" class="border rounded px-3 py-2" required>
                            @foreach($wallets as $w)
                                <option value="{{ $w->id }}">{{ $w->name }} (Rp {{ number_format($w->balance,0,',','.') }})</option>
                            @endforeach
                        </select>
                        <input type="number" step="0.01" min="0.01" name="amount" class="border rounded px-3 py-2" placeholder="Amount" required>
                        <input type="date" name="date" class="border rounded px-3 py-2" value="{{ now()->format('Y-m-d') }}" required>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Contribute</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 text-center text-gray-500">No goals yet.</div>
        @endforelse
    </div>
</div>
@endsection
