<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ config('app.name', 'License Management') }}</title>

<!-- Tailwind, SweetAlert2, Chart.js, Particles.js -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

<style>
    body {
        font-family: 'Figtree', sans-serif;
        background-color: #0b1e3b; /* Dark blue background */
        overflow: hidden;
    }

    /* Particles container */
    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    /* Dashboard content above particles */
    #dashboard-container {
        position: relative;
        z-index: 10;
        display: flex;
        height: 100vh;
    }

    /* Top bar color */
    .top-bar {
        background-color: #082146; /* Login page top bar color */
    }

    .astik-logo {
        height: 40px;
    }

    /* Card for charts with centered content */
    .chart-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 300px;
    }

    /* Chart container to center chart */
    .chart-container {
        width: 250px;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
</head>
<body>

<!-- Particles background -->
<div id="particles-js"></div>

<div id="dashboard-container">
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
    <div class="flex-1 flex flex-col overflow-hidden">
        <div class="flex-1 overflow-y-auto p-8 space-y-6">
            <h1 class="text-3xl font-bold text-white mb-4">Dashboard</h1>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6 h-48 flex flex-col justify-center">
                    <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 h-48 flex flex-col justify-center">
                    <h3 class="text-lg font-semibold text-gray-700">Total Licenses</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalLicenses }}</p>
                </div>
            </div>

            <!-- License Status Chart -->
            <div class="chart-card">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">License Status</h3>
                <div class="chart-container">
                    <canvas id="licenseStatusChart"></canvas>
                </div>
            </div>

            <!-- Time Series Chart -->
            <div class="chart-card">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">License Activity Over Time</h3>
                <div class="chart-container">
                    <canvas id="timeSeriesChart"></canvas>
                </div>
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

    // License Status Chart
    const statusCtx = document.getElementById('licenseStatusChart').getContext('2d');
    const licenseStatusData = @json($licenseStatusData ?? ['active'=>150,'archived'=>30]);
    new Chart(statusCtx,{
        type:'doughnut',
        data:{
            labels:['Active','Archived'],
            datasets:[{
                data:[licenseStatusData.active, licenseStatusData.archived],
                backgroundColor:['rgba(54, 162, 235, 0.8)','rgba(255, 99, 132, 0.8)'],
                borderColor:['rgba(54, 162, 235,1)','rgba(255, 99, 132,1)'],
                borderWidth:1
            }]
        },
        options:{responsive:true, maintainAspectRatio:false}
    });

    // Time Series Chart
    const tsCtx = document.getElementById('timeSeriesChart').getContext('2d');
    new Chart(tsCtx,{
        type:'line',
        data:{
            labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets:[{
                label:'Licenses',
                data:[5,12,8,15,10,4,9],
                backgroundColor:'rgba(75,192,192,0.4)',
                borderColor:'rgba(75,192,192,1)',
                tension:0.3,
                fill:true
            }]
        },
        options:{responsive:true, maintainAspectRatio:false, scales:{y:{beginAtZero:true}}}
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
