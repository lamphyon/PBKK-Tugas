```blade
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tema ?? 'General Assistant Agent' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .bg-grid-pattern {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);
        }

        .text-glow {
            text-shadow: 0 0 25px rgba(16, 185, 129, 0.6);
        }

        .box-glow {
            box-shadow: 0 0 40px rgba(16, 185, 129, 0.15);
        }
    </style>
</head>

<body class="bg-gray-950 text-gray-300 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-gray-900 border-b border-gray-800 h-14">
        <div class="max-w-4xl mx-auto h-full flex justify-center items-center gap-6 text-sm font-semibold">
            <a href="/" class="text-gray-400 hover:text-gray-200 transition">
                Landing Page
            </a>

            <a href="/about" class="text-gray-400 hover:text-gray-200 transition">
                Department Profile
            </a>

            <a href="/project-idea" class="text-gray-400 hover:text-gray-200 transition">
                Project Plan
            </a>

            <a href="/agent" class="text-emerald-400">
                Agentic AI
            </a>
        </div>
    </nav>

    <!-- Main -->
    <main class="relative min-h-[calc(100vh-3.5rem)] flex items-center justify-center bg-grid-pattern px-6">

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                    w-[600px] h-[600px] bg-emerald-500/10 blur-[140px]
                    rounded-full pointer-events-none">
        </div>

        <section class="relative z-10 max-w-4xl w-full text-center">

            <!-- Theme -->
            <p class="text-emerald-400 font-bold tracking-[0.3em] uppercase text-sm mb-6 text-glow">
                {{ $tema ?? 'General Assistant Agent' }}
            </p>

            <!-- Definition -->
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-white mb-8">
                What is Agentic AI?
            </h1>

            <p class="text-lg md:text-xl text-gray-400 leading-relaxed max-w-3xl mx-auto mb-14">
                Agentic AI is an artificial intelligence system that can
                understand a goal, reason about the required steps, use tools,
                perform actions, and evaluate the results to complete a task
                with limited human intervention.
            </p>

            <!-- PBKK Fact -->
            <div class="bg-gray-900/70 backdrop-blur-md border border-gray-800
                        rounded-3xl p-8 md:p-10 box-glow text-left">

                <p class="text-emerald-400 text-sm font-bold tracking-widest uppercase mb-4">
                    PBKK B
                </p>

                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                    Framework + Agentic AI
                </h2>

                <p class="text-gray-400 text-lg leading-relaxed">
                    Mahasiswa Pemrograman Berbasis Kerangka Kerja B diwajibkan
                    membuat sebuah website menggunakan framework dan
                    mengintegrasikan Agentic AI ke dalam website tersebut.
                </p>

            </div>

        </section>
    </main>

</body>
</html>
```
