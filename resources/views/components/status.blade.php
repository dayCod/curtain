<div @class([
    'flex items-center justify-center space-x-2 my-4',
    $class ?? ''
])>
    <div class="relative">
        {{-- Pulsing dot --}}
        <div class="w-2.5 h-2.5 bg-blue-500 rounded-full"></div>
        <div class="absolute top-0 left-0 w-2.5 h-2.5 bg-blue-500 rounded-full animate-ping opacity-75"></div>
    </div>

    {{-- Status text --}}
    <span class="text-sm text-gray-600">
        @if(isset($status))
            {{ $status }}
        @else
            System maintenance in progress
        @endif
    </span>
</div>
