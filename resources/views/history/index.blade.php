<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Expenses History') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-white">
            <h3 class="text-lg font-semibold mb-4">{{ __('Deposit History') }}</h3>

            @if ($histories->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">{{ __('No expenses found.') }}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold text-left">
                                <th class="py-2 px-4 border-b">{{ __('Name') }}</th>
                                <th class="py-2 px-4 border-b">{{ __('Date') }}</th>
                                <th class="py-2 px-4 border-b">{{ __('Category') }}</th>
                                <th class="py-2 px-4 border-b">{{ __('Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $history)
                                <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">{{ $history->name }}</td>
                                    <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                        {{ $history->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">
                                        {{ $history->category->name ?? 'No Category' }}</td>
                                    <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
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
</x-app-layout>
