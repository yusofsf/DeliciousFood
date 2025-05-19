@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
    <div class="flex min-h-screen flex-col px-4 py-8">
        <div id="dashboardContainer" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div class="flex flex-col rounded-lg border bg-gray-700 p-4">
                <h3 id="orders-h3" class="mx-auto mb-2 text-lg font-semibold text-white">مدیریت سفارش ها</h3>
                <button onclick="orders()"
                        class="mx-auto cursor-pointer rounded bg-gray-600 hover:bg-gray-800 px-4 py-2 text-gray-100">
                    سفارش ها
                </button>
            </div>

            <div class="flex flex-col rounded-lg border bg-gray-700 p-4">
                <h3 id="foods-h3" class="mx-auto mb-2 text-lg font-semibold text-white">مدیریت غذاها</h3>
                <button onclick="foods()"
                        class="mx-auto cursor-pointer rounded bg-gray-600 hover:bg-gray-800 px-4 py-2 text-gray-100">غذا
                    ها
                </button>
            </div>

            <div class="flex flex-col rounded-lg border bg-gray-700 p-4">
                <h3 id="drinks-h3" class="mx-auto mb-2 text-lg font-semibold text-white">مدیریت نوشیدنی ها</h3>
                <button onclick="drinks()"
                        class="mx-auto cursor-pointer rounded bg-gray-600 hover:bg-gray-800 px-4 py-2 text-gray-100">
                    نوشیدنی ها
                </button>
            </div>
            <div class="flex flex-col rounded-lg border bg-gray-700 p-4 hidden" id="extrasDiv">
                <h3 class="mx-auto mb-2 text-lg font-semibold text-white">تاریخچه پیش غذاها</h3>
                <button onclick="extras()"
                        class="mx-auto cursor-pointer rounded bg-gray-600 hover:bg-gray-800 px-4 py-2 text-gray-100">
                    پیش غذا ها
                </button>
            </div>

            <div class="flex flex-col rounded-lg border bg-gray-700 p-4" id="usersDiv">
                <h3 class="mx-auto mb-2 text-lg font-semibold text-white">مدیریت کاربران</h3>
                <button id="users" onclick="users()"
                        class="mx-auto cursor-pointer rounded bg-gray-600 hover:bg-gray-800 px-4 py-2 text-gray-100">
                    کاربران
                </button>
            </div>
        </div>
    </div>
    <script>
        const userRole = localStorage.getItem('user_role');

        function orders() {
            if (userRole === "Administrator") {
                window.location.href = `/orders`;
            } else {
                window.location.href = `/users/user/orders`;
            }
        }

        function users() {
            if (userRole === "Administrator") {
                window.location.href = `/users`;
            }
        }

        function drinks() {
            if (userRole === "Administrator") {
                window.location.href = `/drinks`;
            } else {
                window.location.href = `/users/user/orders/drinks`;
            }
        }

        function foods() {
            if (userRole === "Administrator") {
                window.location.href = `/foods`;
            } else {
                window.location.href = `/users/user/orders/foods`;
            }
        }

        function extras() {
            if (userRole !== "Administrator") {

                window.location.href = `/users/user/orders/extras`;
            }
        }

        function showOptions(role) {
            const usersDiv = document.getElementById('usersDiv');
            const extrasDiv = document.getElementById('extrasDiv');
            const drinksh3 = document.getElementById('drinks-h3');
            const foodsh3 = document.getElementById('foods-h3');
            const ordersh3 = document.getElementById('orders-h3');

            if (!role) return;

            switch (role) {
                case 'Costumer':
                    if (usersDiv) usersDiv.classList.add('hidden');
                    if (extrasDiv) extrasDiv.classList.remove('hidden');
                    if (drinksh3) drinksh3.innerText = "تاریخچه نوشیدنی ها";
                    if (foodsh3) foodsh3.innerText = "تاریخچه غذا ها";
                    if (ordersh3) ordersh3.innerText = "تاریخچه سفارش ها";
                    break;
            }
        }

        showOptions(localStorage.getItem('user_role'));
    </script>
@endsection
