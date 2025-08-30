@extends('layouts.app')

@section('content')
@php $isEdit = isset($budget); @endphp
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
            {{ $isEdit ? 'Edit' : 'New' }} Budget
        </h1>
        <a href="{{ route('budgets.index') }}" 
           class="px-4 py-2 rounded bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
            Back
        </a>
    </div>

    <form action="{{ $isEdit ? route('budgets.update',$budget) : route('budgets.store') }}" 
        method="POST" 
        class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 grid md:grid-cols-2 gap-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        {{-- Name (optional) --}}
        <div class="md:col-span-2">
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Name (optional)</label>
            <input type="text" name="name" 
                class="w-full border rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" 
                value="{{ $isEdit ? $budget->name : old('name') }}">
        </div>

        {{-- Category --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">
                Category <span class="text-red-500">*</span>
            </label>
            <select name="category_id" required
                class="w-full border rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" 
                        @selected(($isEdit ? $budget->category_id : old('category_id'))==$c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Limit Amount --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">
                Limit Amount (Rp) <span class="text-red-500">*</span>
            </label>
            <input type="number" name="limit_amount" step="0.01" min="0"
                class="w-full border rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                value="{{ $isEdit ? $budget->limit_amount : old('limit_amount') }}" required>
        </div>

        {{-- Start Date --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Start Date</label>
            <input type="date" name="start_date"
                class="w-full border rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                value="{{ $isEdit ? $budget->start_date : old('start_date') }}">
        </div>

        {{-- End Date --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">End Date</label>
            <input type="date" name="end_date"
                class="w-full border rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                value="{{ $isEdit ? $budget->end_date : old('end_date') }}">
        </div>

        {{-- New: Threshold Warning --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Alert Threshold (%)</label>
            <input type="number" name="alert_threshold" min="0" max="100" step="1"
                class="w-full border rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g. 80" 
                value="{{ $isEdit ? $budget->alert_threshold : old('alert_threshold') }}">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Ex: 80 = notify when 80% of budget is spent
            </p>
        </div>

        {{-- New: Notes --}}
        <div class="md:col-span-2">
            <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Notes</label>
            <textarea name="notes" rows="3"
                class="w-full border rounded px-3 py-2 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">{{ $isEdit ? $budget->notes : old('notes') }}</textarea>
        </div>

        {{-- Action Button --}}
        <div class="md:col-span-2 flex justify-end">
            <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition">
                {{ $isEdit ? 'Update' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endsection
