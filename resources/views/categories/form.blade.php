@extends('layouts.app')

@section('content')
@php $isEdit = isset($category); @endphp
<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ $isEdit ? 'Edit' : 'New' }} Category</h1>
        <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-200 rounded">Back</a>
    </div>

    <form action="{{ $isEdit ? route('categories.update',$category) : route('categories.store') }}" method="POST" class="bg-white rounded shadow p-6 grid gap-4">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div>
            <label class="block mb-1 font-medium">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $isEdit ? $category->name : old('name') }}" required>
        </div>

        <div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">{{ $isEdit ? 'Update' : 'Save' }}</button>
        </div>
    </form>
</div>
@endsection
