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

            <!-- Navbar / Search & Bulk Actions -->
            <div class="bg-white shadow-md rounded-lg m-4 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-bold text-gray-800">Archived Licenses</h2>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Bulk Actions Dropdown -->
                        <div class="relative inline-block text-left">
                            <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="bulk-actions-menu" aria-haspopup="true" aria-expanded="true">
                                Bulk Actions
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="bulk-actions-dropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="bulk-actions-menu">
                                    <a href="#" id="bulk-restore" class="block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100" role="menuitem">Restore Selected</a>
                                    <a href="#" id="bulk-delete" class="block px-4 py-2 text-sm text-red-700 hover:bg-gray-100" role="menuitem">Delete Selected Permanently</a>
                                </div>
                            </div>
                        </div>

                        <!-- Search Form -->
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
                    <form id="bulk-form" method="POST">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white text-sm">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="p-3 text-left"><input type="checkbox" id="select-all"></th>
                                        <th class="p-3 text-left">Sheet Name</th>
                                        <th class="p-3 text-left">Vendo Box No.</th>
                                        <th class="p-3 text-left">License</th>
                                        <th class="p-3 text-left">PISOFI Email</th>
                                        <th class="p-3 text-left">LPB Radius ID</th>
                                        <th class="p-3 text-left">Customer Name</th>
                                        <th class="p-3 text-left">Archived Date</th>
                                        <th class="p-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($licenses as $license)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="p-3"><input type="checkbox" name="ids[]" value="{{ $license->id }}" class="license-checkbox"></td>
                                        <td class="p-3 font-bold text-blue-600">{{ $license->sheet_name }}</td>
                                        <td class="p-3">{{ $license->vendo_box_no }}</td>
                                        <td class="p-3 font-mono text-xs" style="word-break: break-all;">{{ $license->license }}</td>
                                        <td class="p-3">{{ $license->email }}</td>
                                        <td class="p-3 font-mono text-xs">{{ $license->lpb_radius_id }}</td>
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
                                        <td colspan="9" class="p-8 text-center text-gray-500 italic">No archived licenses found matching your criteria.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

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

    <!-- Hidden Action Forms for Individual Items -->
    <form id="form-restore-license" method="POST" style="display: none;">@csrf</form>
    <form id="form-delete-license" method="POST" style="display: none;">@csrf</form>

    <script>
        // Dropdown toggle logic
        const bulkActionsMenu = document.getElementById('bulk-actions-menu');
        const bulkActionsDropdown = document.getElementById('bulk-actions-dropdown');
        bulkActionsMenu.addEventListener('click', () => bulkActionsDropdown.classList.toggle('hidden'));
        document.addEventListener('click', (event) => {
            if (!bulkActionsMenu.contains(event.target)) bulkActionsDropdown.classList.add('hidden');
        });

        // Select All logic
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.license-checkbox');
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        const bulkForm = document.getElementById('bulk-form');
        const bulkRestore = document.getElementById('bulk-restore');
        const bulkDelete = document.getElementById('bulk-delete');

        // Bulk Restore handler
        bulkRestore.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedCount = document.querySelectorAll('.license-checkbox:checked').length;
            if(checkedCount === 0) return Swal.fire('Wait', 'Select at least one license first.', 'info');
            Swal.fire({
                title: 'Restore Selected?',
                text: `Restore ${checkedCount} licenses to the active list?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, restore them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkForm.action = '/licenses/archived/bulk-restore';
                    bulkForm.submit();
                }
            });
        });

        // Bulk Delete handler
        bulkDelete.addEventListener('click', function(e) {
            e.preventDefault();
            const checkedCount = document.querySelectorAll('.license-checkbox:checked').length;
            if(checkedCount === 0) return Swal.fire('Wait', 'Select at least one license first.', 'info');
            Swal.fire({
                title: 'Permanent Deletion?',
                text: `You are about to PERMANENTLY delete ${checkedCount} licenses. This cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete forever!'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkForm.action = '/licenses/archived/bulk-delete';
                    bulkForm.submit();
                }
            });
        });

        /**
         * Function to trigger Individual Restore via SweetAlert2
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
         * Function to trigger Individual Permanent Delete via SweetAlert2
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