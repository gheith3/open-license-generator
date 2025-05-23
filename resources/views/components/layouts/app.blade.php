<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'License Generator' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen antialiased">

    <main class="container mx-auto px-4 py-10">
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>