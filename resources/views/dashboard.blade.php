<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'License Management') }}</title>
    
    <!-- Using Tailwind CDN instead of Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR START (Based on your provided code) -->
        <div class="w-64 bg-gray-800 text-white h-screen shadow-lg sticky top-0">
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
        <!-- SIDEBAR END -->

        <!-- MAIN CONTENT START -->
        <div class="flex-1 p-10">
            <div class="container mx-auto">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

                <!-- Indicators -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold text-gray-700">Total Users</h2>
                        <p class="text-4xl font-bold text-blue-500">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold text-gray-700">Total Licenses</h2>
                        <p class="text-4xl font-bold text-green-500">{{ $totalLicenses }}</p>
                    </div>
                </div>

                <!-- Existing License Status Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">License Status</h2>
                    <div class="chart-container" style="position: relative; height:40vh; width:100%">
                        <canvas id="licenseStatusChart"></canvas>
                    </div>
                </div>

                <!-- NEW Time Series Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">License Activity Over Time</h2>
                    
                    <!-- Filters (Day, Month, Year) -->
                    <div class="flex space-x-2 mb-4">
                        <button id="filter-daily" onclick="updateTimeSeriesChart('daily')" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition-colors">Per Day</button>
                        <button id="filter-monthly" onclick="updateTimeSeriesChart('monthly')" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors">Per Month</button>
                        <button id="filter-yearly" onclick="updateTimeSeriesChart('yearly')" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors">Per Year</button>
                    </div>

                    <div class="chart-container" style="position: relative; height:45vh; width:100%">
                        <canvas id="timeSeriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- MAIN CONTENT END -->

    </div>

    <!-- SCRIPTS -->
    
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Global chart instance for the time series chart
        let timeSeriesChartInstance = null;

        // Dummy data for the new Time Series graph (assuming licenses created/activated)
        const timeSeriesData = {
            daily: {
                title: 'Licenses Created Per Day (Last Week)',
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                data: [5, 12, 8, 15, 10, 4, 9],
                type: 'bar',
                color: 'rgba(75, 192, 192, 0.8)'
            },
            monthly: {
                title: 'Licenses Created Per Month (Current Year)',
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                data: [50, 65, 40, 75, 80, 55, 90, 100, 70, 60, 85, 95],
                type: 'line',
                color: 'rgba(255, 159, 64, 0.8)'
            },
            yearly: {
                title: 'Licenses Created Per Year',
                labels: ['2021', '2022', '2023', '2024'],
                data: [200, 350, 500, 620],
                type: 'line',
                color: 'rgba(153, 102, 255, 0.8)'
            }
        };

        /** Sidebar Dropdown Logic **/
        function toggleDropdown(id) {
            const menu = document.getElementById(id);
            menu.classList.toggle('hidden');
            const otherMenuId = id === 'license-menu' ? 'user-menu' : 'license-menu';
            const otherMenu = document.getElementById(otherMenuId);
            if(!otherMenu.classList.contains('hidden')) {
                otherMenu.classList.add('hidden');
            }
        }

        /** Function to initialize or update the Time Series Chart **/
        function updateTimeSeriesChart(period) {
            const dataConfig = timeSeriesData[period];
            const ctx = document.getElementById('timeSeriesChart').getContext('2d');
            
            // Handle button styling
            ['daily', 'monthly', 'yearly'].forEach(p => {
                const button = document.getElementById(`filter-${p}`);
                if (p === period) {
                    button.classList.remove('bg-gray-200', 'text-gray-700');
                    button.classList.add('bg-blue-500', 'text-white');
                } else {
                    button.classList.remove('bg-blue-500', 'text-white');
                    button.classList.add('bg-gray-200', 'text-gray-700');
                }
            });

            if (timeSeriesChartInstance) {
                // Update existing chart
                timeSeriesChartInstance.data.labels = dataConfig.labels;
                timeSeriesChartInstance.data.datasets[0].data = dataConfig.data;
                timeSeriesChartInstance.data.datasets[0].label = dataConfig.title;
                timeSeriesChartInstance.config.type = dataConfig.type;
                timeSeriesChartInstance.data.datasets[0].backgroundColor = dataConfig.type === 'bar' ? dataConfig.color : dataConfig.color.replace('0.8', '0.5'); // Use solid color for line
                timeSeriesChartInstance.data.datasets[0].borderColor = dataConfig.color.replace('0.8', '1');
                timeSeriesChartInstance.options.plugins.title.text = dataConfig.title;
                timeSeriesChartInstance.update();

            } else {
                // Initialize the chart
                timeSeriesChartInstance = new Chart(ctx, {
                    type: dataConfig.type,
                    data: {
                        labels: dataConfig.labels,
                        datasets: [{
                            label: dataConfig.title,
                            data: dataConfig.data,
                            backgroundColor: dataConfig.type === 'bar' ? dataConfig.color : dataConfig.color.replace('0.8', '0.5'),
                            borderColor: dataConfig.color.replace('0.8', '1'),
                            borderWidth: 2,
                            tension: 0.4,
                            fill: dataConfig.type === 'line' // Fill area under the line
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: dataConfig.title,
                                font: {
                                    size: 16
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        /** Initialization Logic **/
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Initialize Existing License Status Chart (Doughnut)
            const statusCtx = document.getElementById('licenseStatusChart').getContext('2d');
            // Assuming $licenseStatusData is defined in PHP/Laravel context, use a fallback structure for display
            const licenseStatusData = @json($licenseStatusData ?? ['active' => 150, 'archived' => 30]);

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Archived'],
                    datasets: [{
                        label: 'License Status',
                        data: [licenseStatusData.active, licenseStatusData.archived],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)', // Blue for Active
                            'rgba(255, 99, 132, 0.8)'  // Red for Archived
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // 2. Initialize the NEW Time Series Chart with 'daily' view by default
            updateTimeSeriesChart('daily');
        });
    </script>
</body>
</html>