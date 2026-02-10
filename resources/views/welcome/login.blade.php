<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Particles.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
</head>
<body class="h-screen bg-[#0B3D91] relative overflow-hidden">

    <!-- Particles Background -->
    <div id="tsparticles" class="absolute inset-0 z-0"></div>

    <!-- Top Bar with Logo and Company Name -->
    <header class="bg-[#062C6B] shadow-md h-20 flex items-center px-6 z-10 relative">
        <img src="{{ asset('images/astik.jpg') }}" alt="Logo" class="h-12 w-auto mr-3">
        <span class="text-xl font-bold text-white"><a href = "https://pinaybold.com/">AZTECH Computer Enterprises Inc.</a>
            
        </span>
    </header>

    <!-- Main Content: Centered Form -->
    <div class="flex justify-center items-center h-[calc(100vh-5rem)] relative z-10">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            
            <!-- Cover Image on top inside form -->
            <img src="{{ asset('images/astikcover.jpg') }}" alt="Cover" class="w-full h-32 object-cover rounded-t-lg mb-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Admin Login</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 rounded-lg transition-colors">
                    Login
                </button>
            </form>
        </div>
    </div>

    <!-- Particles Script -->
    <script>
        tsParticles.load("tsparticles", {
            fullScreen: { enable: false },
            particles: {
                number: { value: 60, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5 },
                size: { value: { min: 1, max: 3 } },
                move: { enable: true, speed: 2, direction: "none", out_mode: "out" },
            },
            interactivity: {
                events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" } },
                modes: { repulse: { distance: 100 }, push: { quantity: 4 } }
            },
            retina_detect: true
        });
    </script>

</body>
</html>
