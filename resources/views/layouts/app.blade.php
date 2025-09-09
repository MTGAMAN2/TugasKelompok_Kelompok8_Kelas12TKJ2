<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'MoneyWise' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
<div class="min-h-screen flex">
  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-purple-700 to-indigo-800 dark:from-gray-800 dark:to-gray-900 text-white flex flex-col shadow-lg">
    <div class="p-4 text-2xl font-extrabold tracking-wide border-b border-purple-600">
      🚀 MoneyWise
    </div>

    <nav class="flex-1 p-4 space-y-3 text-sm font-medium">
      <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-grid-1x2"></i> Dashboard</a>
      <a href="{{ route('transactions.index') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-credit-card"></i> Transactions</a>
      <a href="{{ route('wallets.index') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-wallet"></i> Wallets</a>
      <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-tag"></i> Categories</a>
      <a href="{{ route('budgets.index') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-graph-up-arrow"></i></i> Budgets</a>
      <a href="{{ route('goals.index') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-bullseye"></i>  Goals</a>
      <a href="{{ route('reports.index') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-clipboard-data"></i> Reports</a>
      <a href="{{ route('purchase.create') }}" class="block px-3 py-2 rounded hover:bg-purple-600 dark:hover:bg-gray-700"><i class="bi bi-cart3"></i> Quick Purchase </a>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-purple-600 flex justify-between items-center">
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="px-3 py-2 rounded bg-red-600 hover:bg-red-700 w-full text-center">🚪 Log out</button>
      </form>
      <button id="theme-toggle" class="ml-2 px-3 py-2 rounded bg-gray-200 dark:bg-gray-700 dark:text-gray-100">🌙</button>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6 overflow-y-auto">
    <x-flash />
    @yield('content')
  </main>
</div>

<!-- Dark Mode Toggle Script -->
<script>
  const toggle = document.getElementById('theme-toggle');
  const html = document.documentElement;

  toggle.addEventListener('click', () => {
    html.classList.toggle('dark');
    if (html.classList.contains('dark')) {
      localStorage.setItem('theme', 'dark');
      toggle.textContent = '☀️';
    } else {
      localStorage.setItem('theme', 'light');
      toggle.textContent = '🌙';
    }
  });

  if (localStorage.getItem('theme') === 'dark') {
    html.classList.add('dark');
    toggle.textContent = '☀️';
  } else {
    html.classList.remove('dark');
    toggle.textContent = '🌙';
  }
</script>

</body>
</html>
