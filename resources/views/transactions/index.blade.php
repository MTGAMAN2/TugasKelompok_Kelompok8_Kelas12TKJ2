@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
    <h2 class="text-2xl font-bold mb-6 text-purple-600 dark:text-purple-400">📑 Daftar Transaksi</h2>

    <!-- Form Tambah -->
    <form action="{{ route('transactions.store') }}" method="POST" class="grid md:grid-cols-5 gap-4 mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-inner">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">💳 Dompet</label>
            <select name="wallet_id" class="w-full rounded p-2 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600" required>
                <option value="">-- Pilih --</option>
                @foreach($wallets as $wallet)
                    <option value="{{ $wallet->id }}">{{ $wallet->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">📂 Jenis</label>
            <select name="type" class="w-full rounded p-2 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600" required>
                <option value="income">Pemasukan</option>
                <option value="expense">Pengeluaran</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">🏷 Kategori</label>
            <select name="category_id" class="w-full rounded p-2 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600" required>
                <option value="">-- Pilih --</option>
                <option value="food">Makanan</option>
                <option value="transport">Transportasi</option>
                <option value="shopping">Belanja</option>
                <option value="salary">Gaji</option>
                <option value="gift">Hadiah</option>
                <option value="other">Lainnya</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">💰 Jumlah</label>
            <input type="text" id="amountIndex" name="amount" class="w-full rounded p-2 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600" placeholder="Rp 0" required>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-semibold shadow-lg hover:opacity-90">➕ Tambah</button>
        </div>
    </form>

    <!-- List Transactions -->
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-purple-100 dark:bg-purple-900 text-left">
                    <th class="p-3">Dompet</th>
                    <th class="p-3">Jenis</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Jumlah</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="p-3">{{ $trx->wallet->name }}</td>
                    <td class="p-3 capitalize">{{ $trx->type }}</td>
                    <td class="p-3 capitalize">{{ $trx->category ?? '-' }}</td>
                    <td class="p-3 font-semibold {{ $trx->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format($trx->amount,0,',','.') }}
                    </td>
                    <td class="p-3">{{ $trx->description }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('transactions.edit', $trx->id) }}" class="text-blue-600 hover:underline">✏️ Edit</a>
                        <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus transaksi ini?')" class="text-red-600 hover:underline">🗑 Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('amountIndex');

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