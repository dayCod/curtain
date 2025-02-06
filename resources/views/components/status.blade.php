<div @class([
    'flex items-center justify-center space-x-3 mb-8',
    $class ?? ''
])>
    <div class="relative">
        <div class="w-3 h-3 bg-curtain-500 rounded-full"></div>
        <div class="absolute top-0 left-0 w-3 h-3 bg-curtain-500/50 rounded-full animate-ping"></div>
    </div>
    <span class="text-white/60 uppercase tracking-wider text-sm font-medium">
        @if(isset($status))
            {{ $status }}
        @else
            Please wait until the site is ready to use 🚀
        @endif
    </span>
</div>
