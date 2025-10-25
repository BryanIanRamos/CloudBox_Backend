<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Laravel App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="bg-gray-800 text-white p-4">
        @if(request()->routeIs('dashboard'))
            <div class="flex justify-between items-center">
                <span class="font-semibold">Dashboard</span>
                <a href="/" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">Logout</a>
            </div>
        @else
            <a href="/" class="mr-4">Home</a>
            <a href="{{ route('show.login') }}" class="mr-4">Login</a>
            <a href="{{ route('show.register') }}">Register</a>
        @endif
    </nav>

    <main class="container mx-auto p-4">
        {{ $slot }}
    </main>
</body>
</html>