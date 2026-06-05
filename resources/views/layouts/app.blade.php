<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Blog Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .dark-mode { background-color: #1a202c !important; color: #e2e8f0 !important; }
        .dark-mode nav, .dark-mode .bg-white { background-color: #2d3748 !important; border-color: #4a5568 !important; }
        .dark-mode .text-gray-800, .dark-mode .text-gray-700 { color: #f7fafc !important; }
        .dark-mode .bg-gray-50 { background-color: #4a5568 !important; }
        .dark-mode input, .dark-mode textarea { background-color: #4a5568 !important; color: white !important; border-color: #718096 !important; }
    </style>
</head>
<body class="bg-gray-50 transition-colors duration-300">
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('posts.index') }}" class="text-xl font-bold text-gray-800">Blog Manager</a>
                <div class="flex items-center space-x-4">
                    <button id="theme-toggle" class="bg-gray-200 px-4 py-2 rounded-lg font-bold">🌙 Mode</button>
                    <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">New Post</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        const btn = document.getElementById('theme-toggle');
        if(localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
        
        btn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        });
    </script>
</body>
</html>