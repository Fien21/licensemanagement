<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel - User Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Reusable Sidebar Component -->
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
                        <h2 class="text-3xl font-bold text-gray-800">Manage Users</h2>
                    </div>
                    <div class="flex items-center">
                        <button id="add-user-button" class="ml-4 bg-green-500 text-white px-6 py-2 rounded-full hover:bg-green-600 transition-colors duration-300 ease-in-out shadow-lg">+ Add New User</button>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <form action="/users" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Search for anything...">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition-colors duration-300 ease-in-out shadow-lg">Apply Filters</button>
                    </div>
                </form>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-x-auto p-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <form id="bulk-form" method="POST">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white text-sm">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-2 text-left"><input type="checkbox" id="select-all"></th>
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
                                        <td class="p-2"><input type="checkbox" name="ids[]" value="{{ $user->id }}" class="user-checkbox"></td>
                                        <td class="p-2">{{ $user->email }}</td>
                                        <td class="p-2">{{ $user->customer_name }}</td>
                                        <td class="p-2">{{ $user->address }}</td>
                                        <td class="p-2">{{ $user->contact }}</td>
                                        <td class="p-2 flex items-center">
                                            <a href="/users/{{ $user->id }}/edit" class="text-green-500 hover:text-green-700 mr-2">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple logic for Select All checkbox
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.user-checkbox');
        if(selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });
        }
    </script>
</body>
</html>