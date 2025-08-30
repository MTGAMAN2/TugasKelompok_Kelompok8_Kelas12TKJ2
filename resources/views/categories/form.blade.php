@extends('layouts.app')

@section('content')
@php $isEdit = isset($category); @endphp
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold dark:text-white">
            {{ $isEdit ? 'Edit' : 'New' }} Category
        </h1>
        <a href="{{ route('categories.index') }}"
        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600">
            Back
        </a>
    </div>

    <form action="{{ $isEdit ? route('categories.update',$category) : route('categories.store') }}"
        method="POST"
        class="bg-white dark:bg-gray-800 rounded shadow p-6 grid gap-4">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div>
            <label class="block mb-1 font-medium dark:text-gray-200">
                Name <span class="text-red-500">*</span>
            </label>
            <input type="text"
                name="name"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                value="{{ $isEdit ? $category->name : old('name') }}"
                required>
        </div>

        <div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ $isEdit ? 'Update' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endsection
