@extends('layouts.app')

@section('content')
<div class="px-6 py-4">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">💳 Wallets</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Wallet List -->
        <div class="md:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Daftar Wallet</h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Total: <span class="font-bold text-indigo-600">Rp {{ number_format($total,0,',','.') }}</span>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($wallets as $w)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center justify-between">
                        <div>
                            <form method="POST" action="{{ route('wallets.update',$w) }}" class="flex gap-2 items-center">
                                @csrf
                                @method('PUT')
                                <input class="border rounded px-2 py-1 dark:bg-gray-900 dark:text-gray-100" 
                                       type="text" name="name" value="{{ $w->name }}">
                                <button class="text-indigo-600 font-medium hover:underline">Save</button>
                            </form>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Saldo: <span class="font-semibold">Rp {{ number_format($w->balance,0,',','.') }}</span>
                            </p>
                        </div>
                        <form method="POST" action="{{ route('wallets.destroy',$w) }}" 
                              onsubmit="return confirm('Hapus wallet ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada wallet</p>
                @endforelse
            </div>
        </div>

        <!-- Create + Transfer -->
        <div class="space-y-6">
            <!-- Create Wallet -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-3">➕ Buat Wallet</h2>
                <form method="POST" action="{{ route('wallets.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm mb-1">Nama</label>
                        <input class="w-full border rounded px-3 py-2 dark:bg-gray-900 dark:text-gray-100" name="name" required>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Saldo Awal</label>
                        <input class="w-full border rounded px-3 py-2 dark:bg-gray-900 dark:text-gray-100" 
                               type="number" step="0.01" name="balance">
                    </div>
                    <button class="w-full bg-indigo-600 text-white px-3 py-2 rounded-lg shadow hover:opacity-90 transition">Create</button>
                </form>
            </div>

            <!-- Transfer -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-3">🔄 Transfer</h2>
                <form method="POST" action="{{ route('wallets.transfer') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm mb-1">Dari</label>
                        <select class="w-full border rounded px-3 py-2 dark:bg-gray-900 dark:text-gray-100" name="from_wallet_id" required>
                            @foreach($wallets as $w)
                                <option value="{{ $w->id }}">{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Ke</label>
                        <select class="w-full border rounded px-3 py-2 dark:bg-gray-900 dark:text-gray-100" name="to_wallet_id" required>
                            @foreach($wallets as $w)
                                <option value="{{ $w->id }}">{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Jumlah</label>
                        <input class="w-full border rounded px-3 py-2 dark:bg-gray-900 dark:text-gray-100" type="number" step="0.01" name="amount" required>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Tanggal</label>
                        <input class="w-full border rounded px-3 py-2 dark:bg-gray-900 dark:text-gray-100" type="date" name="transacted_at" required value="{{ now()->toDateString() }}">
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Catatan</label>
                        <input class="w-full border rounded px-3 py-2 dark:bg-gray-900 dark:text-gray-100" name="note">
                    </div>
                    <button class="w-full bg-purple-600 text-white px-3 py-2 rounded-lg shadow hover:opacity-90 transition">Transfer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
