<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Maintenance Mode')</title>

    {{-- Base Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="@yield('body-class', 'bg-gray-50 min-h-screen flex items-center justify-center')">
    <div class="@yield('container-class', 'max-w-3xl w-full mx-4')">
        {{-- Header Section --}}
        @section('header')
            @include('curtain::components.status')
        @show

        {{-- Main Content --}}
        @section('content')
            <div class="@yield('content-class', 'bg-white rounded-lg shadow-lg p-8')">
                {{-- Title & Message --}}
                @section('message')
                    <h1 class="@yield('title-class', 'text-3xl font-bold text-gray-900 mb-4')">
                        @yield('maintenance-title', 'Under Maintenance')
                    </h1>

                    @if($message)
                        <p class="@yield('message-class', 'text-gray-600')">{{ $message }}</p>
                    @endif
                @show

                {{-- Countdown Timer --}}
                @if($timer)
                    @include('curtain::components.countdown', ['timer' => $timer])
                @endif

                {{-- Additional Content --}}
                @yield('additional-content')
            </div>
        @show

        {{-- Footer Section --}}
        @section('footer')
            <div class="text-center mt-8 text-gray-500 text-sm">
                @yield('footer-content', '&copy; ' . date('Y') . ' ' . config('app.name'))
            </div>
        @show
    </div>

    {{-- Base Scripts --}}
    @stack('scripts')

    @if($refresh)
        <script>
            setTimeout(() => {
                location.reload();
            }, {{ config('curtain.refresh_interval', 60) * 1000 }});
        </script>
    @endif
</body>
</html>
