@extends('curtain::templates.base')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap">
@endpush

@section('body-class', 'bg-black min-h-screen flex items-center justify-center font-["Space_Grotesk"] relative')

@section('container-class', 'max-w-4xl w-full mx-4 relative z-10')

@section('header')
    <div class="relative z-10">
        {{-- Animated gradient mesh --}}
        <div class="absolute top-[-250px] left-1/2 transform -translate-x-1/2 w-[500px] h-[500px] bg-gradient-to-r from-curtain-500/30 to-curtain-300/30 rounded-full blur-3xl animate-pulse"></div>
    </div>
@endsection

@section('content-class', 'text-center relative z-10')

@section('title-class', 'text-[120px] font-light text-white mb-6 tracking-tight leading-none')

@section('message-class', 'text-curtain-200/80 text-2xl font-light tracking-wide mb-12')

@section('maintenance-title')
    <div class="flex flex-col items-center space-y-1">
        <div class="text-base uppercase tracking-[0.2em] text-white/40 mb-4">System Status</div>
        <div class="text-7xl font-light">
            <span class="tabular-nums">Under</span>
            <span class="text-curtain-500 mx-2">Maintenance</span>
        </div>
    </div>
@endsection

@section('countdown-class', 'backdrop-blur-sm bg-white/5 border border-white/10 rounded-lg p-8')

@section('additional-content')
    <div class="flex flex-col items-center space-y-6">
        <div class="w-px h-16 bg-gradient-to-b from-curtain-500/50 to-transparent"></div>
        <div class="text-white/40 uppercase tracking-[0.3em] text-sm font-light">
            Our site is being updated
        </div>
    </div>
@endsection

@section('footer')
    <div class="text-center mt-5">
        <div class="text-white/20 text-sm tracking-wider">
            &copy; {{ date('Y') }} {{ config('app.name') }}
            <span class="mx-2">|</span>
            <span class="text-curtain-500/40">v1.0.0</span>
        </div>
    </div>
@endsection

@push('styles')
<style>
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>
@endpush
