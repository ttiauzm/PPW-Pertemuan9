@extends('layouts.app')

@section('title', 'Edit Lowongan')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Lowongan</h1>

<form action="{{ route('jobs.update', $job->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-2">
        <label>Title:</label>
        <input type="text" name="title" value="{{ $job->title }}" required class="border px-2 py-1 w-full">
    </div>

    <div class="mb-2">
        <label>Location:</label>
        <input type="text" name="location" value="{{ $job->location }}" required class="border px-2 py-1 w-full">
    </div>

    <div class="mb-2">
        <label>Description:</label>
        <textarea name="description" required class="border px-2 py-1 w-full">{{ $job->description }}</textarea>
    </div>

    <button type="submit" class="bg-yellow-500 text-white px-3 py-1">Update</button>
</form>
@endsection
