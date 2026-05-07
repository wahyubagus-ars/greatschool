@extends('layouts.student')

@section('title', 'Generate Redemption QR')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Generate Redemption QR</h1>
            <p class="mt-1 text-gray-600">Redeem your points for canteen vouchers</p>
        </div>
        <a href="{{ route('student.redemptions.index') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[100px]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 mr-1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-5 md:p-6">
            <div class="mb-6 p-4 bg-indigo-50 rounded-xl border border-indigo-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-indigo-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-indigo-800">How it works</p>
                        <ul class="mt-1 text-sm text-indigo-700 space-y-1">
                            <li class="flex items-start">
                                <span class="inline-flex items-center justify-center w-1.5 h-1.5 mr-2 mt-1 rounded-full bg-indigo-400"></span>
                                <span>Enter the number of points you want to redeem (minimum 10 points)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-flex items-center justify-center w-1.5 h-1.5 mr-2 mt-1 rounded-full bg-indigo-400"></span>
                                <span>10 points = 1,000 IDR (Rp 1,000)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-flex items-center justify-center w-1.5 h-1.5 mr-2 mt-1 rounded-full bg-indigo-400"></span>
                                <span>QR code is valid for 15 minutes after generation</span>
                            </li>
                            <li class="flex items-start">
                                <span class="inline-flex items-center justify-center w-1.5 h-1.5 mr-2 mt-1 rounded-full bg-indigo-400"></span>
                                <span>Show QR code to canteen staff to redeem your voucher</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('student.redemptions.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="points" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Points to Redeem <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number"
                               name="points"
                               id="points"
                               min="10"
                               max="{{ $maxPoints }}"
                               step="10"
                               value="10"
                               class="block w-full rounded-lg border-gray-300 pl-4 pr-12 py-3 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Enter points (min 10)"
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">pts</span>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Available points: <span class="font-medium text-gray-900">{{ $student->available_points }}</span> •
                        Equivalent to: <span class="font-medium text-green-700">Rp {{ number_format(($student->available_points * 100), 0, ',', '.') }}</span>
                    </p>
                    @error('points')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Estimated Value:</span>
                        <span id="idr-value" class="text-lg font-bold text-green-700">Rp 1,000</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">10 points = Rp 1,000 • Calculation updates as you type</p>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('student.redemptions.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 min-w-[140px]">
                        Generate QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('points').addEventListener('input', function() {
                const points = parseInt(this.value) || 0;
                const idrValue = (points * 1000) / 10;
                document.getElementById('idr-value').textContent =
                    'Rp ' + new Intl.NumberFormat('id-ID').format(idrValue);
            });
        </script>
    @endpush
@endsection
