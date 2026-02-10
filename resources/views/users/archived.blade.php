<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Archived Users | {{ config('app.name', 'License Management') }}</title>

<!-- Tailwind, SweetAlert2, Particles.js -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

<style>
    body {
        font-family: 'Figtree', sans-serif;
        background-color: #0b1e3b; /* Dark blue background */
        margin: 0;
        padding: 0;
    }

    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 0;
        top: 0;
        left: 0;
    }

    #dashboard-container {
        position: relative;
        z-index: 10;
        height: 100vh;
        overflow-y: auto;
    }

    .top-bar {
        background-color: #082146;
    }

    .astik-logo {
        height: 40px;
    }

    .table-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }

    .table-hover tr:hover {
        background-color: #eff6ff;
    }

    .btn-primary { background-color: #3b82f6; color: white; }
    .btn-primary:hover { background-color: #2563eb; }
    .btn-danger { background-color: #ef4444; color: white; }
    .btn-danger:hover { background-color: #b91c1c; }
</style>
</head>
<body>

<!-- Particles background -->
<div id="particles-js"></div>

<div id="dashboard-container" class="flex h-screen">
    <!-- Sidebar -->
    <div class="flex flex-col w-64 bg-gray-800 text-white h-full shadow-lg">
        <!-- Top Bar -->
        <div class="top-bar flex items-center px-4 py-3">
            <img src="{{ asset('images/astik.jpg') }}" alt="Logo" class="astik-logo mr-2">
            <span class="font-bold text-lg">AZTECH Compute Enterprises Inc.</span>
        </div>

        <!-- Navigation -->
        <nav class="mt-4 flex-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="block px-6 py-3 hover:bg-gray-700 rounded">Dashboard</a>

            <div>
                <button onclick="toggleDropdown('license-menu')" class="w-full px-6 py-3 flex justify-between items-center hover:bg-gray-700 rounded">
                    Licenses
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="license-menu" class="hidden pl-4">
                    <a href="{{ route('licenses.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Manage Licenses</a>
                    <a href="{{ route('licenses.archived') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Archived Licenses</a>
                </div>
            </div>

            <div>
                <button onclick="toggleDropdown('user-menu')" class="w-full px-6 py-3 flex justify-between items-center hover:bg-gray-700 rounded">
                    Users
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="user-menu" class="hidden pl-4">
                    <a href="{{ route('users.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Manage Users</a>
                    <a href="{{ route('users.archived') }}" class="block px-4 py-2 hover:bg-gray-700 rounded">Archived Users</a>
                </div>
            </div>

            <a href="#" class="block px-6 py-3 hover:bg-gray-700 rounded">Settings</a>
        </nav>

        <!-- Logout -->
        <div class="px-6 py-4 border-t border-gray-700">
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">@csrf</form>
            <button onclick="confirmLogout()" class="w-full flex items-center text-red-500 hover:text-white hover:bg-red-700 px-3 py-2 rounded font-semibold">
                Logout
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Top Bar -->
        <div class="top-bar flex items-center px-6 py-3 shadow-lg">
            <img src="{{ asset('images/astik.jpg') }}" alt="Logo" class="astik-logo mr-3">
            <span class="font-bold text-lg text-white">AZTECH Compute Enterprises Inc.</span>
        </div>

        <div class="p-6">
            <h1 class="text-3xl font-bold text-white mb-6">Archived Users</h1>

            <!-- Alerts -->
            @if(session('success'))
                <script>
                    window.onload = () => Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", confirmButtonColor: '#10b981' });
                </script>
            @endif
            @if(session('error'))
                <script>
                    window.onload = () => Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}", confirmButtonColor: '#ef4444' });
                </script>
            @endif

            <!-- Users Table Card -->
            <div class="table-card overflow-x-auto">
                <form id="bulk-form" method="POST">
                    @csrf
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex space-x-4">
                            <button type="button" id="bulk-restore-btn" class="px-4 py-2 rounded btn-primary font-semibold">Restore Selected</button>
                            <button type="button" id="bulk-delete-btn" class="px-4 py-2 rounded btn-danger font-semibold">Delete Selected Permanently</button>
                        </div>
                    </div>

                    <table class="w-full table-auto table-hover text-gray-700">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="p-3 rounded-tl-lg"><input type="checkbox" id="select-all" class="w-5 h-5 rounded accent-blue-500"></th>
                                <th class="p-3 text-left font-semibold">Email</th>
                                <th class="p-3 text-left font-semibold">LPB Radius ID</th>
                                <th class="p-3 text-left font-semibold">Customer Name</th>
                                <th class="p-3 text-left font-semibold">Address</th>
                                <th class="p-3 text-left font-semibold">Contact</th>
                                <th class="p-3 text-left font-semibold rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $user)
                            <tr>
                                <td class="p-3"><input type="checkbox" name="ids[]" value="{{ $user->id }}" class="user-checkbox w-5 h-5 rounded accent-blue-500"></td>
                                <td class="p-3 font-medium">{{ $user->email }}</td>
                                <td class="p-3 font-medium">{{ $user->radius_id }}</td>
                                <td class="p-3 font-bold">{{ $user->customer_name }}</td>
                                <td class="p-3">{{ $user->address }}</td>
                                <td class="p-3">{{ $user->contact }}</td>
                                <td class="p-3 flex space-x-2">
                                    <button type="button" data-action="{{ route('users.restore', $user->id) }}" class="underline text-blue-600 hover:text-blue-800 individual-restore-btn font-semibold">Restore</button>
                                    <button type="button" data-action="{{ route('users.delete', $user->id) }}" class="underline text-red-500 hover:text-red-700 individual-delete-btn font-semibold">Delete</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-500 italic">The archive is currently empty.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>

                <!-- Hidden Form for Individual Actions -->
                <form id="individual-action-form" method="POST" style="display:none;">@csrf</form>
            </div>
        </div>
    </div>
</div>

<script>
    // Sidebar dropdown
    function toggleDropdown(id){
        const menu = document.getElementById(id);
        menu.classList.toggle('hidden');
    }

    // Logout
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if(result.isConfirmed) document.getElementById('logout-form').submit();
        });
    }

    // Select All
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    selectAll?.addEventListener('change', function() {
        checkboxes.forEach(c => c.checked = this.checked);
    });

    // Individual Restore/Delete
    document.querySelectorAll('.individual-restore-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = document.getElementById('individual-action-form');
            Swal.fire({ 
                title: 'Restore User?', text: 'This user will be moved back to the active list.', icon: 'question', showCancelButton: true, confirmButtonColor: '#3b82f6', confirmButtonText: 'Yes, Restore User' 
            }).then(result => { if(result.isConfirmed){ form.action = btn.dataset.action; form.submit(); } });
        });
    });

    document.querySelectorAll('.individual-delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const form = document.getElementById('individual-action-form');
            Swal.fire({ 
                title: 'Delete Permanently?', text: 'This action cannot be undone.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Yes, Delete Forever' 
            }).then(result => { if(result.isConfirmed){ form.action = btn.dataset.action; form.submit(); } });
        });
    });

    // Bulk Actions
    const bulkForm = document.getElementById('bulk-form');
    const bulkRestoreBtn = document.getElementById('bulk-restore-btn');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const getSelectedCount = () => document.querySelectorAll('.user-checkbox:checked').length;

    bulkRestoreBtn.addEventListener('click', () => {
        const count = getSelectedCount();
        if(count === 0) return Swal.fire('No selection', 'Please select at least one user to restore.', 'info');
        Swal.fire({ title: `Restore ${count} Users?`, text: 'All selected users will be moved back to the active list.', icon: 'question', showCancelButton: true, confirmButtonColor: '#3b82f6', confirmButtonText: 'Yes, Restore All Selected' })
        .then(result => { if(result.isConfirmed){ bulkForm.action = "{{ route('users.bulkRestore') }}"; bulkForm.submit(); } });
    });

    bulkDeleteBtn.addEventListener('click', () => {
        const count = getSelectedCount();
        if(count === 0) return Swal.fire('No selection', 'Please select at least one user to delete.', 'info');
        Swal.fire({ title: `Permanently delete ${count} users?`, text: 'This action cannot be undone.', icon: 'error', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Yes, Delete Selected Forever' })
        .then(result => { if(result.isConfirmed){ bulkForm.action = "{{ route('users.bulkDelete') }}"; bulkForm.submit(); } });
    });

    // Particles.js
    particlesJS('particles-js',{
        particles:{
            number:{value:80,density:{enable:true,value_area:800}},
            color:{value:'#ffffff'},
            shape:{type:'circle'},
            opacity:{value:0.5,random:true},
            size:{value:3,random:true},
            line_linked:{enable:true,opacity:0.1},
            move:{enable:true,speed:1,direction:'none',out_mode:'bounce'}
        },
        interactivity:{events:{onhover:{enable:true,mode:'repulse'}}},
        retina_detect:true
    });
</script>
</body>
</html>