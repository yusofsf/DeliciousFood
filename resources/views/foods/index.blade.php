@extends('layouts.app')

@section('title', 'تمام غذاها')

@section('content')
    <h1 class="mb-8 text-center text-3xl font-bold">تمام غذاها</h1>

    <!-- Loading State -->
    <div id="loadingState" class="py-12 text-center">
        <div
                class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-blue-600 border-t-transparent"
        ></div>
        <p class="mt-2 text-gray-600">بارگزاری غذا ...</p>
    </div>

    <!-- Orders Grid -->
    <div id="foodsContainer" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Orders will be loaded here -->
    </div>

    <!-- No Orders Message -->
    <div id="noFoodsMessage">
        <div class="rounded-lg bg-white p-8 text-center shadow-md">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="hidden" stroke="currentColor" viewBox="0 0 24 24">
                <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                ></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">غذا یافت نشد</h3>
            <p class="mt-1 text-sm text-gray-500">غذایی ثبت نشده است.</p>
        </div>
    </div>

    <div class="rounded-lg border border-green-200 bg-blue-100 p-4 text-center mt-5">
        <p class="mt-2 text-sm text-blue-400">ایجاد غذا</p>
        <a href="/foods/create"
           class="mt-4 inline-flex items-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
            ایجاد
        </a>
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
                    onclick="fetchFoods()"
                    class="mt-4 inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
            >
                بارگزاری مجدد
            </button>
        </div>
    </div>

    <script>
        const isAdmin = localStorage.getItem('user_role') === "Administrator";
        const isUser = localStorage.getItem('user_role') === "Costumer";

        function showLoading() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('foodsContainer').classList.add('hidden');
            document.getElementById('noFoodsMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showError() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('foodsContainer').classList.add('hidden');
            document.getElementById('noFoodsMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.remove('hidden');
        }

        function showNoFoods() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('foodsContainer').classList.add('hidden');
            document.getElementById('noFoodsMessage').classList.remove('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showFoods() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('foodsContainer').classList.remove('hidden');
            document.getElementById('noFoodsMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        async function fetchFoods() {
            showLoading();

            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });

            try {
                const response = await fetch(`/api/foods`, {
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
                        displayFoods(data.result);
                        showFoods();
                    } else {
                        showNoFoods();
                    }
                } else {
                    if (response.status === 403) {
                        alert(data.message);
                        window.location.href = '/dashboard';
                    }
                }
            } catch (error) {
                console.error('خطا در گرفتن اطلاعات', error);
                showError();
            }
        }

        function displayFoods(foods) {
            const container = document.getElementById('foodsContainer');
            container.innerHTML = foods
                .map(
                    (food) => `
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold">${food.id}</h3>
                    </div>
                    <div class="space-y-2">
<div class="flex justify-between" dir="rtl">
                        <p>
نام غذا:
                        </p>
                            <p class="text-gray-600">
                                ${food.name}
                            </p>
</div>
<div class="flex justify-between" dir="rtl">
                        <p>
مواد داخل غذا:
                        </p>
                            <p class="text-gray-600">
                                ${food.ingredients}
                            </p>
</div>
<div class="flex justify-between" dir="rtl">
                        <p>
قیمت غذا:
                        </p>
                            <p class="text-gray-600">
                                ${food.price}
                            </p>
</div>
<div class="flex justify-between" dir="rtl">
                            <p class="text-blue-400 bg-gray-300 py-2 px-4 rounded-xl">
                                ${getFoodType(food.type)}
                            </p>
                            <img class="w-10 h-10 rounded-2xl" alt="food-img" src="${food.img_url}"/>
</div>
                        </div>
${isAdmin ? `
<div class="flex items-center justify-between mt-4">
                        <div id="update" class="flex items-center justify-center bg-gray-200 rounded-xl p-2 mt-2">
                                <a href="/foods/${food.id}/update"
                                class="text-green-400 hover:text-green-600 text-sm font-medium">
                                    ویرایش
                                </a>

                        </div>
<div id="update" class="flex items-center justify-center bg-gray-200 rounded-xl p-2 mt-2">
                            <button onclick="deleteFood(${food.id})"
                                    class="text-red-500 hover:text-red-700 text-sm font-medium">
                                حذف
                            </button>
</div>
                        </div>` : ``}
                    </div>
                </div>
            `,).join('');
        }

        async function deleteFood(carId) {
            if (!confirm('مطمعن هستید می خواهید این غذا را حذف کنید؟')) {
                return;
            }

            try {
                const response = await fetch(`/api/foods/${carId}`, {
                    method: 'DELETE',
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
                        displayFoods(data.result);
                        showFoods();
                    } else {
                        showNoFoods();
                    }
                } else {
                    if (response.status === 403) {
                        alert(data.message);
                        window.location.href = '/dashboard';
                    }
                }
            } catch (error) {
                console.error('Error deleting car:', error);
                alert('غذا را نتوانستیم حذف کنیم دوباره امتخان کنید.');
            }
        }

        fetchFoods();

        function getFoodType(type) {
            switch (type) {
                case "burger":
                    return 'برگر';
                case "sandwich":
                    return 'ساندویچ';
            }
        }
    </script>
@endsection
