@extends('layouts.app')

@section('title', 'تمام پیش غذا ها')

@section('content')
    <h1 class="mb-8 text-center text-3xl font-bold">تمام پیش غذا ها</h1>

    <!-- Loading State -->
    <div id="loadingState" class="py-12 text-center">
        <div
                class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-blue-600 border-t-transparent"
        ></div>
        <p class="mt-2 text-gray-600">بارگزاری پیش غذا ها...</p>
    </div>

    <!-- Orders Grid -->
    <div id="extrasContainer" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Orders will be loaded here -->
    </div>

    <!-- No Orders Message -->
    <div id="noExtrasMessage">
        <div class="rounded-lg bg-white p-8 text-center shadow-md">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="hidden" stroke="currentColor" viewBox="0 0 24 24">
                <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                ></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">پیش غذا یافت نشد</h3>
            <p class="mt-1 text-sm text-gray-500">پیش غذا ثبت نشده است</p>
        </div>
    </div>

    <div class="rounded-lg border border-green-200 bg-blue-100 p-4 text-center mt-5">
        <p class="mt-2 text-sm text-blue-400">ایحاد پیش غذا</p>
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
                    onclick="fetchExtras()"
                    class="mt-4 inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
            >
                باگزاری مجدد
            </button>
        </div>
    </div>

    <script>
        const isAdmin = localStorage.getItem('user_role') === "Administrator";
        const isUser = localStorage.getItem('user_role') === "Costumer";

        function showLoading() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('extrasContainer').classList.add('hidden');
            document.getElementById('noExtrasMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showError() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('extrasContainer').classList.add('hidden');
            document.getElementById('noExtrasMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.remove('hidden');
        }

        function showNoExtras() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('extrasContainer').classList.add('hidden');
            document.getElementById('noExtrasMessage').classList.remove('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showExtras() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('extrasContainer').classList.remove('hidden');
            document.getElementById('noExtrasMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        async function fetchExtras() {
            showLoading();

            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });

            try {
                const response = await fetch(`/api/foods/extras/show`, {
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
                        displayExtras(data.result);
                        showExtras();
                    } else {
                        showNoExtras();
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

        function displayExtras(extras) {
            const container = document.getElementById('extrasContainer');
            container.innerHTML = extras
                .map(
                    (extra) => `
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold">${extra.id}</h3>
                    </div>
                    <div class="space-y-2">
<div class="flex justify-between" dir="rtl">
<p>
نام پیش غذا
</p>
                            <p class="text-gray-600">
                                ${extra.name}
                            </p>
</div>
<div class="flex justify-between" dir="rtl">
<p class="font-medium">قیمت:</p>
                            <p class="text-gray-600">
                                ${extra.price}
                            </p>
</div>
                            <img class="w-10 h-10 rounded-2xl" alt="extra-img" src="/${extra.img_url}"/>
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            ${isAdmin ? `
                                <a href="/foods/${extra.id}/update"
                                class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    ویرایش
                                </a>
                            ` : ``}
                        </div>
                    </div>
                </div>
            `,).join('');
        }

        fetchExtras();
    </script>
@endsection
