<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 copy">
                    <p class="text-lg font-bold mb-3">Recent Activity</p>
                    <div>
                        @foreach($logs as $log)
                            <div>
                                <span class="text-gray-300 mr-2">{{ $log->created_at->format('d/m/y H:i') }}</span> <span>{{ trans($log->key, $log->replace )}}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
