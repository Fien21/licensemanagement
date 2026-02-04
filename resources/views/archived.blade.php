
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
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h1 class="text-2xl font-bold">License Manager</h1>
            </div>
            <nav class="mt-4">
                <a href="/" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Licenses</a>
                <a href="/licenses/archived" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Archived</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Settings</a>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <div class="bg-white shadow">
                <div class="flex items-center justify-between px-4 py-2">
                    <div>
                        <input type="text" placeholder="Search..."
                            class="border border-gray-300 rounded-md px-4 py-2">
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-4">
                <div class="bg-white rounded-md shadow-md p-4">
                    <h2 class="text-xl font-bold mb-4">Archived Licenses</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="py-2">STUDENT</th>
                                <th class="py-2">EMAIL</th>
                                <th class="py-2">ASSIGNED TEACHER</th>
                                <th class="py-2">ARCHIVED DATE</th>
                                <th class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($licenses as $license)
                            <tr class="border-b">
                                <td class="py-2">{{ $license->first_name }} {{ $license->last_name }}</td>
                                <td class="py-2">{{ $license->email }}</td>
                                <td class="py-2">{{ $license->assigned_teacher }}</td>
                                <td class="py-2">{{ $license->deleted_at }}</td>
                                <td class="py-2">
                                    <button class="text-gray-500 hover:text-gray-700 mr-2">View</button>
                                    <button class="text-blue-500 hover:text-blue-700 mr-2"
                                        onclick="showRestoreModal({{ $license->id }})">Restore</button>
                                    <button class="text-red-500 hover:text-red-700"
                                        onclick="showDeleteModal({{ $license->id }})">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing {{ $licenses->firstItem() }} to {{ $licenses->lastItem() }} of {{
                                $licenses->total() }} results
                            </p>
                        </div>
                        <div>
                            {{ $licenses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Restore Modal -->
    <div id="restore-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Restore License</h3>
                <div class="mt-2 px-7 py-3">
                    <p>Are you sure you want to restore this license?</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="cancel-restore-button"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                    <form id="restore-form" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Restore
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete License</h3>
                <div class="mt-2 px-7 py-3">
                    <p>Are you sure you want to permanently delete this license? This action cannot be undone.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="cancel-delete-button"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                    <form id="delete-form" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const restoreModal = document.getElementById('restore-modal');
        const cancelRestoreButton = document.getElementById('cancel-restore-button');
        const restoreForm = document.getElementById('restore-form');

        const deleteModal = document.getElementById('delete-modal');
        const cancelDeleteButton = document.getElementById('cancel-delete-button');
        const deleteForm = document.getElementById('delete-form');

        function showRestoreModal(id) {
            restoreForm.action = `/licenses/${id}/restore`;
            restoreModal.classList.remove('hidden');
        }

        function showDeleteModal(id) {
            deleteForm.action = `/licenses/${id}`;
            deleteModal.classList.remove('hidden');
        }

        cancelRestoreButton.addEventListener('click', (e) => {
            e.preventDefault();
            restoreModal.classList.add('hidden');
        });

        cancelDeleteButton.addEventListener('click', (e) => {
            e.preventDefault();
            deleteModal.classList.add('hidden');
        });
    </script>
</body>

</html>
