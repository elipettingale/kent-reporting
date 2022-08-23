@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 text-md font-medium leading-5 font-bold text-white focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 text-md font-medium leading-5 font-bold text-gray-100 hover:text-white focus:outline-none focus:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
