<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div
                class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Average Expenses</h4>
                        <span
                            class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded">All
                            Users</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $avg_expenses_value }} DH</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">per user this month</p>
                    </div>
                </div>
            </div>

            <div
                class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Active Users</h4>
                        <span
                            class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $active_count }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">users currently active</p>
                    </div>
                </div>
            </div>

            <div
                class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow">
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200">Inactive Users</h4>
                        <span
                            class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 text-xs font-medium px-2.5 py-0.5 rounded">Inactive</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $inactif_count }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">users currently inactive</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div
                class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow">
                <div class="p-4">
                    <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Expense Categories</h4>
                    <div class="relative" style="height: 300px;">
                        <canvas id="expenseCategoriesChart"></canvas>
                    </div>
                </div>
            </div>

            <div
                class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-white dark:bg-gray-800 shadow">
                <div class="p-4">
                    <h4 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">User Growth</h4>
                    <div class="relative" style="height: 300px;">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expenseCategoriesCtx = document.getElementById('expenseCategoriesChart').getContext('2d');
        const expenseCategoriesChart = new Chart(expenseCategoriesCtx, {
            type: 'doughnut',
            data: {
                labels: @json($categoryNames),
                datasets: [{
                    data: @json($categoriesExpenses),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)', // Blue
                        'rgba(16, 185, 129, 0.8)', // Green
                        'rgba(245, 158, 11, 0.8)', // Yellow
                        'rgba(236, 72, 153, 0.8)', // Pink
                        'rgba(139, 92, 246, 0.8)', // Purple
                        'rgba(107, 114, 128, 0.8)' // Gray
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(236, 72, 153, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(107, 114, 128, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: document.documentElement.classList.contains('dark') ?
                                '#fff' : '#fff',
                            font: {
                                size: 12
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                const value = context.raw;
                                label += value.toLocaleString() + ' DH';
                                return label;
                            }
                        }
                    }
                }
            }
        });

        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthChart = new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
                datasets: [{
                    label: 'Users',
                    data: @json($monthlyUsers),
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
