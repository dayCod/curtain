<div class="countdown-container @yield('countdown-class', 'mt-8 text-center')">
    <p class="text-sm text-gray-500 mb-2">Estimated time remaining:</p>
    <div id="countdown" class="text-2xl font-mono text-[#F17B6B]">
        Calculating...
    </div>
</div>

@once
    @push('scripts')
    <script>
        class Countdown {
            constructor(element, endTime) {
                this.element = element;
                this.endTime = new Date(endTime).getTime();
                this.interval = null;
            }

            start() {
                this.update();
                this.interval = setInterval(() => this.update(), 1000);
            }

            async update() {
                const now = new Date().getTime();
                const distance = this.endTime - now;

                if (distance < 0) {
                    clearInterval(this.interval);
                    this.element.innerHTML = 'Maintenance Complete';

                    try {
                        const baseUrl = window.location.origin; // Get base URL
                        const response = await fetch(`${baseUrl}/curtain/disable`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            const data = await response.json();
                            console.log('Data:', data);
                            window.location.reload();
                        } else {
                            console.error('Failed to disable maintenance mode:', response.statusText);
                            setTimeout(() => window.location.reload(), 5000);
                        }
                    } catch (error) {
                        console.error('Failed to disable maintenance mode:', error);
                        setTimeout(() => window.location.reload(), 5000);
                    }
                    return;
                }

                const parts = this.formatTime(distance);
                this.element.innerHTML = parts.join(':');
            }

            formatTime(distance) {
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                return [hours, minutes, seconds].map(unit =>
                    String(unit).padStart(2, '0')
                );
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const element = document.getElementById('countdown');
            const timer = new Countdown(element, '{{ $timer }}');
            timer.start();
        });
    </script>
    @endpush
@endonce
