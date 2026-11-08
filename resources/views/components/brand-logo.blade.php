@props([
    'variant' => '3d',
    'class' => 'w-11 h-11',
    'alt' => 'Brands Academy Nigeria Foundation Logo'
])

@php
    $src = match($variant) {
        'vector-heritage' => asset('images/logo/bran-logo-heritage.png') . '?v=3',
        'vector-midnight' => asset('images/logo/bran-logo-midnight.png') . '?v=3',
        'vector-harmonized' => asset('images/logo/bran-logo-harmonized.png') . '?v=3',
        'mark' => asset('images/logo/bran-mark.png') . '?v=3',
        default => asset('images/logo/bran-logo-3d.png') . '?v=3',
    };
@endphp

<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $class . ' object-contain shrink-0']) }}>
