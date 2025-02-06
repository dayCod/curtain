<div class="countdown-container @yield('countdown-class', 'mt-12 text-center')">
    <div class="inline-block text-6xl font-mono text-white space-x-4 py-8">
        <div id="countdown" class="font-bold font-mono">
            Calculating...
        </div>
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
                    this.element.innerHTML = '<span class="text-curtain-500">Maintenance Complete</span>';

                    try {
                        const baseUrl = window.location.origin;
                        const response = await fetch(`${baseUrl}/curtain/disable`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            window.location.reload();
                        } else {
                            setTimeout(() => window.location.reload(), 5000);
                        }
                    } catch (error) {
                        setTimeout(() => window.location.reload(), 5000);
                    }
                    return;
                }

                const parts = this.formatTime(distance);
                this.element.innerHTML = parts.join('<span class="text-curtain-500 mx-2">:</span>');
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
