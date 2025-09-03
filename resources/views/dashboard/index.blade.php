@extends('layouts.app')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div>
    <h1 class="text-2xl font-bold">📊 Dashboard</h1>
    <p class="text-gray-600 dark:text-gray-400">Ringkasan keuangan bulan ini</p>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
      <h2 class="text-sm text-gray-500 dark:text-gray-400">Pemasukan Bulan Ini</h2>
      <p class="text-2xl font-bold text-green-600">Rp {{ number_format($income ?? 0) }}</p>
    </div>
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
      <h2 class="text-sm text-gray-500 dark:text-gray-400">Pengeluaran Bulan Ini</h2>
      <p class="text-2xl font-bold text-red-600">Rp {{ number_format($expense ?? 0) }}</p>
    </div>
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
      <h2 class="text-sm text-gray-500 dark:text-gray-400">Selisih</h2>
      <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format(($income ?? 0) - ($expense ?? 0)) }}</p>
    </div>
  </div>

  <!-- Grafik Placeholder -->
  <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
    <h2 class="text-lg font-bold mb-4">📈 Arus Kas 6 Bulan</h2>
    <div class="h-64 flex items-center justify-center text-gray-400 dark:text-gray-600">
      (Grafik Arus Kas di sini)
    </div>
  </div>

  <!-- Top Kategori -->
  <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
    <h2 class="text-lg font-bold mb-4">🏷 Top Kategori Pengeluaran</h2>
    @if(empty($topCategories))
      <p class="text-gray-500 dark:text-gray-400">Belum ada data</p>
    @else
      <ul class="list-disc list-inside">
        @foreach($topCategories as $category)
          <li>{{ $category->name }} - Rp {{ number_format($category->amount) }}</li>
        @endforeach
      </ul>
    @endif
  </div>

</div>
@endsection
