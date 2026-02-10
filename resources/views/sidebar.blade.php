<div class="flex flex-col justify-between w-64 bg-gray-800 text-white h-screen shadow-lg">

    <!-- Sidebar Top Menu -->
    <div>
        <div class="p-6">
            <h1 class="text-2xl font-bold">License Manager</h1>
        </div>

        <nav class="mt-10">
            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-4 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-300">
                <span class="mx-4">Dashboard</span>
            </a>

            <!-- Licenses Dropdown -->
            <div>
                <button onclick="toggleDropdown('license-menu')" class="flex justify-between items-center w-full px-6 py-4 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-300">
                    <span class="mx-4">Licenses</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="license-menu" class="hidden pl-8">
                    <a href="{{ route('licenses.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Manage Licenses</a>
                    <a href="{{ route('licenses.archived') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Archived Licenses</a>
                </div>
            </div>

            <!-- Users Dropdown -->
            <div>
                <button onclick="toggleDropdown('user-menu')" class="flex justify-between items-center w-full px-6 py-4 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-300">
                    <span class="mx-4">Users</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="user-menu" class="hidden pl-8">
                    <a href="{{ route('users.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Manage Users</a>
                    <a href="{{ route('users.archived') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Archived Users</a>
                </div>
            </div>

            <a href="#" class="flex items-center px-6 py-4 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-300">
                <span class="mx-4">Settings</span>
            </a>
        </nav>
    </div>

    <!-- Sidebar Bottom Logout -->
    <div class="p-6 border-t border-gray-700">
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <button onclick="confirmLogout()" class="flex items-center w-full px-6 py-4 text-red-500 hover:bg-red-700 hover:text-white font-semibold transition-colors duration-300">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5"></path>
            </svg>
            <span>Logout</span>
        </button>
    </div>
</div>

<script>
    // Toggle Dropdown Logic
    function toggleDropdown(id) {
        const menu = document.getElementById(id);
        menu.classList.toggle('hidden');

        const otherMenuId = id === 'license-menu' ? 'user-menu' : 'license-menu';
        const otherMenu = document.getElementById(otherMenuId);
        if(!otherMenu.classList.contains('hidden')) {
            otherMenu.classList.add('hidden');
        }
    }

    // Logout Confirmation
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of the system.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

<!-- Include SweetAlert2 CDN if not already included -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
