@extends('curtain::templates.base')

@section('body-class', 'bg-black min-h-screen flex items-center justify-center')

@section('container-class', 'max-w-4xl w-full mx-4 relative z-10')

@section('content-class', 'text-center')

@section('title-class', 'text-8xl font-bold text-white mb-6 tracking-tight')

@section('message-class', 'text-curtain-200/80 text-xl mb-8')

@section('maintenance-title', 'Oops Website is under maintenance')

@section('additional-content')
    <div class="mt-12">
        <div class="text-white/60 uppercase tracking-wider text-sm">
            Our site is under construction
        </div>
    </div>
@endsection
