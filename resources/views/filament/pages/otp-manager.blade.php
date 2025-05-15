<x-filament::page>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- Kartu Form Generate OTP --}}
            <div class="flex-1 bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label for="tipe" class="block text-base font-semibold text-gray-700 dark:text-gray-200">Tipe OTP</label>
                        <select
                            wire:model="tipe"
                            id="tipe"
                            class="block w-full mt-1 text-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500"
                        >
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                        </select>
                    </div>

                    <button
                        wire:click="generateOtp"
                        type="button"
                        class="w-full text-lg font-semibold px-4 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors"
                    >
                        Generate OTP
                    </button>
                </div>
            </div>

            {{-- Kartu OTP Saat Ini --}}
            <x-filament::card class="flex-1 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-6 rounded-xl">
                @if ($currentOtp)
                    <h3 class="text-2xl font-bold mb-4 text-center">OTP Saat Ini</h3>
                    <div class="bg-gray-100 dark:bg-gray-800 text-center text-4xl font-extrabold tracking-widest py-4 rounded-lg mb-6">
                        {{ $currentOtp->otp }}
                    </div>
                    <ul class="space-y-2 text-lg text-center">
                        <li><span class="font-medium">Tipe OTP:</span> {{ ucfirst($currentOtp->tipe) }}</li>
<li 
    x-data="{
        expiresAt: new Date('{{ $currentOtp->end_time->format('Y-m-d H:i:s') }}').getTime(),
        remaining: '',
        timer: null,
        updateTimer() {
            const now = new Date().getTime();
            const distance = this.expiresAt - now;

            if (distance < 0) {
                this.remaining = 'Expired';
                clearInterval(this.timer);
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            this.remaining = `${minutes}m ${seconds < 10 ? '0' : ''}${seconds}s`;
        },
        init() {
            this.updateTimer();
            this.timer = setInterval(() => this.updateTimer(), 1000);
        }
    }"
>
    <span class="font-medium">Sisa Waktu:</span> <span x-text="remaining" class="font-mono"></span>
</li>
                    </ul>
                @else
                    <p class="text-xl text-center text-gray-600 dark:text-gray-400">Belum ada OTP aktif.</p>
                @endif
            </x-filament::card>

        </div>
    </div>
</x-filament::page>
