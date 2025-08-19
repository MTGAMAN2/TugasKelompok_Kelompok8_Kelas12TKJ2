@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="grid md:grid-cols-3 gap-4">
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Pemasukan Bulan Ini</div>
    <div class="text-2xl font-bold">Rp {{ number_format($income,0,',','.') }}</div>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Pengeluaran Bulan Ini</div>
    <div class="text-2xl font-bold">Rp {{ number_format($expense,0,',','.') }}</div>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Selisih</div>
    <div class="text-2xl font-bold">Rp {{ number_format($income - $expense,0,',','.') }}</div>
  </div>
</div>

<div class="mt-6 bg-white p-4 rounded shadow">
  <h2 class="font-semibold mb-2">Arus Kas 6 Bulan</h2>
  <canvas id="cashflowChart" height="100"></canvas>
</div>

<div class="mt-6 bg-white p-4 rounded shadow">
  <h2 class="font-semibold mb-2">Top Kategori Pengeluaran</h2>
  <ul class="list-disc list-inside">
    @forelse($topCategories as $row)
      <li>{{ $row->name }} — Rp {{ number_format($row->total,0,',','.') }}</li>
    @empty
      <li>Belum ada data</li>
    @endforelse
  </ul>
</div>

<script>
fetch('{{ url('/api/chart/summary') }}', {headers: {'X-Requested-With':'XMLHttpRequest'}})
  .then(r=>r.json())
  .then(data=>{
    const labels = Object.keys(data);
    const income = labels.map(k=>data[k].income);
    const expense = labels.map(k=>data[k].expense);
    new Chart(document.getElementById('cashflowChart'),{
      type:'line',
      data:{ labels, datasets:[
        { label:'Income', data:income },
        { label:'Expense', data:expense }
      ]}
    });
  });
</script>
@endsection
