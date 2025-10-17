<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ $month }}/{{ $year }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-5xl mx-auto my-8 bg-white p-8 rounded shadow">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Laporan Keuangan</h1>
                <p class="text-gray-600">{{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}</p>
            </div>
            <button onclick="window.print()" class="no-print px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                🖨️ Cetak / Simpan PDF
            </button>
        </div>

        {{-- Ringkasan --}}
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <div class="bg-green-100 text-green-800 p-4 rounded">
                <h3 class="font-semibold">Total Pemasukan</h3>
                <p class="text-xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-100 text-red-800 p-4 rounded">
                <h3 class="font-semibold">Total Pengeluaran</h3>
                <p class="text-xl font-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="bg-blue-100 text-blue-800 p-4 rounded">
                <h3 class="font-semibold">Saldo Akhir</h3>
                <p class="text-xl font-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Tabel Transaksi --}}
        <h2 class="text-lg font-semibold mb-3">Daftar Transaksi</h2>
        <table class="w-full border border-gray-300 text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1 text-left">Tanggal</th>
                    <th class="border px-2 py-1 text-left">Wallet</th>
                    <th class="border px-2 py-1 text-left">Tipe</th>
                    <th class="border px-2 py-1 text-left">Keterangan</th>
                    <th class="border px-2 py-1 text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $t)
                    <tr>
                        <td class="border px-2 py-1">{{ $t->created_at->format('d/m/Y') }}</td>
                        <td class="border px-2 py-1">{{ $t->wallet->name ?? '-' }}</td>
                        <td class="border px-2 py-1 capitalize">{{ $t->type }}</td>
                        <td class="border px-2 py-1">{{ $t->note ?? '-' }}</td>
                        <td class="border px-2 py-1 text-right">
                            {{ number_format($t->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-3">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p class="text-sm text-gray-500 mt-6">
            Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }}
        </p>
    </div>
</body>
</html>
