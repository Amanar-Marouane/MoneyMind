@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Financial Dashboard') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('expense.add') }}">
                    <button
                        class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-600">
                        + Add Expense
                    </button>
                </a>

                <a href="{{ rpute('deposits.index') }}">
                    <button
                        class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-600">
                        + Add Money
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide mb-2">
                        {{ __('Current Budget') }}
                    </h4>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                        {{ $user->budget }} DH
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        {{ $daysLeft . ' days remaining this month' }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide mb-2">
                        {{ __('Total Spent') }}
                    </h4>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">
                        {{ $user->total_expenses() }} DH
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        {{ __('this month so far') }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Savings Goals</h3>
                        <a href="{{ route('profile.edit') }}">
                            <button
                                class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-600">
                                Edit Goals
                            </button>
                        </a>
                    </div>

                    @if ($user->saving_goal_progress == 0)
                        <div
                            class="mb-2 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg p-3 border-l-4 border-yellow-400 dark:border-yellow-500">
                            <p class="text-sm text-yellow-800 dark:text-yellow-300">
                                <span class="font-medium">Reminder:</span> Wait until the end of the month to check your
                                complete savings progress for the most accurate results.
                            </p>
                        </div>
                    @else
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-md font-medium">Monthly Savings Target</h4>
                                <span class="text-green-600 dark:text-green-400 font-semibold">
                                    Target: {{ $user->saving_goal }} DH
                                </span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-2">
                                <div class="bg-green-500 h-4 rounded-full"
                                    style="width: {{ ($user->saving_goal_progress / $user->saving_goal) * 100 > 100 ? 100 : ($user->saving_goal_progress / $user->saving_goal) * 100 }}%">
                                </div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>{{ $user->saving_goal_progress }} DH saved</span>
                                <span>{{ round(($user->saving_goal_progress / $user->saving_goal) * 100) }}% of
                                    goal</span>
                            </div>
                        </div>
                    @endif

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-md font-medium">Wishlist Progress</h4>
                            <a href="{{ route('wish-list') }}">
                                <button
                                    class="px-4 py-1.5 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-600">
                                    Check Wishlist
                                </button>
                            </a>
                        </div>

                        <div
                            class="text-sm text-gray-600 dark:text-gray-400 bg-blue-50 dark:bg-gray-700 p-3 rounded-md border-l-4 border-blue-500">
                            <p class="font-medium text-blue-800 dark:text-blue-300 mb-1">Smart Saving Tip:</p>
                            Based on your current saving patterns, you could reach your "New Laptop" goal 2 months
                            earlier by reducing your dining expenses by just 10%. Would you like to set up a
                            notification for when your dining expenses exceed your monthly limit?
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-6 mb-6">
                @if ($categoryExpense)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-[50%]">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium mb-4">Expenses by Category</h3>
                            <div class="relative flex justify-center" style="height: 300px; width: fit;">
                                <canvas id="expensesPieChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-full">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Recent Expenses</h3>
                                <a href="{{ route('expense.add') }}">
                                    <button
                                        class="px-4 py-1.5 text-sm font-medium border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 dark:text-blue-400 dark:border-blue-500 dark:hover:bg-gray-700">
                                        Add Expense
                                    </button>
                                </a>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                                <div
                                    class="max-h-[300px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800">
                                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-100 dark:bg-gray-700 sticky top-0 z-10">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                    Date
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                    Category
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                    Cost
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($expenses as $expense)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td
                                                        class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                        {{ Carbon::parse($expense->created_at)->format('M d, Y') }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $expense->name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                        <span
                                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            {{ $expense->category->name ?? 'From The Wish List' }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        {{ $expense->cost }} DH
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg col-span-2">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex flex-col items-center justify-center py-12 w-full"
                                id="noExpensesContainer">
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-6 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-12 w-12 text-gray-400 dark:text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium mb-2">No expenses yet</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-center mb-6 max-w-md">
                                    Start tracking your spending by adding your first expense.
                                </p>
                                <a href="{{ route('expense.add') }}">
                                    <button
                                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium shadow-md">
                                        Add Your First Expense
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if ($categoryExpense)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Recurring Expenses</h3>
                            <a href="{{ route('expense.add') }}">
                                <button
                                    class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-600">
                                    Add Recurring
                                </button>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse ($recExpenses as $expense)
                                <div
                                    class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-md font-medium">{{ $expense->name }}</h4>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                <span class="inline-flex items-center">
                                                    <span class="mr-2">{{ $expense->cost }} DH</span>
                                                    <span
                                                        class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800">Monthly</span>
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Next payment:
                                                {{ Carbon::parse($expense->starting_date)->greaterThan(now())
                                                    ? Carbon::parse($expense->starting_date)->format('M d, Y')
                                                    : Carbon::parse($expense->starting_date)->addMonth()->format('M d, Y') }}
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button
                                                class="p-1 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('expense.delete') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $expense->id }}">
                                                <button
                                                    class="p-1 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-3 p-6 text-center text-gray-500 dark:text-gray-400">
                                    <p>No recurring expenses yet. Add your first recurring expense to get started.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to generate random colors
        function generateRandomColors(count) {
            let colors = [];
            for (let i = 0; i < count; i++) {
                let color = `#${Math.floor(Math.random() * 16777215).toString(16)}`;
                colors.push(color);
            }
            return colors;
        }

        var ctx = document.getElementById('expensesPieChart').getContext('2d');

        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($categories),
                datasets: [{
                    label: "Expenses Categories",
                    data: @json($categoryExpense),
                    backgroundColor: generateRandomColors(@json($categories)
                        .length),
                    borderColor: "#000",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' DH';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
