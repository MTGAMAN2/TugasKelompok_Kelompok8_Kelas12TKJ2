@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Budgets</h1>
        <a href="{{ route('budgets.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Add Budget</a>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        @forelse($budgets as $b)
            <div class="bg-white rounded shadow p-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">{{ $b->name ?? $b->category->name }}</h3>
                    <form action="{{ route('budgets.destroy',$b) }}" method="POST" onsubmit="return confirm('Delete budget?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </div>

                <div class="mt-2 text-gray-600">Limit: Rp {{ number_format($b->limit_amount,0,',','.') }}</div>
                <div class="text-gray-600">Spent: Rp {{ number_format($b->spent,0,',','.') }}</div>
                <div class="text-gray-600">Remaining: Rp {{ number_format($b->remaining,0,',','.') }}</div>

                <div class="mt-3 w-full bg-gray-200 rounded h-2">
                    <div class="bg-blue-600 h-2 rounded" style="width: {{ min(100,$b->progress) }}%"></div>
                </div>

                <div class="mt-2 text-sm text-gray-500">
                    Period: {{ $b->start_date ? \Carbon\Carbon::parse($b->start_date)->format('d M Y') : 'Start of month' }}
                    –
                    {{ $b->end_date ? \Carbon\Carbon::parse($b->end_date)->format('d M Y') : 'End of month' }}
                </div>

                <div class="mt-3">
                    <a href="{{ route('budgets.edit',$b) }}" class="text-blue-600">Edit</a>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 text-center text-gray-500">No budgets yet.</div>
        @endforelse
    </div>
</div>
@endsection
