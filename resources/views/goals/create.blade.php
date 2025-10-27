@extends('layouts.app')

@section('content-body')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4 dark:text-white">Create New Goal</h1>

    <form method="POST" action="{{ route('goals.store') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        @csrf
        <div class="mb-3">
            <label class="block text-sm mb-1">Name</label>
            <input type="text" name="name" placeholder="Goal Name" class="w-full border rounded px-3 py-2 dark:bg-gray-900 text-black">
        </div>

        <div class="mb-3">
            <label class="block text-sm mb-1">Target Amount (Rp)</label>
            <input type="text" name="target_amount" class="amount-input w-full border rounded px-3 py-2 dark:bg-gray-900 text-black" placeholder="Target Amount">
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm mb-1">Deadline</label>
                <input type="date" name="deadline" class="w-full border rounded px-3 py-2 dark:bg-gray-900 text-black">
            </div>
            <div>
                <label class="block text-sm mb-1">Priority</label>
                <select name="priority" class="w-full border rounded px-3 py-2 dark:bg-gray-900 text-black">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Goal</button>
            <a href="{{ route('goals.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.amount-input').forEach(function (input) {
        input.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value) {
                e.target.value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            } else {
                e.target.value = '';
            }
        });

        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                input.value = input.value.replace(/[^0-9]/g, '');
            });
        }
    });
});
</script>
@endpush
