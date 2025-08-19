@extends('layouts.app')
@section('title','Beli Barang')
@section('content')
<h1 class="text-xl font-semibold mb-4">🛒 Beli Barang</h1>
<form method="POST" action="{{ route('purchase.store') }}" class="bg-white p-4 rounded shadow grid md:grid-cols-2 gap-4">
  @csrf
  <div>
    <label class="block text-sm">Wallet</label>
    <select name="wallet_id" class="border rounded p-2 w-full" required>
      @foreach($wallets as $w)<option value="{{ $w->id }}">{{ $w->name }} — Saldo: Rp {{ number_format($w->balance,0,',','.') }}</option>@endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm">Kategori</label>
    <select name="category_id" class="border rounded p-2 w-full" required>
      @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm">Jumlah</label>
    <input type="number" step="0.01" min="0.01" name="amount" class="border rounded p-2 w-full" required>
  </div>
  <div>
    <label class="block text-sm">Tanggal</label>
    <input type="date" name="transacted_at" value="{{ now()->toDateString() }}" class="border rounded p-2 w-full" required>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm">Catatan (opsional)</label>
    <input type="text" name="note" class="border rounded p-2 w-full">
  </div>
  <div class="md:col-span-2">
    <button class="px-4 py-2 bg-emerald-600 text-white rounded">Bayar & Potong Saldo</button>
  </div>
</form>
@endsection
