@php
$defaultClasses = 'inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150';
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['type' => 'submit', 'class' => $defaultClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $defaultClasses]) }}>
        {{ $slot }}
    </button>
@endif
