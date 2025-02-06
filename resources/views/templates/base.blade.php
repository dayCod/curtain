<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Maintenance Mode')</title>

    {{-- Base Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'curtain': {
                            50: '#FFF5F3',
                            100: '#FFF1ED',
                            200: '#F7CAC1',
                            300: '#F5B3A7',
                            400: '#F39C8D',
                            500: '#F17B6B',
                            600: '#D86E5F',
                            700: '#BF6154',
                            800: '#A65448',
                            900: '#8C473C'
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="@yield('body-class', 'bg-black min-h-screen flex items-center justify-center overflow-hidden')">
    <div class="fixed inset-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIvPjwvc3ZnPg==')] [mask-image:radial-gradient(ellipse_at_center,transparent_20%,black_75%)]"></div>
    </div>

    <div class="@yield('container-class', 'max-w-3xl w-full mx-4 relative z-10')">
        {{-- Header Section --}}
        @section('header')
            @include('curtain::components.status')
        @show

        {{-- Main Content --}}
        @section('content')
            <div class="@yield('content-class', 'text-center')">
                {{-- Title & Message --}}
                @section('message')
                    <h1 class="@yield('title-class', 'text-7xl font-bold text-white mb-4 tracking-tight')">
                        @if ($message)
                        <h1 class="text-7xl font-bold text-white mb-6 tracking-tight">
                            {{ $message }}
                        </h1>
                        @else
                            @yield('maintenance-title', 'Under Maintenance')
                        @endif
                    </h1>
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
            <div class="text-center mt-8 text-white/30 text-sm">
                @yield('footer-content', '© ' . date('Y') . ' ' . config('app.name'))
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
