@extends('layouts.app')

@section('title', 'Daftar Lowongan')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Lowongan</h1>

@if(auth()->check() && auth()->user()->role == 'admin')
    <a href="{{ route('jobs.create') }}" class="bg-green-500 text-white px-3 py-1 mb-4 inline-block">Tambah Lowongan</a>
@endif

<table class="table-auto w-full border">
    <thead>
        <tr>
            <th class="border px-2 py-1">Title</th>
            <th class="border px-2 py-1">Location</th>
            <th class="border px-2 py-1">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jobs as $job)
        <tr>
            <td class="border px-2 py-1">{{ $job->title }}</td>
            <td class="border px-2 py-1">{{ $job->location }}</td>
            <td class="border px-2 py-1">
                <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-500">Detail</a>
                @if(auth()->check() && auth()->user()->role == 'admin')
                    | <a href="{{ route('jobs.edit', $job->id) }}" class="text-yellow-500">Edit</a>
                    | <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Hapus</button>
                      </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
