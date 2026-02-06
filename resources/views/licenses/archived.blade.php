<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Archived Licenses</title>

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
            
            <!-- Session Messages -->
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

            <!-- Navbar / Search -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-bold text-gray-800">Archived Licenses</h2>
                    <div class="flex items-center">
                        <form action="/licenses/archived" method="GET" class="flex">
                            <input type="text" name="search" placeholder="Search archived..." value="{{ request('search') }}"
                                class="border border-gray-300 rounded-l-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-700 transition-colors">Search</button>
                        </form>
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
                                    <th class="p-3 text-left">Sheet Name</th>
                                    <th class="p-3 text-left">Vendo Machine</th>
                                    <th class="p-3 text-left">License</th>
                                    <th class="p-3 text-left">Customer Name</th>
                                    <th class="p-3 text-left">Archived Date</th>
                                    <th class="p-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($licenses as $license)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                    <td class="p-3 font-bold text-blue-600">{{ $license->sheet_name }}</td>
                                    <td class="p-3">{{ $license->vendo_machine }}</td>
                                    <td class="p-3" style="word-break: break-all;">{{ $license->license }}</td>
                                    <td class="p-3">{{ $license->customer_name }}</td>
                                    <td class="p-3 text-gray-500 text-xs">
                                        {{ $license->deleted_at ? $license->deleted_at->format('M d, Y h:i A') : 'N/A' }}
                                    </td>
                                    <td class="p-3">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="/licenses/{{ $license->id }}" class="text-gray-500 hover:text-gray-700 font-medium">View</a>
                                            <a href="{{ route('licenses.edit', $license->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                            <button type="button" 
                                                class="text-blue-600 hover:text-blue-800 font-bold"
                                                onclick="handleRestore({{ $license->id }})">
                                                Restore
                                            </button>

                                            <button type="button" 
                                                class="text-red-600 hover:text-red-800 font-bold"
                                                onclick="handlePermanentDelete({{ $license->id }})">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500 italic">No archived licenses found matching your criteria.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-sm text-gray-600">
                            Showing {{ $licenses->firstItem() ?? 0 }} to {{ $licenses->lastItem() ?? 0 }} of {{ $licenses->total() }} results
                        </div>
                        <div>
                            {{ $licenses->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Action Forms -->
    <!-- Form for Restoring -->
    <form id="form-restore-license" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Form for Permanent Deletion -->
    <form id="form-delete-license" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        /**
         * Function to trigger Restore via SweetAlert2
         */
        function handleRestore(id) {
            Swal.fire({
                title: 'Restore License?',
                text: "This item will be moved back to the active Manage Licenses list.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, restore it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('form-restore-license');
                    form.action = `/licenses/archived/${id}/restore`;
                    form.submit();
                }
            });
        }

        /**
         * Function to trigger Permanent Delete via SweetAlert2
         */
        function handlePermanentDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action is PERMANENT. You cannot undo this deletion!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete forever!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('form-delete-license');
                    form.action = `/licenses/archived/${id}/delete`; 
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>