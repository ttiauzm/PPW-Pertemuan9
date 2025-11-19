@extends('layouts.app')

@section('title', 'Daftar Pelamar')

@section('content')
<h1 class="text-2xl font-bold mb-4">Pelamar Job: {{ $job->title }}</h1>

<table class="table-auto w-full border">
    <thead>
        <tr>
            <th class="border px-2 py-1">Nama</th>
            <th class="border px-2 py-1">Email</th>
            <th class="border px-2 py-1">Status</th>
            <th class="border px-2 py-1">CV</th>
            <th class="border px-2 py-1">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($applications as $a)
        <tr>
            <td>{{ $a->user->name ?? '-' }}</td>
            <td>{{ $a->user->email ?? '-' }}</td>
            <td>{{ $a->status }}</td>
            <td>
                @if($a->cv)
                    <a href="{{ asset('storage/' . $a->cv) }}" target="_blank" class="text-blue-500">Download CV</a>
                @else
                    -
                @endif
            </td>
            <td>
                <form action="{{ route('applications.updateStatus', $a->id) }}" method="POST" class="inline">
                    @csrf
                    <select name="status">
                        <option value="Pending" {{ $a->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Accepted" {{ $a->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ $a->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button type="submit" class="bg-green-500 text-white px-2 py-1">Update</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Export Excel --}}
<a href="{{ route('export.applicants', $job->id) }}" class="bg-blue-500 text-white px-3 py-1 mt-4 inline-block">Export Excel</a>

{{-- Download Template Import --}}
<a href="{{ route('import.template') }}" class="bg-gray-500 text-white px-3 py-1 mt-4 inline-block">Download Template Import</a>
@endsection
