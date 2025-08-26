@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Wallets</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <!-- Wallet List -->
  <div class="bg-white p-4 rounded shadow md:col-span-2">
    <div class="flex items-center justify-between mb-3">
      <h2 class="font-semibold">My Wallets</h2>
      <div class="text-sm text-gray-500">
        Total: <span class="font-bold text-blue-600">Rp {{ number_format($total,0,',','.') }}</span>
      </div>
    </div>

    <table class="w-full text-sm">
      <thead>
        <tr class="text-left border-b">
          <th class="py-2">Name</th>
          <th class="text-right">Balance</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($wallets as $w)
          <tr class="border-b">
            <td class="py-2">
              <form method="POST" action="{{ route('wallets.update',$w) }}" class="flex gap-2 items-center">
                @csrf
                @method('PUT')
                <input class="border rounded p-1" type="text" name="name" value="{{ $w->name }}">
                <button class="text-blue-600">Save</button>
              </form>
            </td>
            <td class="text-right">Rp {{ number_format($w->balance,0,',','.') }}</td>
            <td class="text-right">
              <form method="POST" action="{{ route('wallets.destroy',$w) }}" onsubmit="return confirm('Delete this wallet?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="py-4 text-center text-gray-500">No wallet</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Create + Transfer -->
  <div class="bg-white p-4 rounded shadow">
    <h2 class="font-semibold mb-2">Create Wallet</h2>
    <form method="POST" action="{{ route('wallets.store') }}" class="space-y-3">
      @csrf
      <div>
        <label class="block text-sm mb-1">Name</label>
        <input class="w-full border rounded p-2" name="name" required>
      </div>
      <div>
        <label class="block text-sm mb-1">Initial Balance</label>
        <input class="w-full border rounded p-2" type="number" step="0.01" name="balance">
      </div>
      <button class="bg-blue-600 text-white px-3 py-2 rounded">Create</button>
    </form>

    <hr class="my-4">

    <h2 class="font-semibold mb-2">Transfer</h2>
    <form method="POST" action="{{ route('wallets.transfer') }}" class="space-y-3">
      @csrf
      <div>
        <label class="block text-sm mb-1">From</label>
        <select class="w-full border rounded p-2" name="from_wallet_id" required>
          @foreach($wallets as $w)
            <option value="{{ $w->id }}">{{ $w->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm mb-1">To</label>
        <select class="w-full border rounded p-2" name="to_wallet_id" required>
          @foreach($wallets as $w)
            <option value="{{ $w->id }}">{{ $w->name }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm mb-1">Amount</label>
        <input class="w-full border rounded p-2" type="number" step="0.01" name="amount" required>
      </div>
      <div>
        <label class="block text-sm mb-1">Date</label>
        <input class="w-full border rounded p-2" type="date" name="transacted_at" required value="{{ now()->toDateString() }}">
      </div>
      <div>
        <label class="block text-sm mb-1">Note</label>
        <input class="w-full border rounded p-2" name="note">
      </div>
      <button class="bg-blue-600 text-white px-3 py-2 rounded">Transfer</button>
    </form>
  </div>
</div>
@endsection
