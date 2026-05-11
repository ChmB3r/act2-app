<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manhwa Tracker') - Monarch's Archive</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')

    <style>
        :root {
            --glass-bg: rgba(15, 15, 20, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --accent-purple: #a855f7;
            --accent-blue: #3b82f6;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #09090b;
            color: #fafafa;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(168, 85, 247, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 40%);
            min-height: 100vh;
        }

        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
        }

        .text-gradient {
            background: linear-gradient(to right, var(--accent-purple), var(--accent-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .btn-premium {
            background: linear-gradient(to right, var(--accent-purple), var(--accent-blue));
            transition: transform 0.2s, opacity 0.2s;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="glass sticky top-0 z-50 px-6 py-4 mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                <div class="bg-linear-to-br from-purple-500 to-blue-500 p-2 rounded-lg shadow-lg group-hover:scale-110 transition-transform">
                    <span class="font-black text-white italic">M</span>
                </div>
                <span class="text-xl font-black italic tracking-tighter uppercase text-gradient">Monarch's Archive</span>
            </a>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('manhwa.create') }}" class="btn-premium px-6 py-2.5 rounded-xl text-sm font-bold text-white shadow-lg shadow-purple-500/20">Add New</a>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-gray-400 hover:text-white hover:bg-white/5 border border-white/5 transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pb-20">
        @yield('content')
    </main>

    <footer class="text-center py-10 opacity-30 text-xs tracking-widest uppercase">
        © 2026 Monarch's Archive - The Ultimate Manhwa Tracker
    </footer>
</body>
</html>
