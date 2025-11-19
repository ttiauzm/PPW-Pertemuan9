@extends('layouts.app')

@section('title', 'Tambah Lowongan')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Lowongan</h1>

<form action="{{ route('jobs.store') }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Title:</label>
        <input type="text" name="title" required class="border px-2 py-1 w-full">
    </div>

    <div class="mb-2">
        <label>Location:</label>
        <input type="text" name="location" required class="border px-2 py-1 w-full">
    </div>

    <div class="mb-2">
        <label>Description:</label>
        <textarea name="description" required class="border px-2 py-1 w-full"></textarea>
    </div>

    <button type="submit" class="bg-green-500 text-white px-3 py-1">Submit</button>
</form>
@endsection
