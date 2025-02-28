<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wish List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div
                            class="p-6 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg mb-6">
                            <div
                                class="mb-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                <h3 class="text-md font-medium text-blue-800 dark:text-blue-300 mb-2">Savings Tips</h3>
                                <p class="text-sm text-blue-600 dark:text-blue-400">
                                    Based on your spending habits, you could reach your "New Laptop" goal 1.5 months
                                    faster
                                    by transferring 10% of your entertainment budget to your savings.
                                </p>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Savings Goals</h3>
                                <a href="{{ route('profile.edit') }}">
                                    <button
                                        class="px-6 py-2 text-sm font-medium border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 dark:text-blue-400 dark:border-blue-500 dark:hover:bg-gray-700">
                                        Edit Goals
                                    </button>
                                </a>
                            </div>
                            @if ($user->saving_goal_progress == 0)
                                <div
                                    class="mb-2 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg p-3 border-l-4 border-yellow-400 dark:border-yellow-500">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300">
                                        <span class="font-medium">Reminder:</span> Wait until the end of the month to
                                        check your
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
                                        <span>{{ ($user->saving_goal_progress / $user->saving_goal) * 100 }}% of
                                            goal</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-8 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium mb-4">Add New Wishlist Item</h3>
                        <form action="{{ route('wish.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium mb-1">Item Name</label>
                                    <input type="text" name="name" id="name"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Name" required>
                                </div>
                                <div>
                                    <label for="price" class="block text-sm font-medium mb-1">Target Price
                                        (DH)</label>
                                    <input type="number" name="cost" id="cost"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Cost" required>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                    Add to Wishlist
                                </button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Your Wishlist Items</h3>
                        </div>
                        @if ($wishes)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($wishes as $wish)
                                    <div
                                        class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden wish">
                                        <div class="p-4">
                                            <div class="flex justify-between items-start">
                                                <h4 class="text-lg font-medium wish-name">{{ $wish->name }}</h4>
                                                <p class="hidden wish-cost">{{ $wish->cost }}</p>
                                                <p class="hidden wish-id">{{ $wish->id }}</p>
                                            </div>
                                            <div class="mt-4">
                                                <div class="flex justify-between text-sm mb-1">
                                                    <span>Progress:
                                                        {{ floor(($user->saving_goal_progress / $wish->cost) * 100) > 100 ? 100 : floor(($user->saving_goal_progress / $wish->cost) * 100) }}%</span>
                                                    <span>{{ $user->saving_goal_progress }} / {{ $wish->cost }}
                                                        DH</span>
                                                </div>
                                                <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                    <div class="bg-blue-600 h-2.5 rounded-full"
                                                        style="width: {{ ($user->saving_goal_progress / $wish->cost) * 100 > 100 ? 100 : floor(($user->saving_goal_progress / $wish->cost) * 100) }}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex justify-between items-center">
                                                <div class="flex space-x-2">
                                                    <button
                                                        class="p-1 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 wish-update">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('wish.destroy') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id"
                                                            value="{{ $wish->id }}">
                                                        <button type="submit"
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
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No wishlist items
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a new
                                    item
                                    to your wishlist.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div id="editWishFormContainer"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-white">Edit Wish</h3>
            <button type="button" id="closeEditForm"
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('wish.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editWishId">

            <div class="mb-4">
                <label for="editWishName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Wish
                    Name</label>
                <input type="text" name="name" id="editWishName"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="editWishCost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cost
                    (DH)</label>
                <input type="number" name="cost" id="editWishCost" min="0" step="0.01"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelEditWish"
                    class="px-4 py-2 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.wish-update');
        const editFormContainer = document.getElementById('editWishFormContainer');
        const closeEditFormButton = document.getElementById('closeEditForm');
        const cancelEditWishButton = document.getElementById('cancelEditWish');

        function openEditForm(wishId, wishName, wishCost) {
            document.getElementById('editWishId').value = wishId;
            document.getElementById('editWishName').value = wishName;
            document.getElementById('editWishCost').value = wishCost;
            editFormContainer.classList.remove('hidden');
        }

        function closeEditForm() {
            editFormContainer.classList.add('hidden');
        }

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const wishItem = this.closest('.wish');
                const wishId = wishItem.querySelector('.wish-id').textContent;
                const wishName = wishItem.querySelector('.wish-name').textContent;
                const cost = wishItem.querySelector('.wish-cost').textContent;

                openEditForm(wishId, wishName, cost);
            });
        });

        closeEditFormButton.addEventListener('click', closeEditForm);

        cancelEditWishButton.addEventListener('click', closeEditForm);

        editFormContainer.addEventListener('click', function(e) {
            if (e.target === editFormContainer) {
                closeEditForm();
            }
        });
    });
</script>
