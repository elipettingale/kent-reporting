@php
$defaultClasses = 'k-button inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150';
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $defaultClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $defaultClasses]) }}>
        {{ $slot }}
    </button>
@endif
