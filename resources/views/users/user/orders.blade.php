@extends('layouts.app')

@section('title', 'تمام سفارش ها')

@section('content')
    <div class="container mx-auto px-4 py-8" dir="rtl">
        <h1 class="mb-8 text-center text-3xl font-bold">تمام سفارش ها</h1>

        <!-- Loading State -->
        <div id="loadingState" class="py-12 text-center">
            <div
                    class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-blue-600 border-t-transparent"
            ></div>
            <p class="mt-2 text-gray-600">بارگزاری سفارش ...</p>
        </div>

        <!-- Orders Grid -->
        <div id="ordersContainer" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Orders will be loaded here -->
        </div>

        <!-- No Orders Message -->
        <div id="noOrdersMessage">
            <div class="rounded-lg bg-white p-8 text-center shadow-md">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="hidden" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    ></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">سفارش یافت نشد</h3>
                <p class="mt-1 text-sm text-gray-500">سفارشی ثبت نشده است.</p>
            </div>
        </div>

        <!-- Error Message -->
        <div id="errorMessage">
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-center">
                <svg class="mx-auto h-6 w-6 text-red-400" fill="hidden" stroke="currentColor" viewBox="0 0 24 24">
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
        const isAdmin = localStorage.getItem('user_role') === "Administrator";

        function showLoading() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('ordersContainer').classList.add('hidden');
            document.getElementById('noOrdersMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showError() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('ordersContainer').classList.add('hidden');
            document.getElementById('noOrdersMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.remove('hidden');
        }

        function showNoOrders() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('ordersContainer').classList.add('hidden');
            document.getElementById('noOrdersMessage').classList.remove('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showOrders() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('ordersContainer').classList.remove('hidden');
            document.getElementById('noOrdersMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        async function fetchOrders() {
            showLoading();

            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });

            try {
                const response = await fetch(`/api/users/user/orders`, {
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
                        displayOrders(data.result);
                        showOrders();
                    } else {
                        showNoOrders();
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

        function displayOrders(orders) {
            const container = document.getElementById('ordersContainer');
            container.innerHTML = orders
                .map(
                    (order) => `
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold">${order.id}</h3>
                    </div>
                    <div class="flex items-center justify-between">
                         <p class="font-medium text-gray-600">قیمت کل:</p>
                         <p class="text-gray-600">${order.total_price}</p>
                        </div>
                        <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-600">لغو شده:</p>
                                <p class="text-gray-600">${order.cancelled ? 'قبلا لغو شده است' : 'لغو نشده است'}</p>
                        </div>
                        <div class="mt-4 flex space-x-2">
                                <a href="/orders/${order.id}"
                                class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    مشاهده
                                </a>

                        </div>
                    </div>
                </div>
            `,).join('');
        }

        async function cancelOrder(orderId) {
            if (!confirm('مطمعن هستید می خواهید سفارش را لغو کنید؟')) {
                return;
            }

            try {
                const response = await fetch(`/api/orders/${orderId}/cancel`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    },
                    credentials: 'include',
                });

                const data = JSON.parse(await response.text());

                if (response.ok) {
                    alert(data.message);
                    await fetchOrders(); // Refresh the list
                } else {
                    if (response.status === 403) {
                        alert(data.message);
                        window.location.href = '/dashboard';
                        return;
                    }

                    if (data.errors) {
                        let errorMessage = '';
                        Object.keys(data.errors).forEach((key) => {
                            errorMessage += data.errors[key][0] + '\n';
                        });
                        alert(errorMessage);
                    } else {
                        alert(data.message || 'نتوانستیم سفارش را کنسل کنیم. دوباره تلاش کنید.');
                    }
                }
            } catch (error) {
                console.error('Error canceling order:', error);
                alert('نتوانستیم سفارش را کنسل کنیم. دوباره تلاش کنید.');
            }
        }

        fetchOrders();
    </script>
@endsection
