@extends('layouts.app')

@section('content')
@php $isEdit = isset($wallet); @endphp
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ $isEdit ? 'Edit' : 'New' }} Wallet</h1>
        <a href="{{ route('wallets.index') }}" class="px-4 py-2 bg-gray-200 rounded">Back</a>
    </div>

    <form action="{{ $isEdit ? route('wallets.update',$wallet) : route('wallets.store') }}" method="POST" class="bg-white rounded shadow p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="md:col-span-2">
            <label class="block mb-1 font-medium">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $isEdit ? $wallet->name : old('name') }}" required>
        </div>

        @unless($isEdit)
        <div class="md:col-span-2">
            <label class="block mb-1 font-medium">Starting Balance</label>
            <input type="number" step="0.01" name="balance" class="w-full border rounded px-3 py-2" value="{{ old('balance',0) }}">
        </div>
        @endunless

        <div class="md:col-span-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">{{ $isEdit ? 'Update' : 'Save' }}</button>
        </div>
    </form>
</div>
@endsection
