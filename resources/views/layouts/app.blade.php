<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Bulletin: Purok Flores')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50/40 text-emerald-950 antialiased min-h-screen flex flex-col justify-between">
    <header class="bg-white border-b border-emerald-100 shadow-xs sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                    BB
                </div>
                <div>
                    <a href="{{ route('posts.index') }}" class="text-xl font-black text-emerald-950 tracking-tight hover:text-emerald-700 transition">
                        Barangay Bulletin: Purok Flores
                    </a>
                </div>
            </div>

            <nav class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->author)
                        <a href="{{ route('posts.create') }}" class="text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-2 rounded-lg transition shadow-xs">
                            + New Post
                        </a>
                    @endif
                    <span class="text-xs font-medium text-emerald-800 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
                        {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-emerald-700 hover:text-red-600 px-2 py-1 transition">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition">
                        Sign In
                    </a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="max-w-6xl w-full mx-auto px-4 py-8 flex-1">
        @if (session('status'))
            <div class="mb-6 rounded-xl bg-emerald-100 border border-emerald-300 text-emerald-900 px-4 py-3 text-sm font-semibold">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-emerald-100 py-6 text-center text-xs text-emerald-700/80">
        &copy; 2026 Barangay Bulletin: Purok Flores &middot; Matina Crossing, Davao City
    </footer>
</body>
</html>