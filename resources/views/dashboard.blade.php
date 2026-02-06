<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        
        @include('sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-x-auto p-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <p>Welcome to the dashboard!</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>