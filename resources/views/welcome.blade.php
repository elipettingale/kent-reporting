<x-guest-layout>
    <x-auth-card>
        <p class="text-md font-bold mb-2">Welcome!</p>
        <div class="text-sm">
            <p class="mb-3">Thank you for visiting and welcome to Kent RFU's online reporting website for clubs. If this is your club's first time using this system please create an account by clicking register button below.</p>
            <p class="mb-3">If your club has already registered please use the login page, you will not be able to register multiple accounts for your club.</p> 
            <p>If you have any issues logging in, please use the password recovery page, or contact <a href="office@kent-rugby.org.uk" class="text-blue-500 font-bold">office@kent-rugby.org.uk</a> for help</p>
        </div>
        <div class="mt-6">
            <x-button href="{{ route('login') }}">Login</x-button>
            <x-button href="{{ route('register') }}">Register</x-button>
        </div>
    </x-auth-card>
</x-guest-layout>
