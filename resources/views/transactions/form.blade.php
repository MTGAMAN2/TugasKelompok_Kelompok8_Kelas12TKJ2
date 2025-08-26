@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">{{ $isEdit ? 'Edit' : 'Add' }} Transaction</h2>
    <form action="{{ $isEdit ? route('transactions.update', $transaction->id) : route('transactions.store') }}" method="POST">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="block mb-1 font-medium">Wallet <span class="text-red-500">*</span></label>
            <select name="wallet_id" required class="w-full border rounded px-3 py-2">
                <option value="">-- Select Wallet --</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}" {{ $isEdit && $transaction->wallet_id == $wallet->id ? 'selected' : '' }}>
                        {{ $wallet->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Type <span class="text-red-500">*</span></label>
            <select name="type" required class="w-full border rounded px-3 py-2">
                <option value="income" {{ $isEdit && $transaction->type == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ $isEdit && $transaction->type == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Amount (Rp) <span class="text-red-500">*</span></label>
            <input type="text" id="amount" name="amount"
                   value="{{ $isEdit ? 'Rp ' . number_format($transaction->amount,0,',','.') : old('amount') }}"
                   required class="w-full border rounded px-3 py-2" placeholder="Rp 0">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ $isEdit ? $transaction->description : old('description') }}</textarea>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                {{ $isEdit ? 'Update' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('amount');
    input.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value) {
            e.target.value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        } else {
            e.target.value = '';
        }
    });
});
</script>
@endpush
