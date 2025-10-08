@extends('layouts.app')

@section('content-body')
@php $isEdit = isset($wallet); @endphp
<div class="max-w-2xl mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            {{ $isEdit ? 'Edit Wallet' : 'Buat Wallet Baru' }}
        </h1>
        <a href="{{ route('wallets.index') }}" 
           class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded shadow hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            ← Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <form action="{{ $isEdit ? route('wallets.update',$wallet) : route('wallets.store') }}" 
              method="POST" class="grid grid-cols-1 gap-6">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div>
                <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">
                    Nama Wallet <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" 
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                       value="{{ $isEdit ? $wallet->name : old('name') }}" required>
            </div>

            @unless($isEdit)
            <div>
                <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">
                    Saldo Awal
                </label>
                <input type="number" step="0.01" name="balance"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                       value="{{ old('balance',0) }}">
            </div>
            @endunless

            <div>
                <button class="w-full px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow hover:opacity-90 transition">
                    {{ $isEdit ? 'Update Wallet' : 'Simpan Wallet' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

