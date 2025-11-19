@extends('layouts.app')

@section('content')
    <h1>Jobs Manage Page</h1>

    @if($mode == 'index')
        <p>Ini halaman list semua jobs</p>
    @elseif($mode == 'show')
        <p>Detail job: {{ $job->title }}</p>
    @elseif($mode == 'create')
        <p>Form tambah job</p>
    @elseif($mode == 'edit')
        <p>Form edit job: {{ $job->title }}</p>
    @elseif($mode == 'applicants')
        <p>Daftar pelamar job: {{ $job->title }}</p>
    @endif
@endsection
