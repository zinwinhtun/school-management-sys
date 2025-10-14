@props([
    'type' => 'button',
    'color' => 'blue',
    'size' => 'md',       // default size
    'icon' => null,
    'loading' => false,
    'fullWidth' => false,
])

@php
    $colors = [
        'indigo' => 'bg-indigo-500 hover:bg-indigo-600 text-white',
        'blue' => 'bg-blue-500 hover:bg-blue-600 text-white',
        'red' => 'bg-red-500 hover:bg-red-600 text-white',
        'green' => 'bg-green-500 hover:bg-green-600 text-white',
        'yellow' => 'bg-yellow-400 hover:bg-yellow-500 text-white',
        'gray' => 'bg-gray-500 hover:bg-gray-600 text-white',
    ];

    // Responsive size classes
    $sizes = [
        'xs' => 'px-1 py-0.5 text-xs sm:px-2 sm:py-1 sm:text-xs md:px-3 md:py-1.5 md:text-sm lg:px-4 lg:py-2 lg:text-base',
        'sm' => 'px-2 py-1 text-sm sm:px-3 sm:py-1.5 sm:text-sm md:px-4 md:py-2 md:text-base lg:px-5 lg:py-3 lg:text-lg',
        'md' => 'px-3 py-1.5 text-base sm:px-4 sm:py-2 sm:text-base md:px-5 md:py-3 md:text-lg lg:px-6 lg:py-4 lg:text-xl',
        'lg' => 'px-4 py-2 text-lg sm:px-5 sm:py-3 sm:text-xl md:px-6 md:py-4 md:text-2xl lg:px-7 lg:py-5 lg:text-3xl',
    ];

    $classes = $colors[$color] . ' ' . $sizes[$size] . ' rounded-md font-medium flex items-center justify-center gap-2 transition-all duration-200 ' . ($fullWidth ? 'w-full' : '');
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($loading) disabled @endif>
    @if($loading)
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    @endif

    @if($icon && !$loading)
        <i class="{{ $icon }}"></i>
    @endif

    <span>{{ $slot }}</span>
</button>
