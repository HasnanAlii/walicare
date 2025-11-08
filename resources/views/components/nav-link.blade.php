{{-- resources/views/components/nav-link.blade.php --}}
@props(['href', 'active' => false])

@php
$classes = ($active ?? false)
            ? 'bg-[#a8e6cf] text-black font-semibold' 
            : 'text-white hover:bg-[#dcedc1] hover:text-black transition duration-150 ease-in-out';  
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes . ' flex items-center gap-2 px-4 py-2 rounded-md']) }}>
    {{ $slot }}
</a>
