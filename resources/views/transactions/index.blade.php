@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Transactions</h2>

    <!-- Form Tambah Transaksi -->
    <form action="{{ route('transactions.store') }}" method="POST" class="grid md:grid-cols-5 gap-4 mb-6">
        @csrf
        <div class="md:col-span-1">
            <label class="block text-sm mb-1">Wallet</label>
            <select name="wallet_id" class="w-full border rounded p-2" required>
                <option value="">-- Select Wallet --</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-1">
            <label class="block text-sm mb-1">Type</label>
            <select name="type" class="w-full border rounded p-2" required>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div>
        <div class="md:col-span-1">
            <label class="block text-sm mb-1">Category</label>
            <select name="category" class="w-full border rounded p-2" required>
                <option value="">-- Select Category --</option>
                <option value="food">Food</option>
                <option value="transport">Transport</option>
                <option value="shopping">Shopping</option>
                <option value="salary">Salary</option>
                <option value="gift">Gift</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="md:col-span-1">
            <label class="block text-sm mb-1">Amount</label>
            <input type="text" id="amountIndex" name="amount" class="w-full border rounded p-2" placeholder="Rp 0" required>
        </div>
        <div class="md:col-span-1 flex items-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add</button>
        </div>
    </form>

    <!-- List Transactions -->
    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Wallet</th>
                <th class="border p-2">Type</th>
                <th class="border p-2">Category</th>
                <th class="border p-2">Amount</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td class="border p-2">{{ $trx->wallet->name }}</td>
                <td class="border p-2 capitalize">{{ $trx->type }}</td>
                <td class="border p-2 capitalize">{{ $trx->category ?? '-' }}</td>
                <td class="border p-2">Rp {{ number_format($trx->amount,0,',','.') }}</td>
                <td class="border p-2">{{ $trx->description }}</td>
                <td class="border p-2">
                    <a href="{{ route('transactions.edit', $trx->id) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this transaction?')" class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('amountIndex');
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
