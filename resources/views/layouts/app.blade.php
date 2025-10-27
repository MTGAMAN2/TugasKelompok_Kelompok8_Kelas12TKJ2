<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'MoneyWise' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --bg: #f4f6fb;
      --card: #f1f3fb;
      --muted: #7b7f9a;
      --primary: #6b63ff;
      --soft-primary: rgba(107,99,255,0.12);
    }
    body { background: var(--bg); }
    .card { background: white; border-radius: 18px; box-shadow: 0 10px 30px rgba(16,24,40,0.06); }
    .glass { background: linear-gradient(180deg, rgba(255,255,255,0.8), rgba(250,250,255,0.9)); backdrop-filter: blur(6px); }
    .big-round { border-radius: 18px; padding: 22px; }
    .sticky-top { position: sticky; top: 24px; }
    @media (max-width: 1024px) {
      .right-panel { display: none; }
      aside.left { width: 72px; }
      .hide-md { display: none; }
    }
  </style>
</head>
<body class="font-sans antialiased text-gray-800">
  <div class="max-w-[1280px] mx-auto px-6 py-6">
    <div class="flex gap-6">

      <!-- LEFT SIDEBAR -->
      <aside class="left w-64 bg-white rounded-2xl card p-6 flex flex-col">
        <div class="flex items-center gap-3 mb-6">
          <img src="{{ asset('logo.png') }}" alt="logo" class="w-10 h-10 rounded-lg" onerror="this.style.display='none'">
          <div>
            <div class="text-xl font-bold text-indigo-700">MoneyWise</div>
            <div class="text-xs text-gray-400">Smart Finance</div>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-2">
          <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-speedometer2 text-indigo-600"></i>
            <span class="text-sm font-medium hide-md">Dashboard</span>
          </a>
          <a href="{{ route('profile.index') ?? '#' }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-person text-indigo-500"></i>
            <span class="text-sm hide-md">Profile</span>
          </a>
          <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-credit-card text-indigo-500"></i>
            <span class="text-sm hide-md">Transactions</span>
          </a>
          <a href="{{ route('wallets.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-wallet text-indigo-500"></i>
            <span class="text-sm hide-md">Wallets</span>
          </a>
          <a href="{{ route('categories.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-tag text-indigo-500"></i>
            <span class="text-sm hide-md">Categories</span>
          </a>
          <a href="{{ route('budgets.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-graph-up-arrow text-indigo-500"></i>
            <span class="text-sm hide-md">Budgets</span>
          </a>
          <a href="{{ route('goals.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-bullseye text-indigo-500"></i>
            <span class="text-sm hide-md">Goals</span>
          </a>
          <a href="{{ route('reports.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-clipboard-data text-indigo-500"></i>
            <span class="text-sm hide-md">Reports</span>
          </a>
          <a href="{{ route('purchase.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50">
            <i class="bi bi-cart3 text-indigo-500"></i>
            <span class="text-sm hide-md">Quick Purchase</span>
          </a>
        </nav>

        <!-- Logout -->
        <div class="mt-6">
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="w-full px-3 py-2 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 flex items-center justify-center gap-2">
              <i class="bi bi-box-arrow-right"></i><span class="text-sm">Logout</span>
            </button>
          </form>
        </div>
      </aside>

      <!-- CENTER MAIN -->
      <main class="flex-1">
        <!-- Top Bar -->
        <div class="flex items-center justify-between mb-6">
          <!-- Left: Search + Time -->
          <div class="flex items-center gap-4">
            <!-- Search -->
            <div class="relative">
              <input type="search" placeholder="Search..." 
                class="px-4 py-2 rounded-xl w-72 bg-white border border-transparent shadow-sm focus:ring-2 focus:ring-indigo-200">
              <i class="bi bi-search absolute right-3 top-2.5 text-gray-400"></i>
            </div>
            <!-- Time -->
            <div class="flex items-center gap-2 px-3 py-2 bg-white shadow-sm rounded-xl">
              <i class="bi bi-clock text-indigo-600"></i>
              <span class="text-sm text-gray-600">{{ now()->format('H:i A, d M Y') }}</span>
            </div>
          </div>

        </div>

        <!-- Greeting -->
        <div class="card glass big-round mb-6 flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-indigo-700">Hello {{ Auth::user()->name }}</h1>
            <p class="text-sm text-gray-500">Have a nice day at Work !</p>
          </div>
          <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=200&q=60"
               alt="illustration" class="h-24 rounded-lg object-cover">
        </div>

        <!-- Slot konten -->
        @yield('content-body')
      </main>

    </div>
  </div>

  @stack('scripts')
</body>
</html>
