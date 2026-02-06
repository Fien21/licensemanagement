
<div class="w-64 bg-gray-800 text-white h-screen shadow-lg">
    <div class="p-6">
        <h1 class="text-2xl font-bold">License Manager</h1>
    </div>
    <nav class="mt-10">
        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-4 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-300">
            <span class="mx-4">Dashboard</span>
        </a>
        <div>
            <button onclick="toggleDropdown('license-menu')" class="flex justify-between items-center w-full px-6 py-4 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-300">
                <span class="mx-4">Licenses</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div id="license-menu" class="hidden pl-8">
                <a href="{{ route('licenses.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Manage Licenses</a>
                <a href="{{ route('archived') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Archived Licenses</a>
            </div>
        </div>
        <div>
            <button onclick="toggleDropdown('user-menu')" class="flex justify-between items-center w-full px-6 py-4 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-300">
                <span class="mx-4">Users</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
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

<script>
    function toggleDropdown(id) {
        const menu = document.getElementById(id);
        menu.classList.toggle('hidden');
        const otherMenuId = id === 'license-menu' ? 'user-menu' : 'license-menu';
        const otherMenu = document.getElementById(otherMenuId);
        if(!otherMenu.classList.contains('hidden')) {
            otherMenu.classList.add('hidden');
        }
    }
</script>
