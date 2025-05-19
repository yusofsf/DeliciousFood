@extends('layouts.app')

@section('title', 'سفارشات پیش غذا')

@section('content')
    <div class="container mx-auto px-4 py-8" dir="rtl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">سفارشات پیش غذا</h1>
            </div>

            <div id="loadingState" class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-gray-900"></div>
            </div>

            <div id="extrasContainer" class="hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                نام پیش غذا
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                تعداد
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                قیمت واحد
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                قیمت کل
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                تاریخ سفارش
                            </th>
                        </tr>
                        </thead>
                        <tbody id="extrasTableBody" class="divide-y divide-gray-200">
                        <!-- Orders will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="noExtrasMessage" class="text-center py-8 hidden">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">سفارشی یافت نشد</h3>
                <p class="mt-1 text-sm text-gray-500">شما هنوز هیچ سفارش پیش غذا ثبت نکرده‌اید.</p>
            </div>
        </div>
    </div>

    <script>
        async function fetchExtras() {
            const loadingState = document.getElementById('loadingState');
            const extrasContainer = document.getElementById('extrasContainer');
            const noExtrasMessage = document.getElementById('noExtrasMessage');

            loadingState.classList.remove('hidden');
            extrasContainer.classList.add('hidden');
            noExtrasMessage.classList.add('hidden');

            try {
                const response = await fetch(`/api/users/user/orders/extras`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    },
                    credentials: 'include',
                });

                const data = await response.json();

                if (response.ok) {
                    if (data.result && data.result.length > 0) {
                        renderExtras(data.result);
                        extrasContainer.classList.remove('hidden');
                    } else {
                        noExtrasMessage.classList.remove('hidden');
                    }
                } else {
                    if (response.status === 403) {
                        alert(data.message);
                        window.location.href = '/login';
                    } else {
                        alert('خطا در دریافت اطلاعات سفارشات');
                    }
                }
            } catch (error) {
                console.error('Error fetching extras:', error);
                alert('خطا در دریافت اطلاعات سفارشات');
            } finally {
                loadingState.classList.add('hidden');
            }
        }

        function renderExtras(extras) {
            const extrasTableBody = document.getElementById('extrasTableBody');

            extrasTableBody.innerHTML = extras.map(extra => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${extra.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${extra.quantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${numberWithCommas(extra.price)} تومان</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${numberWithCommas(extra.quantity * extra.price)} تومان</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatDate(extra.created_at)}</td>
            </tr>
        `).join('');
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('fa-IR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Initial fetch
        fetchExtras();
    </script>
@endsection
