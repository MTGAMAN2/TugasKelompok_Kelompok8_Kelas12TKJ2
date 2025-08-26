<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'MoneyWise' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
<div class="min-h-screen flex">
  <!-- Sidebar -->
  <aside class="w-64 bg-blue-800 text-white flex flex-col">
    <div class="p-4 text-xl font-bold border-b border-blue-600">MoneyWise</div>
    <nav class="flex-1 p-4 space-y-2">
      <a href="{{ route('dashboard') }}" class="block hover:text-yellow-300">🏠 Dashboard</a>
      <a href="{{ route('transactions.index') }}" class="block hover:text-yellow-300">💳 Transactions</a>
      <a href="{{ route('wallets.index') }}" class="block hover:text-yellow-300">👛 Wallets</a>
      <a href="{{ route('categories.index') }}" class="block hover:text-yellow-300">🏷 Categories</a>
      <a href="{{ route('budgets.index') }}" class="block hover:text-yellow-300">📊 Budgets</a>
      <a href="{{ route('goals.index') }}" class="block hover:text-yellow-300">🎯 Goals</a>
      <a href="{{ route('reports.index') }}" class="block hover:text-yellow-300">📈 Reports</a>
      <a href="{{ route('purchase.create') }}" class="block hover:text-yellow-300">🛒 Quick Purchase</a>
    </nav>
    <div class="p-4 border-t border-blue-600">
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="w-full text-left">🚪 Log out</button>
      </form>
    </div>
  </aside>

  <main class="flex-1 p-6">
    <x-flash />
    @yield('content')
  </main>
</div>
</body>
</html>
