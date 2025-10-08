@extends('layouts.app')

@section('content-body')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-">My Goals</h1>
    <div class="flex justify-front mb-4 space-y-6">
        <a href="{{ route('goals.create') }}" 
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
            ➕ Create Goal
        </a>
    </div>
    <br>

    <div class="space-y-6">
        @foreach($goals as $goal)
            <div class="bg-white-800 p-4 rounded-lg border border-black">
                <h2 class="text-xl font-semibold">{{ $goal->name }}</h2>

                <p>Target: Rp{{ number_format($goal->target_amount, 0) }}</p>
                <p>Saved: Rp{{ number_format($goal->current_amount, 0) }}</p>

                @php
                    $progress = ($goal->target_amount > 0) 
                    ? min(100, ($goal->current_amount / $goal->target_amount) * 100) :  
                    0;
                @endphp
                <div class="w-full bg-gray-600 h-3 rounded">
                    <div class="bg-green-500 h-3 rounded" style="width: {{ $progress }}%"></div>
                </div>

                <form action="{{ route('goals.contribute', $goal->id) }}" method="POST" class="mt-3 flex space-x-2">
                    @csrf
                    <input type="number" name="amount" placeholder="Amount" class="px-3 py-2 rounded text-black" required>
                    <select name="wallet_id" class="px-2 py-1 rounded text-black">
                        @foreach(Auth::user()->wallets as $wallet)
                            <option value="{{ $wallet->id }}">{{ $wallet->name }} (Rp{{ number_format($wallet->balance,0) }})</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded">Contribute</button>
                </form>
                <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" onsubmit="retur confirm('Are you sure you want to delete this goal?')"class="mt-2">
                    @csrf
                        @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"> Delete
                            </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
