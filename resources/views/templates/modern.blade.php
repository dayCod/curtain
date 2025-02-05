@extends('curtain::templates.base')

@push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
@endpush

@section('body-class', 'bg-[#FFF5F3] min-h-screen flex items-center justify-center font-[Inter] relative overflow-hidden')

@section('container-class', 'max-w-3xl w-full mx-4 relative z-10')

@section('header')
    <div class="w-24 h-24 bg-gradient-to-br from-[#F17B6B] to-[#F7CAC1] rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg relative">
        {{-- Decorative background --}}
        <div class="absolute inset-0 bg-white/20 rounded-3xl backdrop-blur-sm"></div>

        {{-- Icon --}}
        <svg class="w-12 h-12 text-white relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
    </div>

    {{-- Decorative background elements --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-[#F17B6B]/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#F7CAC1]/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
@endsection

@section('content-class', 'bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl p-8 md:p-12 border border-white/50')

@section('title-class', 'text-3xl md:text-4xl font-bold text-[#F17B6B] mb-3 text-center')

@section('message-class', 'text-gray-600 md:text-lg text-center')

@section('maintenance-title', 'Under Maintenance')

@section('countdown-class', 'w-full max-w-sm bg-white/50 backdrop-blur-sm rounded-2xl p-6 text-center mx-auto mt-8 border border-white/50')

@section('additional-content')
    <div class="flex items-center justify-center space-x-3 text-sm text-gray-600 mt-8">
        <div class="relative">
            <div class="w-2.5 h-2.5 bg-[#F17B6B] rounded-full animate-pulse"></div>
            <div class="absolute top-0 left-0 w-2.5 h-2.5 bg-[#F17B6B]/50 rounded-full animate-ping"></div>
        </div>
        <span>System maintenance in progress</span>
    </div>
@endsection

@section('footer-content')
    <div class="text-gray-500 text-sm relative z-10">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
@endsection
