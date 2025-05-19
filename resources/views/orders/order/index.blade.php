@extends('layouts.app')

@section('title', 'نمایش سفارش')

@section('content')
    <div class="container mx-auto px-4 py-8" dir="rtl">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-right">نمایش سفارش</h1>

            <!-- Loading State -->
            <div id="loadingState" class="py-12 text-center">
                <div
                        class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-blue-600 border-t-transparent"
                ></div>
                <p class="mt-2 text-gray-600">بارگزاری سفارش ...</p>
            </div>

            <div id="orderContainer" class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                نام
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                عکس
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
                        </tr>
                        </thead>
                        <tbody id="orderTableBody" class="divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-200 mt-6 pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800">مجموع کل:</span>
                        <span id="orderTotal" class="text-2xl font-bold text-gray-900">0 تومان</span>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errorMessage">
                    <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-center">
                        <svg class="mx-auto h-6 w-6 text-red-400" fill="hidden" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-red-800">خطا در گرفتن اطلاعات</h3>
                        <p class="mt-1 text-sm text-red-600">
                            لطفا بعدا تلاش کنید
                        </p>
                        <button
                                onclick="fetchOrders()"
                                class="mt-4 inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                        >
                            بارگزاری مجدد
                        </button>
                    </div>
                </div>
            </div>

            <script>
                const orderId = window.location.pathname.split('/')[2]

                function showLoading() {
                    document.getElementById('loadingState').classList.remove('hidden');
                    document.getElementById('orderContainer').classList.add('hidden');
                    document.getElementById('errorMessage').classList.add('hidden');
                }

                function showError() {
                    document.getElementById('loadingState').classList.add('hidden');
                    document.getElementById('orderContainer').classList.add('hidden');
                    document.getElementById('errorMessage').classList.remove('hidden');
                }

                function showNoOrder() {
                    document.getElementById('loadingState').classList.add('hidden');
                    document.getElementById('orderContainer').classList.add('hidden');
                    document.getElementById('errorMessage').classList.add('hidden');
                }

                function showOrder() {
                    document.getElementById('loadingState').classList.add('hidden');
                    document.getElementById('orderContainer').classList.remove('hidden');
                    document.getElementById('errorMessage').classList.add('hidden');
                }

                async function fetchOrder() {
                    showLoading();

                    await fetch('/sanctum/csrf-cookie', {
                        credentials: 'include',
                    });

                    try {
                        const response = await fetch(`/api/orders/${orderId}/show`, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            },
                            credentials: 'include',
                        });

                        const data = JSON.parse(await response.text());

                        if (response.ok) {
                            if (data.result && data.result.length > 0) {
                                displayOrder(data.result);
                                showOrder();
                            } else {
                                showNoOrder();
                            }
                        } else {
                            if (response.status === 403) {
                                alert(data.message);
                                window.location.href = '/dashboard';
                            }
                        }
                    } catch (error) {
                        console.error('Error fetching orders:', error);
                        showError();
                    }
                }

                function displayOrder(items) {
                    const orderTableBody = document.getElementById('orderTableBody');
                    const orderTotal = document.getElementById('orderTotal');

                    let total = 0;

                    orderTableBody.innerHTML = items.map(item => {
                        total += item.price * item.quantity;
                        return `
                        <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><img class="w-10 h-10 rounded-full" src="/${item.img_url}" alt="foodImage"/></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.quantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${numberWithCommas(item.price)} تومان</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${numberWithCommas(item.quantity * item.price)} تومان</td>
            </tr>
            `
                    }).join('');

                    orderTotal.textContent = `${total.toLocaleString()} تومان`;
                }

                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                fetchOrder()
            </script>
@endsection
