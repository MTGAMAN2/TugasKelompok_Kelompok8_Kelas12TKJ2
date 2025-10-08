@extends('layouts.app')

@section('content-body')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Create New Goal</h1>

    <form method="POST" action="{{ route('goals.store') }}" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Goal Name" class="w-full px-3 py-2 rounded text-black">
        <input type="number" name="target_amount" placeholder="Target Amount" class="w-full px-3 py-2 rounded text-black">
        <input type="date" name="deadline" class="w-full px-3 py-2 rounded text-black">
        <select name="priority" class="w-full px-3 py-2 rounded text-black">
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Goal</button>
    </form>
</div>
@endsection
