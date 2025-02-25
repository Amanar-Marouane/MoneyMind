<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __('Profile Information') }}</h3>

                    <div class="mb-8 flex flex-col gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Name') }}</p>
                            <p>{{ Auth::user()->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</p>
                            <p>{{ Auth::user()->email }}</p>
                        </div>

                        @unless (Auth::user()->role == 'Admin')
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Monthly Salary') }}
                                </p>
                                <p class="mt-1">${{ number_format(Auth::user()->salary, 2) }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Credit Date') }}</p>
                                <p class="mt-1">{{ Auth::user()->credit_date ?? 'Not Set Yet' }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Saving Goal') }}</p>
                                <p class="mt-1">{{ number_format(Auth::user()->saving_goal, 2) }} DH</p>
                            </div>
                        @endunless
                    </div>

                    <div class="flex justify-end">
                        <button id="editProfileBtn"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <a href="{{ route('profile.edit') }}">{{ __('Edit Profile') }}</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
