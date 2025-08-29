<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <div class="flex-shrink-0 w-64 bg-gray-800 text-white flex flex-col transition-all duration-300 transform -translate-x-full md:translate-x-0 md:static fixed inset-y-0 left-0 z-50" x-data="{ open: true }" @click.away="open = false" @keydown.escape="open = false">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-2xl font-semibold">Admin Panel</h1>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('time') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    <span>Project Time</span>
                </a>

                <a href="{{ route('leaves') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 2a1 1 0 00-1 1v1H2a2 2 0 00-2 2v2a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2h-5V3a1 1 0 10-2 0v1H8V3a1 1 0 00-1-1zM2 10a1 1 0 011-1h14a1 1 0 011 1v8a1 1 0 01-1 1H3a1 1 0 01-1-1v-8z" />
                    </svg>
                    <span>Leave Apply</span>
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto">

            <header class="bg-white shadow-sm p-4 flex items-center justify-between sticky top-0 z-40">
                <h1 class="text-xl font-bold text-gray-800">{{ $pageTitle ?? 'Dashboard' }}</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 hover:text-gray-800">
                            <span>{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50">
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Sign out</a>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
        </div>

    </div>

</body>

</html>
