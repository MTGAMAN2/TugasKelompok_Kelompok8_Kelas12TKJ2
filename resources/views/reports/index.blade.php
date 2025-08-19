@extends('layouts.app')
@section('title','Reports')
@section('content')
<h1 class="text-xl font-semibold mb-4">Reports</h1>
<a href="{{ route('reports.export') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Export CSV</a>
@endsection
