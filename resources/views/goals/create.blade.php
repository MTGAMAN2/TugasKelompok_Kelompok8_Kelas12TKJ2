@extends('layouts.app')

@section('content-body')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Create New Goal</h1>

    <form method="POST" action="{{ route('goals.store') }}" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Goal Name" class="w-full px-3 py-2 rounded text-black">
        <input type="text" id="amountIndex" name="target_amount" placeholder="Target Amount" class="w-full px-3 py-2 rounded text-black">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('amountIndex');

    input.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value) {
            e.target.value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        } else {
            e.target.value = '';
        }
    });

    const form = input.closest('form');
    form.addEventListener('submit', function () {
        input.value = input.value.replace(/[^0-9]/g, '');
    });
});
</script>
@endpush
