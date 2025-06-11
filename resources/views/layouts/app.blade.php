<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Management System')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSRF Token for JS use -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('head')
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">Event Management</a>
            <div class="space-x-4">
                @auth
                    <span class="text-gray-700">Hi, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="text-red-600 hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Wrapper -->
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r shadow-md hidden md:block">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-blue-600 mb-4">Dashboard</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-blue-100">Home</a></li>
                    <li><a href="{{ route('admin.talk-proposals.index') }}" class="block py-2 px-3 rounded hover:bg-blue-100">Proposals</a></li>
                    <li><a href="{{ route('admin.reviews.index') }}" class="block py-2 px-3 rounded hover:bg-blue-100">Reviews</a></li>

                    <li><a href="{{ route('admin.users.index') }}" class="block py-2 px-3 rounded hover:bg-blue-100">Users</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow p-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Event Management System. All rights reserved.
    </footer>

    @stack('scripts')
</body>
</html>
