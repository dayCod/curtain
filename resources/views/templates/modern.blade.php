<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Maintenance Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-[Inter]">
    <div class="max-w-3xl w-full mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
            <div class="flex flex-col items-center justify-center space-y-6">
                <!-- Maintenance Icon -->
                <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>

                <!-- Title -->
                <div class="text-center">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Under Maintenance</h1>
                    @if($message)
                        <p class="text-gray-600 md:text-lg">{{ $message }}</p>
                    @else
                        <p class="text-gray-600 md:text-lg">We're working hard to improve our system for you.</p>
                    @endif
                </div>

                <!-- Timer Section -->
                @if($timer)
                    <div class="w-full max-w-sm bg-gray-50 rounded-xl p-6 text-center">
                        <p class="text-gray-500 mb-3">Estimated time remaining</p>
                        <div id="countdown" class="text-3xl font-semibold text-blue-600 font-mono">
                            Calculating...
                        </div>
                    </div>

                    <script>
                        const endTime = new Date('{{ $timer }}').getTime();

                        const formatNumber = (number) => number.toString().padStart(2, '0');

                        const countdown = setInterval(() => {
                            const now = new Date().getTime();
                            const distance = endTime - now;

                            if (distance < 0) {
                                clearInterval(countdown);
                                document.getElementById('countdown').innerHTML = 'Refreshing...';
                                location.reload();
                                return;
                            }

                            const hours = Math.floor(distance / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            document.getElementById('countdown').innerHTML =
                                `${formatNumber(hours)}:${formatNumber(minutes)}:${formatNumber(seconds)}`;
                        }, 1000);
                    </script>
                @endif

                <!-- Status Indicator -->
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                    <span>System maintenance in progress</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>

    @if($refresh)
        <script>
            setTimeout(() => {
                location.reload();
            }, {{ config('curtain.refresh_interval', 60) * 1000 }});
        </script>
    @endif
</body>
</html>
