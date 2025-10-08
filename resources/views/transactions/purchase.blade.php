@extends('layouts.app')
@section('title','🛒 Beli Barang')

@section('content-body')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
    <h1 class="text-2xl font-bold mb-6 text-purple-600 dark:text-purple-400">🛒 Beli Barang</h1>

    <form method="POST" action="{{ route('purchase.store') }}" class="grid md:grid-cols-2 gap-6">
      @csrf

      <!-- Wallet -->
      <div>
        <label class="block text-sm font-medium mb-1">💳 Dompet</label>
        <select name="wallet_id" class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600" required>
          @foreach($wallets as $w)
            <option value="{{ $w->id }}">{{ $w->name }} — Saldo: Rp {{ number_format($w->balance,0,',','.') }}</option>
          @endforeach
        </select>
      </div>

      <!-- Category -->
      <div>
        <label class="block text-sm font-medium mb-1">🏷 Kategori</label>
        <select name="category_id" class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600" required>
          @foreach($categories as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Amount -->
      <div>
        <label class="block text-sm font-medium mb-1">💰 Jumlah</label>
        <input type="number" step="0.01" min="0.01" name="amount"
              class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600" required>
      </div>

      <!-- Date -->
      <div>
        <label class="block text-sm font-medium mb-1">📅 Tanggal</label>
        <input type="date" name="transacted_at" value="{{ now()->toDateString() }}"
              class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600" required>
      </div>

      <!-- Note -->
      <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">📝 Catatan (opsional)</label>
        <input type="text" name="note"
              class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600">
      </div>

      <!-- Submit -->
      <div class="md:col-span-2">
        <button class="w-full px-5 py-3 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-500 hover:opacity-90 text-white font-semibold shadow-lg">
          Bayar
        </button>
      </div>
    </form>
</div>
@endsection
