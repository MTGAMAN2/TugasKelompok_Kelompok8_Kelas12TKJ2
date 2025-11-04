@extends('layouts.app')

@section('content-body')
<div class="p-6  mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold dark:text-white">My Goals</h1>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <a href="{{ route('goals.create') }}" 
    class="bg-indigo-600 hover:bg-indigo-800 text-white px-4 py-2 rounded shadow transition">
    <i class="fas fa-plus text-white"></i> Create Goal
</a>
    </div>

    <div class="space-y-6">
        @forelse($goals as $goal)
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border dark:border-gray-700">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $goal->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Target: Rp{{ number_format($goal->target_amount, 0) }} • Saved: Rp{{ number_format($goal->current_amount, 0) }}</p>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ optional($goal->deadline)->toDateString() ?? '' }}</div>
                </div>

                @php
                    $progress = ($goal->target_amount > 0)
                        ? min(100, ($goal->current_amount / $goal->target_amount) * 100)
                        : 0;
                @endphp
                <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 h-3 rounded">
                    <div class="bg-green-500 h-3 rounded" style="width: {{ $progress }}%"></div>
                </div>

                <div class="mt-3 flex flex-col md:flex-row md:items-center md:space-x-3 space-y-2 md:space-y-0">
                    <form action="{{ route('goals.contribute', $goal->id) }}" method="POST" class="flex-1 flex items-center space-x-2">
                        @csrf
                            <input type="text" name="amount" placeholder="Amount" class="amount-input flex-none w-40 md:w-48 border rounded px-3 py-2 dark:bg-gray-900 text-black" required>
                            <select name="wallet_id" class="flex-1 px-3 py-2 rounded text-black border">
                            @foreach(Auth::user()->wallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->name }} (Rp{{ number_format($wallet->balance,0) }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Contribute</button>
                    </form>

                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this goal?')" class="mt-2 md:mt-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow text-center text-gray-500">No goals yet.</div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.amount-input').forEach(function (input) {
        input.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value) {
                e.target.value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            } else {
                e.target.value = '';
            }
        });

        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                input.value = input.value.replace(/[^0-9]/g, '');
            });
        }
    });
});
</script>
@endpush