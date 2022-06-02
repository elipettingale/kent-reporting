<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-700">
    <div class="w-full sm:max-w-2xl flex mt-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="px-6 py-4 border-r-4 border-blue-500 flex items-center justify-center">
            <img class="max-h-48" src="{{ asset('img/logo.png') }}" />
        </div>
        <div class="px-8 py-6 flex-1">
            {{ $slot }}
        </div>
    </div>
</div>
