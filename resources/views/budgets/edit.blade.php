@extends('layouts.app')

@section('content-body')
<div class="p-6 max-w-2xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Edit Budget</h1>

  <form action="{{ route('budgets.update', $budget) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    @csrf @method('PUT')
    <div class="mb-3">
      <label class="block text-sm mb-1">Category</label>
      <select name="category_id" required class="w-full border rounded px-3 py-2 dark:bg-gray-900">
        <option value="">-- Select Category --</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected($budget->category_id == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label class="block text-sm mb-1">Name (optional)</label>
      <input name="name" class="w-full border rounded px-3 py-2 dark:bg-gray-900" value="{{ $budget->name }}">
    </div>

    <div class="grid md:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm mb-1">Limit (Rp)</label>
        <input name="limit_amount" type="text" id="amountIndex" required class="w-full border rounded px-3 py-2 dark:bg-gray-900" value="{{ $budget->limit_amount }}">
      </div>

      <div>
        <label class="block text-sm mb-1">Alert Threshold (%)</label>
        <input name="alert_threshold" type="number" min="0" max="100" value="{{ $budget->alert_threshold }}" class="w-full border rounded px-3 py-2 dark:bg-gray-900">
      </div>
    </div>

    <div class="grid md:grid-cols-2 gap-3 mt-3">
      <div>
        <label class="block text-sm mb-1">Start Date</label>
        <input name="start_date" type="date" class="w-full border rounded px-3 py-2 dark:bg-gray-900" value="{{ optional($budget->start_date)->toDateString() }}">
      </div>
      <div>
        <label class="block text-sm mb-1">End Date</label>
        <input name="end_date" type="date" class="w-full border rounded px-3 py-2 dark:bg-gray-900" value="{{ optional($budget->end_date)->toDateString() }}">
      </div>
    </div>

    <div class="mt-3">
      <label class="block text-sm mb-1">Notes</label>
      <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-900">{{ $budget->notes }}</textarea>
    </div>

    <div class="mt-4">
      <button class="bg-indigo-600 text-white px-4 py-2 rounded">Update Budget</button>
      <a href="{{ route('budgets.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Cancel</a>
    </div>
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