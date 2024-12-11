<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome ".$users->name."") }}
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-center p-6 text-gray-900 dark:text-gray-100 gap-48">
                    <div>
                        <x-period-conge :users="$users" :congeMonth="$congeMonth" :congeYear="$congeYear" />
                    </div>
                    <div>
                        <x-year-conge :selectannee="$selectannee" :conge_annee="$conge_annee" :users="$users"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
