@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-medium text-white bg-indigo-600 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:bg-indigo-700 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
