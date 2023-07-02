<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="register-form" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Your Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Club -->
            <div class="mt-4">
                <x-label for="club" :value="__('Your Club')" />

                <x-select id="club" class="block mt-1 w-full" type="text" name="club" required>
                    <option selected></option>
                    @foreach(config('clubs') as $club)
                        <option value="{{ $club }}" @selected(old('club') == $club)>{{ $club }}</option>
                    @endforeach
                </x-select>
            </div>

            <!-- Club Confirmation -->
            <div class="mt-4">
                <x-label for="club_confirmation">
                    Confirm Your Club <span class="text-xs">(Please type full club name)</span>
                </x-label>
        
                <x-input id="club_confirmation" class="block mt-1 w-full" type="text" name="club_confirmation" :value="old('club_confirmation')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email">
                    Email <span class="text-xs">(Please avoid using your personal email)</span>
                </x-label>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-password-strength name="password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button id="register-button" class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        <div id="already-registered-modal" class="k-modal__wrapper" style="display: none">
            <div class="k-modal">
                <h2 class="text-lg font-bold mb-2">Already Registered<h1>
                <p class="mb-4">Someone has already created a login for this club. Please login using your existing email and password.</p>

                <div class="mb-4">
                    <p class="text-xs">Your email is: <span id="email-hint"></span>...</p>
                </div>

                <div class="flex justify-between items-center">
                    <x-button href="{{ route('login') }}">
                        {{ __('Log In') }}
                    </x-button>

                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
