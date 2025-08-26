@extends('layouts.app')

@section('content')
@php $isEdit = isset($budget); @endphp
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ $isEdit ? 'Edit' : 'New' }} Budget</h1>
        <a href="{{ route('budgets.index') }}" class="px-4 py-2 bg-gray-200 rounded">Back</a>
    </div>

    <form action="{{ $isEdit ? route('budgets.update',$budget) : route('budgets.store') }}" method="POST" class="bg-white rounded shadow p-6 grid md:grid-cols-2 gap-4">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="md:col-span-2">
            <label class="block mb-1 font-medium">Name (optional)</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $isEdit ? $budget->name : old('name') }}">
        </div>

        <div>
            <label class="block mb-1 font-medium">Category <span class="text-red-500">*</span></label>
            <select name="category_id" required class="w-full border rounded px-3 py-2">
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(($isEdit ? $budget->category_id : old('category_id'))==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Limit Amount (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="limit_amount" step="0.01" min="0" class="w-full border rounded px-3 py-2" value="{{ $isEdit ? $budget->limit_amount : old('limit_amount') }}" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Start Date</label>
            <input type="date" name="start_date" class="w-full border rounded px-3 py-2" value="{{ $isEdit ? $budget->start_date : old('start_date') }}">
        </div>

        <div>
            <label class="block mb-1 font-medium">End Date</label>
            <input type="date" name="end_date" class="w-full border rounded px-3 py-2" value="{{ $isEdit ? $budget->end_date : old('end_date') }}">
        </div>

        <div class="md:col-span-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">{{ $isEdit ? 'Update' : 'Save' }}</button>
        </div>
    </form>
</div>
@endsection
