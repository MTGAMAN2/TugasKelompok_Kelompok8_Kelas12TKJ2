@extends('layouts.app')
@section('title','Transaksi')
@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-xl font-semibold">Transaksi</h1>
  <div class="flex gap-2">
    <a href="{{ route('transactions.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">+ Tambah</a>
    <a href="{{ route('purchase.create') }}" class="px-3 py-2 bg-emerald-600 text-white rounded">🛒 Beli Barang</a>
  </div>
</div>

<form method="GET" class="bg-white p-4 rounded shadow grid md:grid-cols-5 gap-3 mb-4">
  <select name="type" class="border rounded p-2">
    <option value="">Semua Tipe</option>
    <option value="income" @selected(request('type')==='income')>Income</option>
    <option value="expense" @selected(request('type')==='expense')>Expense</option>
  </select>
  <select name="category_id" class="border rounded p-2">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id')==$c->id)>{{ $c->name }}</option>@endforeach
  </select>
  <select name="wallet_id" class="border rounded p-2">
    <option value="">Semua Wallet</option>
    @foreach($wallets as $w)<option value="{{ $w->id }}" @selected(request('wallet_id')==$w->id)>{{ $w->name }}</option>@endforeach
  </select>
  <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded p-2">
  <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded p-2">
  <button class="col-span-full px-3 py-2 bg-gray-800 text-white rounded">Filter</button>
</form>

<div class="bg-white rounded shadow overflow-x-auto">
  <table class="min-w-full">
    <thead class="bg-gray-50">
      <tr>
        <th class="p-2 text-left">Tanggal</th>
        <th class="p-2 text-left">Tipe</th>
        <th class="p-2 text-left">Kategori</th>
        <th class="p-2 text-left">Wallet</th>
        <th class="p-2 text-right">Jumlah</th>
        <th class="p-2 text-left">Catatan</th>
        <th class="p-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
    @forelse($transactions as $t)
      <tr class="border-t">
        <td class="p-2">{{ $t->transacted_at->format('d M Y') }}</td>
        <td class="p-2">{{ ucfirst($t->type) }}</td>
        <td class="p-2">{{ $t->category->name ?? '-' }}</td>
        <td class="p-2">{{ $t->wallet->name }}</td>
        <td class="p-2 text-right {{ $t->type==='income'?'text-emerald-700':'text-red-700' }}">
          {{ $t->type==='income' ? '+' : '-' }} Rp {{ number_format($t->amount,0,',','.') }}
        </td>
        <td class="p-2">{{ $t->note }}</td>
        <td class="p-2">
          <form method="POST" action="{{ route('transactions.destroy',$t) }}" onsubmit="return confirm('Hapus?')">
            @csrf @method('DELETE')
            <button class="text-red-600">Hapus</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td class="p-4" colspan="7">Belum ada data</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $transactions->links() }}</div>
@endsection
