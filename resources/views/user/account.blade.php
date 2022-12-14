<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('user.account.update') }}">
                        @csrf

                        <div class="flex w-full">
                            <div class="w-full">
                                <x-label for="name" value="Name" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required />
                            </div>

                            <div class="w-full ml-4">
                                <x-label for="email" value="Email" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button>Save</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
