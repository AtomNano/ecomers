<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black  leading-tight">
            {{ __('Owner Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Welcome, Super Admin!</h3>
                    <p class="mt-2">This is the Owner's Dashboard. You have full access to all system features.</p>
                    
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <p class="text-gray-600 dark:text-gray-400">Quick Stats:</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Users</p>
                                <p class="text-2xl font-bold">1,234</p> <!-- Placeholder -->
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Products</p>
                                <p class="text-2xl font-bold">567</p> <!-- Placeholder -->
                            </div>
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Revenue</p>
                                <p class="text-2xl font-bold">$12,345</p> <!-- Placeholder -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
