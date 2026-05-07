@extends('layouts.student')

@section('title', __('Redemption Code'))

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ __('Your Redemption Code') }}</h1>
            <p class="mt-1 text-gray-600">{{ __('Show this code to canteen staff') }}</p>
        </div>
        <a href="{{ route('student.redemptions.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[100px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            {{ __('My Redemptions') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- QR Code Display -->
            <div class="p-6 text-center border-b border-gray-200">
                <div class="inline-block p-4 bg-white rounded-xl border-2 border-dashed border-gray-300 mb-4">
                    {!! $qrCode !!}
                </div>

                <!-- PROMINENT CODE DISPLAY - Easy to read/communicate -->
                <div class="mt-4">
                    <p class="text-sm text-gray-500 mb-2">{{ __('Redemption Code') }}</p>
                    <div class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 rounded-lg border border-gray-300">
                        <code class="text-2xl font-bold tracking-widest text-gray-900 font-mono" id="redemption-code">
                            {{ $redemption->qr_code }}
                        </code>
                        <button type="button"
                                onclick="copyCode()"
                                class="ml-3 p-2 text-gray-500 hover:text-indigo-600 transition-colors"
                                title="{{ __('Copy code') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        {{ __('💡 Tip: Read this code aloud to canteen staff if QR won\'t scan') }}
                    </p>
                </div>

                <p class="mt-4 text-sm text-gray-500">
                    {{ __('Valid until:') }} <span class="font-medium text-gray-900">{{ $redemption->expires_at->format('H:i:s') }}</span>
                </p>
            </div>

            <!-- Redemption Details -->
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-500">{{ __('Points Redeemed') }}</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">{{ $redemption->points_redeemed }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-green-700">{{ __('Voucher Value') }}</p>
                        <p class="mt-1 text-2xl font-bold text-green-700">Rp {{ number_format($redemption->idr_value, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-amber-50 rounded-xl p-4 border border-amber-200 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-amber-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-amber-800">{{ __('Important Notes') }}</p>
                            <ul class="mt-1 text-sm text-amber-700 space-y-1">
                                <li>• {{ __('Code expires in 15 minutes') }}</li>
                                <li>• {{ __('Each code can only be used once') }}</li>
                                <li>• {{ __('Show QR or tell staff the 8-character code') }}</li>
                                <li>• {{ __('Keep this code private - don\'t share with others') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="window.print()"
                            class="flex-1 inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        {{ __('Print Code') }}
                    </button>
                    <a href="{{ route('student.redemptions.index') }}"
                       class="flex-1 inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Done') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Countdown Timer -->
        <div class="mt-6 text-center">
            <div id="countdown" class="text-2xl font-bold text-gray-800"></div>
            <p class="mt-1 text-sm text-gray-500">{{ __('Time remaining before code expires') }}</p>
        </div>
    </div>

    @push('scripts')
        <script>
            // Copy code to clipboard
            function copyCode() {
                const code = document.getElementById('redemption-code').textContent.trim();
                navigator.clipboard.writeText(code).then(() => {
                    const btn = event.currentTarget;
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    setTimeout(() => btn.innerHTML = originalHtml, 2000);
                });
            }

            // Countdown timer
            const expiresAt = new Date("{{ $redemption->expires_at->toIso8601String() }}").getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = expiresAt - now;

                if (distance < 0) {
                    document.getElementById('countdown').textContent = '{{ __('EXPIRED') }}';
                    document.getElementById('countdown').className = 'text-2xl font-bold text-red-600';
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('countdown').textContent =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            setInterval(() => {
                if (new Date().getTime() > expiresAt) {
                    location.reload();
                }
            }, 5000);
        </script>
    @endpush
@endsection
