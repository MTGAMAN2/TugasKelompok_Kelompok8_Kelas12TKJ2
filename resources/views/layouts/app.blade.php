<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }} - @yield('title')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-gray-100">
  <nav class="bg-white border-b">
    <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
      <a href="{{ route('dashboard') }}" class="font-semibold">💰 MoneyWise</a>
      <div class="flex gap-4">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('transactions.index') }}">Transaksi</a>
        <a href="{{ route('wallets.index') }}">Wallet</a>
        <a href="{{ route('categories.index') }}">Kategori</a>
        <a href="{{ route('budgets.index') }}">Budgets</a>
        <a href="{{ route('bills.index') }}">Bills</a>
        <a href="{{ route('goals.index') }}">Goals</a>
        <a href="{{ route('reports.index') }}">Reports</a>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="text-red-600">Logout</button>
      </form>
    </div>
  </nav>

  <main class="mx-auto max-w-7xl p-6">
    @if(session('success'))
      <div class="mb-4 rounded bg-green-100 p-3 text-green-800">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="mb-4 rounded bg-red-100 p-3 text-red-800">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif
    @yield('content')
  </main>
</body>
</html>
