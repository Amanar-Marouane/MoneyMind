<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
    <form class="space-y-4" id="expense-form" action="{{ route('expense.insert') }}" method="POST">
        @csrf
        <div class="space-y-2">
            <label for="expenseName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Title
            </label>
            <input type="text" id="expenseName" name="name" placeholder="What did you spend on?"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <label for="expenseAmount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Cost (DH)
            </label>
            <div class="relative">
                <input type="number" id="expenseAmount" name="cost" placeholder="0.00" step="0.01" min="0.01"
                    class="w-full pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <x-input-error :messages="$errors->get('cost')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <label for="expenseCategory" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Category
            </label>
            {{ $slot }}
            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>

        <div id="recurringOptions" class="space-y-4 pl-4 border-l-2 border-blue-300 dark:border-blue-700">
            <div class="space-y-2">
                <label for="monthly" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Frequency
                </label>
                <select id="monthly" name="monthly"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="false" selected>Just Once</option>
                    <option value="true">Monthly</option>
                </select>
                <x-input-error :messages="$errors->get('monthly')" class="mt-2" />
            </div>
        </div>

        <div class="space-y-2" id="starting-date">
            <label for="expenseDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Starting Date
            </label>
            <input type="date" id="expenseDate" name="starting_date"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            <x-input-error :messages="$errors->get('starting_date')" class="mt-2" />
        </div>
        <h5 class="font-medium mb-6 text-gray-900 dark:text-white" id="note">Note: This expense will be considered
            recurring.
            Moreover, it will be deducted from your budget every month starting from the date you specify.</h5>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('dashboard') }}">
                <button type="button"
                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 font-medium">
                    Cancel
                </button>
            </a>
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 font-medium shadow-md">
                Save Expense
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let expenseForm = document.querySelector("#expense-form");
        let recurring = expenseForm.querySelector("#monthly");
        let note = expenseForm.querySelector("#note");
        let dateInput = expenseForm.querySelector("#starting-date");
        note.style.display = "none";
        dateInput.style.display = "none";
        recurring.addEventListener("change", (event) => {
            note.style.display = "none";
            dateInput.style.display = "none";
            if (event.target.value == "true") {
                note.style.display = "";
                dateInput.style.display = "";
            }
        })

    })
</script>
