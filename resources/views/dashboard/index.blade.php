@extends('layouts.app')

@section('content-body')
<div class="space-y-6">


  <div>
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <p class="text-gray-600">Ringkasan keuangan bulan ini</p>
  </div>


  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card p-5">
      <div class="text-sm text-gray-500">Pemasukan Bulan Ini</div>
      <div class="text-2xl font-bold text-green-600 mt-2">
        Rp {{ number_format($income ?? 0) }}
      </div>
    </div>

    <div class="card p-5">
      <div class="text-sm text-gray-500">Pengeluaran Bulan Ini</div>
      <div class="text-2xl font-bold text-red-600 mt-2">
        Rp {{ number_format($expense ?? 0) }}
      </div>
    </div>

    <div class="card p-5">
      <div class="text-sm text-gray-500">Selisih</div>
      <div class="text-2xl font-bold text-yellow-600 mt-2">
        Rp {{ number_format(($income ?? 0) - ($expense ?? 0)) }}
      </div>
    </div>
  </div>


  <div class="card big-round p-6">
    <div class="flex justify-between items-center mb-4">
      <div>
        <div class="text-sm text-gray-500">Arus Kas</div>
        <div class="text-xs text-gray-400">6 Bulan Terakhir</div>
      </div>
      <div class="flex items-center gap-3">
        <div class="toggle-pill flex items-center gap-1">
          <button id="btn-months" class="px-3 py-1 rounded-full text-sm bg-indigo-600 text-white">Months</button>
          <button id="btn-years" class="px-3 py-1 rounded-full text-sm">Years</button>
        </div>
      </div>
    </div>
    <div class="mt-3">
      <canvas id="lineChart" height="140" class="w-full"></canvas>
    </div>
  </div>

 
  <div class="card p-6">
    <h3 class="font-semibold text-gray-700 mb-3">Top Kategori Pengeluaran</h3>
    @if(empty($topCategories) || $topCategories->isEmpty())
      <p class="text-gray-400">Belum ada data</p>
    @else
      <ul class="space-y-2">
        @foreach($topCategories as $category)
          <li class="flex justify-between">
            <span>{{ $category->name }}</span>
            <span class="font-medium">Rp {{ number_format($category->total) }}</span>
          </li>
        @endforeach
      </ul>
    @endif
  </div>

</div>
@endsection

@push('scripts')
<script>
  const labels = {!! json_encode($chartLabels ?? ['Jan','Feb','Mar','Apr','May','Jun']) !!};
  const values = {!! json_encode($chartData ?? [120000,90000,150000,110000,180000,160000]) !!};

  (function(){
    const ctx = document.getElementById('lineChart')?.getContext('2d');
    if(!ctx) return;
    const grad = ctx.createLinearGradient(0,0,0,220);
    grad.addColorStop(0, 'rgba(107,99,255,0.18)');
    grad.addColorStop(1, 'rgba(107,99,255,0.02)');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Jumlah',
          data: values,
          fill: true,
          backgroundColor: grad,
          borderColor: 'rgba(107,99,255,0.95)',
          tension: 0.45,
          pointRadius: 6,
          pointBackgroundColor: '#fff',
          pointBorderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false }, ticks: { color: '#8b8fa6' } },
          y: { grid: { color: '#eef0fb' }, ticks: { color: '#8b8fa6' } }
        }
      }
    });
  })();

  document.getElementById('btn-months')?.addEventListener('click', ()=>{
    document.getElementById('btn-months').classList.add('bg-indigo-600','text-white');
    document.getElementById('btn-years').classList.remove('bg-indigo-600','text-white');
  });
  document.getElementById('btn-years')?.addEventListener('click', ()=>{
    document.getElementById('btn-years').classList.add('bg-indigo-600','text-white');
    document.getElementById('btn-months').classList.remove('bg-indigo-600','text-white');
  });
</script>
@endpush
