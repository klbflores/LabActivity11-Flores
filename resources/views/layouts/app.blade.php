<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barangay Bulletin: Purok Flores')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Keep pagination arrow icons properly sized */
        nav[role="navigation"] svg {
            width: 1.25rem;
            height: 1.25rem;
            display: inline-block;
        }

        /* Pagination summary text ("Showing 1 to 6 of 42 results") */
        nav[role="navigation"] p {
            color: #a7f3d0 !important; /* emerald-200 */
        }
        nav[role="navigation"] p span {
            color: #ffffff !important;
            background: transparent !important;
            border: none !important;
            margin: 0 !important;
        }

        /* Base style for all pagination buttons & spans */
        nav[role="navigation"] a,
        nav[role="navigation"] span[aria-current="page"] > span,
        nav[role="navigation"] span[aria-disabled="true"] > span,
        nav[role="navigation"] span[aria-disabled="true"] {
            border-radius: 0.5rem !important;
            margin: 0 0.15rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            transition: all 0.15s ease-in-out !important;
        }

        /* Inactive clickable page buttons (2, 3, 4... and next arrow) */
        nav[role="navigation"] a {
            background-color: #ffffff !important;
            border: 1px solid #a7f3d0 !important; /* emerald-200 */
            color: #064e3b !important;            /* emerald-900 */
        }

        nav[role="navigation"] a:hover {
            background-color: #ecfdf5 !important; /* emerald-50 */
            border-color: #10b981 !important;     /* emerald-500 */
            color: #047857 !important;            /* emerald-700 */
        }

        /* Currently active page button (Page 1) */
        nav[role="navigation"] span[aria-current="page"] > span {
            background-color: #059669 !important; /* emerald-600 */
            color: #ffffff !important;
            border: 1px solid #10b981 !important;
        }

        /* Disabled buttons (e.g. inactive '<' arrow on page 1) */
        nav[role="navigation"] span[aria-disabled="true"] > span,
        nav[role="navigation"] span[aria-disabled="true"] {
            background-color: #ecfdf5 !important; /* soft mint-white */
            border: 1px solid #a7f3d0 !important; /* emerald-200 */
            color: #6ee7b7 !important;            /* muted emerald-300 */
            cursor: not-allowed !important;
        }
    </style>
</head>
<body class="bg-emerald-950 text-slate-100 antialiased min-h-screen flex flex-col justify-between">
    <header class="bg-emerald-900/90 backdrop-blur-sm border-b border-emerald-800 shadow-md sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                    BB
                </div>
                <div>
                    <a href="{{ route('posts.index') }}" class="text-xl font-black text-white tracking-tight hover:text-emerald-200 transition">
                        Barangay Bulletin: Purok Flores
                    </a>
                </div>
            </div>

            <nav class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->author)
                        <a href="{{ route('posts.create') }}" class="text-xs font-bold bg-emerald-500 hover:bg-emerald-400 text-emerald-950 px-3.5 py-2 rounded-lg transition shadow-xs">
                            + New Post
                        </a>
                    @endif
                    <span class="text-xs font-mono font-semibold text-emerald-200 bg-emerald-950 border border-emerald-700 px-3 py-1.5 rounded-full">
                        {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-emerald-200 hover:text-rose-300 px-2 py-1 transition cursor-pointer">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg transition">
                        Sign In
                    </a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="max-w-6xl w-full mx-auto px-4 py-8 flex-1">
        @if (session('status'))
            <div class="mb-6 rounded-xl bg-emerald-900 border border-emerald-600 text-emerald-100 px-4 py-3 text-sm font-semibold">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-emerald-900/60 border-t border-emerald-800 py-6 text-center text-xs text-emerald-300/80">
        &copy; 2026 Barangay Bulletin: Purok Flores &middot; Matina Crossing, Davao City
    </footer>
</body>
</html>