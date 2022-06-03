<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="report">
                        <div>
                            <v-label value="Name"></v-label>
                            <v-input class="block mt-1 w-full"></v-input>
                        </div>
                        <div class="mt-4">
                            <v-label value="Name"></v-label>
                            <v-input class="block mt-1 w-full"></v-input>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
