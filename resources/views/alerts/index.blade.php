<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Alerts Config') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-10">
                        <h3 class="text-lg font-medium mb-4">Create New Spending Alert</h3>
                        <form class="space-y-4" method="POST" action="{{ route('alerts.store') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium mb-1">Expense
                                        Category</label>
                                    <select id="category_id" name="category_id" value="{{ old('category_id') }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 p-2">
                                        <option value="" disabled>Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="type" class="block text-sm font-medium mb-1">Alert Type</label>
                                    <select id="type" name="type" value="{{ old('type') }}"
                                        class="p-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="cash">Cash</option>
                                        <option value="percentage">Percentage of Budget</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="value" class="block text-sm font-medium mb-1">
                                        <span id="value_label">Amount ($)</span>
                                    </label>
                                    <input type="number" id="value" name="value" step="0.01"
                                        value="{{ old('value') }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <x-input-error :messages="$errors->get('value')" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 italic">
                                    Note: For the percentage option, we'll calculate the percentage from the start of
                                    the month
                                </p>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Create Alert
                                </button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-4">Your Active Alerts</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Category</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Type</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Value</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($user->alerts as $alert)
                                        <tr id="{{ $alert->id }}">
                                            <td id="{{ $alert->category->id }}"
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                {{ $alert->category->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $alert->type }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $alert->value }}{{ $alert->type == 'cash' ? ' DH' : '%' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    Active
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end">
                                                <button
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3 edit">Edit</button>
                                                <form action="{{ route('alerts.destroy') }}" method="POST">
                                                    <input type="hidden" name="id" value="{{ $alert->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="hidden text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No alerts</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get notified when your spending
                                reaches certain thresholds</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div id="editAlertModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full flex items-center justify-center text-white">
    <div class="relative p-5 mx-auto w-full max-w-md bg-white dark:bg-gray-800 rounded-md shadow-xl">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg font-medium">Edit Alert</h3>
            <button id="closeEditModal" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="editAlertForm" class="space-y-4 mt-4" method="POST" action="{{ route('alerts.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" id="editAlertId" name="id">
            <div>
                <label for="editCategory" class="block text-sm font-medium mb-1">Expense Category</label>
                <select id="editCategory" name="category_id"
                    class="p-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option disabled value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="editAlertType" class="block text-sm font-medium mb-1">Alert Type</label>
                <select id="editAlertType" name="type"
                    class="p-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="cash">Cash</option>
                    <option value="percentage">Percentage of Budget</option>
                </select>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 italic">
                    Note: For the percentage option, we'll calculate the percentage from the start of the month
                </p>
            </div>

            <div>
                <label for="editAlertValue" class="block text-sm font-medium mb-1">
                    <span id="editValueLabel">Amount ($)</span>
                </label>
                <input type="number" id="editAlertValue" name="value" min="0" step="0.01"
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="flex justify-end pt-2">
                <button type="button" id="cancelEditBtn"
                    class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alertTypeSelect = document.getElementById('type');
        const valueLabel = document.getElementById('value_label');

        alertTypeSelect.addEventListener('change', function() {
            if (this.value === 'fixed') {
                valueLabel.textContent = 'Amount ($)';
            } else {
                valueLabel.textContent = 'Percentage (%)';
            }
        });

        alertTypeSelect.addEventListener('change', function() {
            if (this.value === 'fixed') {
                valueLabel.textContent = 'Amount ($)';
            } else {
                valueLabel.textContent = 'Percentage (%)';
            }
        });

        const editAlertTypeSelect = document.getElementById('editAlertType');
        const editValueLabel = document.getElementById('editValueLabel');

        editAlertTypeSelect.addEventListener('change', function() {
            if (this.value === 'fixed') {
                editValueLabel.textContent = 'Amount ($)';
            } else {
                editValueLabel.textContent = 'Percentage (%)';
            }
        });

        const editButtons = document.querySelectorAll('.edit');
        const editModal = document.getElementById('editAlertModal');
        const closeEditModal = document.getElementById('closeEditModal');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editAlertForm = document.getElementById('editAlertForm');

        editButtons.forEach(button => {

            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const category = row.cells[0];

                const type = row.cells[1].textContent === 'cash' ? 'cash' :
                    'percentage';
                const value = row.cells[2].textContent.replace(/[^0-9.]/g,
                    '');

                document.getElementById('editAlertId').value = row.id;
                document.getElementById('editCategory').value = category.id;
                document.getElementById('editAlertType').value = type;
                document.getElementById('editAlertValue').value = value;

                if (type === 'cash') {
                    editValueLabel.textContent = 'Amount ($)';
                } else {
                    editValueLabel.textContent = 'Percentage (%)';
                }

                editModal.classList.remove('hidden');
            });
        });

        function closeModal() {
            editModal.classList.add('hidden');
        }

        closeEditModal.addEventListener('click', closeModal);
        cancelEditBtn.addEventListener('click', closeModal);
    });
</script>
