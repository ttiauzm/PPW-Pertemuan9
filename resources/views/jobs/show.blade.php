@extends('layouts.app')

@section('title', 'Detail Lowongan')

@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $job->title }}</h1>
<p><strong>Location:</strong> {{ $job->location }}</p>
<p><strong>Description:</strong> {{ $job->description }}</p>

@if(auth()->check())
<h2 class="mt-4 font-semibold">Apply for this job</h2>
<form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="job_id" value="{{ $job->id }}">
    <label>Upload CV (PDF/DOC/DOCX):</label>
    <input type="file" name="cv" required>
    <button type="submit" class="bg-blue-500 text-white px-3 py-1 mt-2">Submit</button>
</form>
@else
<p class="mt-4 text-red-500">Silakan login terlebih dahulu untuk melamar.</p>
@endif
@endsection
