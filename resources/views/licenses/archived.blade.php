<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Archived Licenses</title>

    <!-- Tailwind, SweetAlert2, Particles.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #0b1e3b; /* Dark blue background */
            overflow: hidden;
        }

        /* Particle container */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        /* Main container above particles */
        .main-container {
            position: relative;
            z-index: 10;
            display: flex;
            height: 100vh;
        }

        /* Top bar */
        .top-bar {
            background-color: #082146; /* same as login/dashboard */
        }

        .astik-logo {
            height: 40px;
        }

        /* Table card */
        .table-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            flex-shrink: 0;
        }

        /* Scrollable table */
        .table-container {
            overflow-x: auto;
        }

        /* Table hover effect matching dashboard accent */
        .table-hover-blue tbody tr:hover {
            background-color: rgba(54, 162, 235, 0.1);
        }
    </style>
</head>

<body>
    <!-- Particles Background -->
    <div id="particles-js"></div>

    <div class="main-container">
        <!-- Sidebar -->
        @include('sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="top-bar flex items-center px-6 py-3">
                <img src="{{ asset('images/astik.jpg') }}" alt="Logo" class="astik-logo mr-3">
                <span class="text-white font-bold text-lg">AZTECH Compute Enterprises Inc.</span>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- Session Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Navbar / Search & Bulk Actions -->
                <div class="table-card shadow-lg">
                    <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center mb-4 space-y-4 md:space-y-0">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Archived Licenses</h2>

                        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                            <!-- Bulk Actions Dropdown -->
                            <div class="relative inline-block text-left">
                                <button type="button" id="bulk-actions-menu"
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Bulk Actions
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="bulk-actions-dropdown"
                                    class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10">
                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                        aria-labelledby="bulk-actions-menu">
                                        <a href="#" id="bulk-restore"
                                            class="block px-4 py-2 text-sm text-blue-700 hover:bg-gray-100"
                                            role="menuitem">Restore Selected</a>
                                        <a href="#" id="bulk-delete"
                                            class="block px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                            role="menuitem">Delete Selected Permanently</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Form -->
                            <form action="/licenses/archived" method="GET" class="flex">
                                <input type="text" name="search" placeholder="Search archived..."
                                    value="{{ request('search') }}"
                                    class="border border-gray-300 rounded-l-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none">
                                <button type="submit"
                                    class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-700 transition-colors">Search</button>
                            </form>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-container">
                        <form id="bulk-form" method="POST">
                            @csrf
                            <table class="w-full text-sm text-gray-700 table-hover-blue">
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
                                        <tr class="border-b border-gray-200">
                                            <td class="p-3"><input type="checkbox" name="ids[]"
                                                    value="{{ $license->id }}" class="license-checkbox"></td>
                                            <td class="p-3 font-bold text-blue-600">{{ $license->sheet_name }}</td>
                                            <td class="p-3">{{ $license->vendo_box_no }}</td>
                                            <td class="p-3 font-mono text-xs break-all">{{ $license->license }}</td>
                                            <td class="p-3">{{ $license->email }}</td>
                                            <td class="p-3 font-mono text-xs">{{ $license->lpb_radius_id }}</td>
                                            <td class="p-3">{{ $license->customer_name }}</td>
                                            <td class="p-3 text-gray-500 text-xs">
                                                {{ $license->deleted_at ? $license->deleted_at->format('M d, Y h:i A') : '' }}
                                            </td>
                                            <td class="p-3">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <a href="/licenses/{{ $license->id }}"
                                                        class="text-gray-500 hover:text-gray-700 font-medium">View</a>
                                                    <a href="{{ route('licenses.edit', $license->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                                    <button type="button" class="text-blue-600 hover:text-blue-800 font-bold"
                                                        onclick="handleRestore({{ $license->id }})">Restore</button>
                                                    <button type="button" class="text-red-600 hover:text-red-800 font-bold"
                                                        onclick="handlePermanentDelete({{ $license->id }})">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9"
                                                class="p-8 text-center text-gray-500 italic">No archived licenses found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
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

    <!-- Hidden forms -->
    <form id="form-restore-license" method="POST" style="display:none;">@csrf</form>
    <form id="form-delete-license" method="POST" style="display:none;">@csrf</form>

    <script>
        // Dropdown toggle
        const bulkActionsMenu = document.getElementById('bulk-actions-menu');
        const bulkActionsDropdown = document.getElementById('bulk-actions-dropdown');
        bulkActionsMenu.addEventListener('click', () => bulkActionsDropdown.classList.toggle('hidden'));
        document.addEventListener('click', (event) => {
            if (!bulkActionsMenu.contains(event.target)) bulkActionsDropdown.classList.add('hidden');
        });

        // Select All logic
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.license-checkbox');
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        const bulkForm = document.getElementById('bulk-form');
        const bulkRestore = document.getElementById('bulk-restore');
        const bulkDelete = document.getElementById('bulk-delete');

        bulkRestore.addEventListener('click', function (e) {
            e.preventDefault();
            const checkedCount = document.querySelectorAll('.license-checkbox:checked').length;
            if (checkedCount === 0) return Swal.fire('Wait', 'Select at least one license first.', 'info');
            Swal.fire({
                title: 'Restore Selected?',
                text: `You are about to restore ${checkedCount} licenses.`,
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

        bulkDelete.addEventListener('click', function (e) {
            e.preventDefault();
            const checkedCount = document.querySelectorAll('.license-checkbox:checked').length;
            if (checkedCount === 0) return Swal.fire('Wait', 'Select at least one license first.', 'info');
            Swal.fire({
                title: 'Permanent Deletion?',
                text: `You are about to permanently delete ${checkedCount} licenses. This cannot be undone!`,
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

        function handleRestore(id) {
            Swal.fire({
                title: 'Restore License?',
                text: "This item will move back to the active list.",
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

        function handlePermanentDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action is permanent and cannot be undone!",
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

        // Particles.js config
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: '#ffffff' },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, opacity: 0.1 },
                move: { enable: true, speed: 1, direction: 'none', out_mode: 'bounce' }
            },
            interactivity: { events: { onhover: { enable: true, mode: 'repulse' } } },
            retina_detect: true
        });
    </script>
</body>
</html>
