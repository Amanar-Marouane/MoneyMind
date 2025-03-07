<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Expenses History') }}
            </h2>
            <div class="flex space-x-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Total Expenses') }}: <span
                        class="font-bold">{{ $histories->sum('value') + $histories->sum('cost') }}
                        DH</span></span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 flex justify-center">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('Expense Trends') }}</h3>
                <div class="h-64">
                    <canvas id="expensesChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('Detailed History') }}</h3>
                    <div class="flex space-x-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $histories->count() }}
                            {{ __('entries') }}</span>
                    </div>
                </div>

                @if ($histories->isEmpty())
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-6 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">{{ __('No expenses found.') }}</p>
                        <p class="text-gray-500 dark:text-gray-500 mt-1">
                            {{ __('Your expense records will appear here.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Name') }}</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Date') }}</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Category') }}</th>
                                    <th
                                        class="py-3 px-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($histories as $history)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="py-4 px-4 text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ $history->name }}</td>
                                        <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $history->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-4 px-4 text-sm">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                                                {{ $history->category->name ?? 'No Category' }}
                                            </span>
                                        </td>
                                        <td
                                            class="py-4 px-4 text-sm text-right font-medium text-gray-800 dark:text-gray-200">
                                            {{ number_format($history->value ?? $history->cost, 2) }} DH
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    var ctx = document.getElementById('expensesChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Monthly Expenses',
                data: @json($values),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
