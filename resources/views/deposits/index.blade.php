<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Deposits') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-white">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Add New Deposit') }}</h3>
                <form action="{{ route('deposits.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 text-gray-700"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="value"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Value') }}</label>
                        <input type="number" name="value" id="value"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 text-gray-700"
                            required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">{{ __('Add Deposit') }}</button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Deposit History') }}</h3>
                @if ($deposits->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">{{ __('No deposits found.') }}</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($deposits as $deposit)
                            <li class="py-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-800 dark:text-gray-200">{{ $deposit['name'] }}</span>
                                    <span
                                        class="text-gray-600 dark:text-gray-400">{{ number_format($deposit['value'], 2) }}
                                        DH</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
