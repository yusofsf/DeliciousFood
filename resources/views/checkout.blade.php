@extends('layouts.app')

@section('title', 'تایید سفارش')

@section('content')
    <div class="container mx-auto px-4 py-8" dir="rtl">
        <div class="max-w-4xl mx-auto bg-white p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-right">تایید سفارش</h1>

            <div id="cartsContainer" class="hidden">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 text-right">سبد خرید</h2>
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
                        <tbody id="cartsTableBody" class="divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 mt-6 pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-800">مجموع کل:</span>
                        <span id="cartTotal" class="text-2xl font-bold text-gray-900">0 تومان</span>
                    </div>

                    <button onclick="submitOrder()"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        ثبت سفارش
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function fetchCart() {
            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });
            try {
                const response = await fetch(`/api/cart`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    },
                    credentials: 'include',
                });

                const data = JSON.parse(await response.text());

                if (response.ok) {
                    if (data.result[0].items && data.result[0].items.length > 0) {
                        document.getElementById('cartsContainer').classList.remove('hidden')
                        renderCart(data.result[0].items);
                    }
                } else {
                    if (response.status === 403) {
                        alert(data.message);
                        window.location.href = '/login';
                    }
                }
            } catch (error) {
                console.error('Error fetching cart:', error);
                alert('خطا در دریافت اطلاعات سبد خرید');
            }
        }

        function renderCart(items) {
            const cartsTableBody = document.getElementById('cartsTableBody');
            const cartTotal = document.getElementById('cartTotal');

            let total = 0;

            cartsTableBody.innerHTML = items.map(item => {
                total += item.price * item.quantity;
                return `
                        <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><img class="w-10 h-10 rounded-full" src="${item.img_url}" alt="foodImage"/></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.quantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${numberWithCommas(item.price)} تومان</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${numberWithCommas(item.quantity * item.price)} تومان</td>
            </tr>
            `
            }).join('');

            cartTotal.textContent = `${total.toLocaleString()} تومان`;
        }

        async function submitOrder() {
            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });
            try {
                const response = await fetch(`/api/orders/cart/confirm`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    },
                    credentials: 'include',
                });

                const data = JSON.parse(await response.text());


                if (response.ok) {
                    if (data.message === 'first verify your email') {
                        alert('لطفا ایمیل خود را تایید کنید');
                        window.location.href = '/verify-email';
                        return;
                    }
                    alert('سفارش شما با موفقیت ثبت شد');
                    window.location.href = '/dashboard';
                } else {
                    if (response.status === 403) {
                        alert(data.message);
                        window.location.href = '/login';
                    } else {
                        alert('خطا در ثبت سفارش');
                    }
                }
            } catch (error) {
                console.error('Error submitting order:', error);
                alert('خطا در ثبت سفارش');
            }
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Fetch cart items when page loads
        fetchCart();
    </script>
@endsection
