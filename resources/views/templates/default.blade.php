@extends('curtain::templates.base')

@section('body-class', 'bg-gradient-to-br from-[#FFF5F3] to-white min-h-screen flex items-center justify-center')

@section('container-class', 'max-w-2xl w-full mx-4')

@section('content-class', 'bg-white rounded-2xl shadow-lg p-8 text-center border border-[#F7CAC1]/20')

@section('title-class', 'text-3xl font-bold text-[#F17B6B] mb-4 tracking-tight')

@section('message-class', 'text-gray-600 mb-6')

@section('maintenance-title', 'We\'ll be right back!')

@section('additional-content')
    <div class="mt-8 flex flex-col items-center">
        <div class="relative">
            {{-- Background circles for visual interest --}}
            <div class="absolute -inset-4 bg-[#F7CAC1]/10 rounded-full blur-lg"></div>
            <div class="relative flex items-center gap-3">
                <div class="w-2 h-2 bg-[#F17B6B] rounded-full animate-pulse"></div>
                <span class="text-sm text-gray-600">System maintenance in progress</span>
            </div>
        </div>

        {{-- Decorative elements --}}
        <div class="mt-12 flex gap-2 opacity-30">
            @foreach(range(1, 3) as $i)
                <div class="w-1 h-1 rounded-full bg-[#F17B6B]"></div>
            @endforeach
        </div>
    </div>
@endsection
