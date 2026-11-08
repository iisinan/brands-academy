@props([
    'variant' => 'heritage',
    'class' => 'w-11 h-11',
    'alt' => 'Brands Academy Nigeria Foundation Logo'
])

@php
    $src = match($variant) {
        'midnight' => asset('images/logo/bran-logo-midnight.png'),
        'harmonized' => asset('images/logo/bran-logo-harmonized.png'),
        'mark' => asset('images/logo/bran-mark.png'),
        default => asset('images/logo/bran-logo.png'),
    };
@endphp

<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $class . ' object-contain shrink-0']) }}>
