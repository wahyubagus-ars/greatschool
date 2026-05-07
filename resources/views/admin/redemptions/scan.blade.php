@extends('layouts.admin')

@section('title', 'Redeem QR Code')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Redeem QR Code</h1>
                <p class="mt-1 text-gray-600">Enter the QR code UUID to redeem student points</p>
            </div>

            {{-- Toast container for success/error badges --}}
            <div id="toast-area" class="px-6 pt-4 hidden">
                <div id="toast" class="flex items-center justify-between p-3 rounded-lg text-sm font-medium transition-all duration-300"></div>
            </div>

            <form id="redemption-form"
                  action="{{ route('admin.redemptions.process-scan') }}"
                  method="POST"
                  class="p-6 space-y-6"
                  novalidate>
            @csrf

            <!-- QR Code Input -->
                <div>
                    <label for="qr_code" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Redemption Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="qr_code"
                           name="qr_code"
                           class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5 font-mono text-lg uppercase tracking-widest text-center"
                           placeholder="e.g., ABC12XYZ"
                           autocomplete="off"
                           required
                           title="Enter exactly 8 characters: A-Z (excluding O, I, L) and 0-9"
                           maxlength="8">
                    <p class="mt-1 text-xs text-gray-500">
                        Enter the 8-character code shown on student's screen
                    </p>
                    <p class="mt-1 text-xs text-amber-600 font-medium">
                        💡 Excluded letters: O, I, L (to avoid confusion with 0, 1)
                    </p>
                </div>

                <!-- Location Selection -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Redemption Location <span class="text-red-500">*</span>
                    </label>
                    <select id="location"
                            name="location"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2.5"
                            required>
                        <option value="">Select location</option>
                        <option value="Canteen Main Hall">Canteen Main Hall</option>
                        <option value="Canteen Outdoor Area">Canteen Outdoor Area</option>
                        <option value="Canteen Snack Counter">Canteen Snack Counter</option>
                        <option value="Mobile Canteen">Mobile Canteen</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit"
                            id="submit-btn"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-300 text-white font-medium rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[140px] disabled:cursor-not-allowed">
                        <span id="btn-text">Redeem</span>
                        <svg id="btn-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Instructions (always visible) -->
            <div class="px-6 pb-6">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">How to Redeem</p>
                            <ol class="mt-2 text-sm text-blue-700 space-y-1.5 list-decimal list-inside">
                                <li>Ask student to show their redemption QR code</li>
                                <li>Scan QR with your phone's camera app</li>
                                <li>Copy the UUID text shown (format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx)</li>
                                <li>Paste UUID above, select location, and click Redeem</li>
                                <li>Verify student identity before confirming redemption</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('redemption-form');
                const qrInput = document.getElementById('qr_code');
                const locationSelect = document.getElementById('location');
                const submitBtn = document.getElementById('submit-btn');
                const btnText = document.getElementById('btn-text');
                const btnSpinner = document.getElementById('btn-spinner');
                const toastArea = document.getElementById('toast-area');
                const toast = document.getElementById('toast');

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                function updateSubmitState() {
                    submitBtn.disabled = !form.checkValidity();
                }

                qrInput.addEventListener('input', updateSubmitState);
                locationSelect.addEventListener('change', updateSubmitState);

                form.addEventListener('submit', async function(e) {
                    e.preventDefault();       // STOP normal form submission
                    e.stopPropagation();

                    submitBtn.disabled = true;
                    btnText.textContent = 'Processing...';
                    btnSpinner.classList.remove('hidden');
                    hideToast();

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                qr_code: qrInput.value.trim(),
                                location: locationSelect.value
                            })
                        });

                        if (!response.ok) {
                            const errorData = await response.json().catch(() => null);
                            throw new Error(errorData?.message || 'Server error. Please try again.');
                        }

                        const data = await response.json();
                        showToast('success', `✅ Redeemed! ${data.student_name} · Rp ${new Intl.NumberFormat('id-ID').format(data.idr_value)}`);
                        form.reset();
                        updateSubmitState();
                        setTimeout(() => qrInput.focus(), 100);

                    } catch (error) {
                        showToast('error', `❌ ${error.message}`);
                        console.error(error);
                    } finally {
                        submitBtn.disabled = false;
                        btnText.textContent = 'Redeem';
                        btnSpinner.classList.add('hidden');
                    }
                });

                function showToast(type, message) {
                    toast.className = `flex items-center justify-between p-3 rounded-lg text-sm font-medium transition-all duration-300 ${
                        type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200'
                    }`;
                    toast.innerHTML = `
                <span>${escapeHtml(message)}</span>
                <button type="button" class="ml-3 hover:opacity-75" onclick="this.parentElement.parentElement.classList.add('hidden')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;
                    toastArea.classList.remove('hidden');

                    // Auto-dismiss after 5 seconds
                    clearTimeout(window.toastTimer);
                    window.toastTimer = setTimeout(hideToast, 5000);
                }

                function hideToast() {
                    toastArea.classList.add('hidden');
                }

                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                // Initial state
                updateSubmitState();
                qrInput.focus();
            });
        </script>
    @endpush
@endsection
