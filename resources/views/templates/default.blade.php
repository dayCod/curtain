<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Maintenance Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">We'll be back soon!</h1>

            @if($message)
                <p class="text-gray-600 mb-6">{{ $message }}</p>
            @endif

            @if($timer)
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Estimated time remaining:</p>
                    <div id="countdown" class="text-2xl font-mono text-blue-600">
                        Calculating...
                    </div>
                </div>

                <script>
                    const endTime = new Date('{{ $timer }}').getTime();

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
                            `${hours}h ${minutes}m ${seconds}s`;
                    }, 1000);
                </script>
            @endif

            @if($refresh)
                <script>
                    setTimeout(() => {
                        location.reload();
                    }, {{ config('curtain.refresh_interval', 60) * 1000 }});
                </script>
            @endif
        </div>
    </div>
</body>
</html>
