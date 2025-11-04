@extends('layouts.app')

@section('content-body')
<div class="card p-6">
    <h1 class="text-2xl font-bold mb-4">Profile</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
        <div class="text-center">
            <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 overflow-hidden">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
                     alt="Profile Picture" 
                     class="w-full h-full object-cover">
            </div>
        </div>

        
        <div class="md:col-span-2">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <div class="mt-1 text-lg">{{ auth()->user()->name }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 text-lg">{{ auth()->user()->email }}</div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Join Date</label>
                    <div class="mt-1 text-lg">{{ auth()->user()->created_at->format('d M Y') }}</div>
                </div>
                <div class="pt-4">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
