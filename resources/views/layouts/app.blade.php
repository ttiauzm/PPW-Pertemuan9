<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Job Portal' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow p-4 flex justify-between">
        <h1 class="font-bold">Job Portal</h1>

        <div class="flex gap-4">
            <a href="{{ route('jobs.index') }}">Jobs</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('jobs.create') }}" class="text-blue-600">Tambah Lowongan</a>
                @endif

                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button>Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container mx-auto mt-6">
        @yield('content')
    </div>

</body>
</html>
