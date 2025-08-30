@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
    <h2 class="text-2xl font-bold mb-6 text-purple-600 dark:text-purple-400">
        {{ $isEdit ? '✏️ Edit' : '➕ Tambah' }} Transaksi
    </h2>

    <form action="{{ $isEdit ? route('transactions.update', $transaction->id) : route('transactions.store') }}" method="POST" class="space-y-4">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <!-- Wallet -->
        <div>
            <label class="block mb-1 font-semibold">💳 Dompet <span class="text-red-500">*</span></label>
            <select name="wallet_id" required
                class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600">
                <option value="">-- Pilih Dompet --</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}" {{ $isEdit && $transaction->wallet_id == $wallet->id ? 'selected' : '' }}>
                        {{ $wallet->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Type -->
        <div>
            <label class="block mb-1 font-semibold">📂 Jenis <span class="text-red-500">*</span></label>
            <select name="type" required
                class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600">
                <option value="income" {{ $isEdit && $transaction->type == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ $isEdit && $transaction->type == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>

        <!-- Amount -->
        <div>
            <label class="block mb-1 font-semibold">💰 Jumlah (Rp) <span class="text-red-500">*</span></label>
            <input type="text" id="amount" name="amount"
                value="{{ $isEdit ? 'Rp ' . number_format($transaction->amount,0,',','.') : old('amount') }}"
                required class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600"
                placeholder="Rp 0">
        </div>

        <!-- Description -->
        <div>
            <label class="block mb-1 font-semibold">📝 Deskripsi</label>
            <textarea name="description" rows="3"
                class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600">{{ $isEdit ? $transaction->description : old('description') }}</textarea>
        </div>

        <!-- Actions -->
        <div class="pt-4">
            <button type="submit"
                class="px-5 py-2 rounded-lg bg-gradient-to-r from-purple-600 to-pink-500 hover:opacity-90 text-white font-semibold shadow-lg">
                {{ $isEdit ? '💾 Update' : '✅ Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('amount');

    // Format input saat diketik menjadi Rp xxx.xxx
    input.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value) {
            e.target.value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        } else {
            e.target.value = '';
        }
    });

    // Saat submit, kirim hanya angka ke backend
    const form = input.closest('form');
    form.addEventListener('submit', function () {
        input.value = input.value.replace(/[^0-9]/g, '');
    });
});
</script>
@endpush

