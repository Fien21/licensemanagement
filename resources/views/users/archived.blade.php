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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        @include('sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            @if (session('success'))
                <div class="m-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="m-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Navbar -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <h2 class="text-3xl font-bold text-gray-800">Archived Users</h2>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-x-auto p-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full bg-white text-sm">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="p-2 text-left">PisoFi Email / LPB Radius ID</th>
                                    <th class="p-2 text-left">Customer Name</th>
                                    <th class="p-2 text-left">Address</th>
                                    <th class="p-2 text-left">Contact</th>
                                    <th class="p-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="p-2">{{ $user->email }}</td>
                                    <td class="p-2">{{ $user->customer_name }}</td>
                                    <td class="p-2">{{ $user->address }}</td>
                                    <td class="p-2">{{ $user->contact }}</td>
                                    <td class="p-2 flex items-center">
                                        <form action="/users/archived/{{ $user->id }}/restore" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="text-blue-500 hover:text-blue-700 mr-2">Restore</button>
                                        </form>
                                        <form action="/users/archived/{{ $user->id }}/delete" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete Permanently</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
