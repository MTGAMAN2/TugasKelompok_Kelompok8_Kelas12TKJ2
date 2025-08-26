@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Reports</h1>

    <form class="bg-white rounded shadow p-4 mb-6 grid md:grid-cols-4 gap-3">
        <select name="year" class="border rounded px-3 py-2" onchange="this.form.submit()">
            @for($y = now()->year - 3; $y <= now()->year + 1; $y++)
                <option value="{{ $y }}" @selected($year==$y)>{{ $y }}</option>
            @endfor
        </select>
        <select name="month" class="border rounded px-3 py-2" onchange="this.form.submit()">
            @for($m=1;$m<=12;$m++)
                <option value="{{ $m }}" @selected($month==$m)>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
            @endfor
        </select>
        <a href="{{ route('reports.export', ['from'=>\Carbon\Carbon::create($year,$month,1)->startOfMonth()->toDateString(),'to'=>\Carbon\Carbon::create($year,$month,1)->endOfMonth()->toDateString()]) }}" class="px-4 py-2 bg-gray-800 text-white rounded">Export CSV</a>
    </form>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-2">Income vs Expense ({{ $year }})</h3>
            <canvas id="lineChart" height="160"></canvas>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-2">Expense by Category ({{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }})</h3>
            <canvas id="pieChart" height="160"></canvas>
        </div>
    </div>
</div>

{{-- Chart.js CDN (ringan, tanpa setup Vite) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const monthly = @json($monthly);
const labels = monthly.map(m => new Date(0, m.month-1).toLocaleString('en',{month:'short'}));
const income = monthly.map(m => Number(m.income));
const expense = monthly.map(m => Number(m.expense));

new Chart(document.getElementById('lineChart'), {
  type: 'bar',
  data: {
    labels,
    datasets: [
      { label: 'Income', data: income },
      { label: 'Expense', data: expense }
    ]
  }
});

const cat = @json($category);
new Chart(document.getElementById('pieChart'), {
  type: 'pie',
  data: {
    labels: cat.map(c => c.name),
    datasets: [{ data: cat.map(c => Number(c.total)) }]
  }
});
</script>
@endsection
