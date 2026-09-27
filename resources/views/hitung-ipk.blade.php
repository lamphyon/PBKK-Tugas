<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator IPK - ITS Academic Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-gray-900 border-b border-gray-800 p-4 sticky top-0 z-50 shadow-lg">
        <div class="max-w-4xl mx-auto flex justify-center gap-6 text-sm font-semibold">
            <a href="/" class="text-gray-400 hover:text-gray-200 transition">Landing Page</a>
            <a href="/about" class="text-gray-400 hover:text-gray-200 transition">Department Profile</a>
            <a href="/project-idea" class="text-gray-400 hover:text-gray-200 transition">Project Plan</a>
            <a href="/hitung" class="text-emerald-400 hover:text-emerald-300 transition">Calculator</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-12 px-6">
        <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div class="space-y-6">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-emerald-400 tracking-wide">
                    Hasil Kalkulasi IPK
                </h1>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-gray-800/60 bg-gray-900/50">
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-1">Semester 1</p>
                            <p class="text-2xl font-bold text-white">{{ number_format($ip1, 2) }}</p>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-800/60 bg-gray-900/50">
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-1">Semester 2</p>
                            <p class="text-2xl font-bold text-white">{{ number_format($ip2, 2) }}</p>
                        </div>
                    </div>
                    
                    <p class="text-sm uppercase tracking-wider text-gray-400 font-semibold pt-2">Rata-rata IPK Anda:</p>
                    
                    <div class="p-6 bg-gray-900/80 backdrop-blur rounded-xl border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)] min-h-[100px] flex flex-col items-center justify-center text-center">
                        <span class="font-black text-emerald-400 text-5xl tracking-tight">{{ number_format($rataRataIPK, 2) }}</span>
                        <span class="text-gray-400 text-sm mt-2">Total IP: {{ $totalIP }}</span>
                    </div>
                </div>
            </div>

            <div class="relative flex items-center justify-center p-6 bg-gray-900/60 backdrop-blur rounded-2xl border border-gray-800 overflow-hidden min-h-[300px] shadow-2xl">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-emerald-600/10 rounded-full blur-2xl"></div>

                <div class="relative z-10 w-full space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                        </div>
                        <span class="text-xs text-gray-500 font-mono">system.status // calculated</span>
                    </div>

                    <div class="space-y-2 font-mono text-xs text-gray-400">
                        <p class="text-emerald-400">&gt; initializing calc_module...</p>
                        <p>&gt; parsing input_1: [ {{ number_format($ip1, 2) }} ]</p>
                        <p>&gt; parsing input_2: [ {{ number_format($ip2, 2) }} ]</p>
                        <p>&gt; calculating sum_total... OK</p>
                        <p>&gt; dividing by semesters_count (2)... OK</p>
                        <div class="p-3 bg-emerald-950/30 border border-emerald-500/20 rounded-lg text-emerald-300 flex items-center gap-2 mt-4">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span>Result Generated Successfully</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>