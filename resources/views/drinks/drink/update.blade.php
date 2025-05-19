@extends('layouts.app')

@section('title', 'ویرایش نوشیدنی')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="mb-8 text-center text-3xl font-bold">ویرایش نوشیدنی</h1>

        <div id="loadingState" class="py-12 text-center">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-blue-600 border-t-transparent"
            ></div>
            <p class="mt-2 text-gray-600">بارگزاری نوشیدنی...</p>
        </div>

        <div id="updateForm" class="rounded-lg bg-white p-6 shadow-md">
            <form id="drinkForm" class="space-y-4" dir="rtl">
                <div class="flex items-center mb-6">
                    <label for="name" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">نام جدید نوشیدنی</label>
                    <input
                            type="text"
                            id="name"
                            name="name"
                            class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                            autocomplete="off"
                    />
                </div>
                <div class="flex items-center mb-6">
                    <label for="price" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">
                        قیمت جدید نوشیدنی
                    </label>
                    <input
                            type="number"
                            id="price"
                            name="price"
                            step="1000"
                            min="6000"
                            class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            autocomplete="off"
                    />
                </div>
                <div class="flex items-center mb-6">
                    <label for="image" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">عکس جدید نوشیدنی</label>
                    <input
                            type="file"
                            id="image"
                            name="image"
                            class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            autocomplete="off"
                    />
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a href="/dashboard" class="rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">
                        لفو
                    </a>
                    <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        ویرایش
                    </button>
                </div>
            </form>
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
                <a
                        href="/drinks"
                        class="mt-4 inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                >
                    برگشت به صففحه قبل
                </a>
            </div>
        </div>
    </div>

    <script>
        let drinkId = window.location.pathname.split('/')[2];

        function showLoading() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('updateForm').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showForm() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('updateForm').classList.remove('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function showError() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('updateForm').classList.add('hidden');
            document.getElementById('errorMessage').classList.remove('hidden');
        }

        async function fetchDrink() {
            showLoading();

            try {
                await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include',
                });

                const response = await fetch(`/api/drinks/${drinkId}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    },
                    credentials: 'include',
                });

                const data = JSON.parse(await response.text());

                if (response.ok) {
                    if (data.result) {
                        populateForm(data.result);
                        showForm();
                    }
                } else {
                    if (response.status === 403) {
                        alert(data.message);
                        window.location.href = '/drinks';
                    }
                    if (response.status === 404) {
                        alert(data.message);
                        window.location.href = '/drinks';
                    }
                }
            } catch (error) {
                console.error('Error fetching drinks:', error);
                showError();
            }
        }

        function populateForm(drink) {
            document.getElementById('name').value = drink.name;
            document.getElementById('price').value = drink.price;
        }

        document.getElementById('drinkForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData();
            const name = document.getElementById('name').value.trim();
            const price = document.getElementById('price').value;
            const image = document.getElementById('image').files[0];

            formData.append('name', name);
            formData.append('price', price);
            if (image) {
                formData.append('image', image);
            }

            try {
                await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include',
                });

                const response = await fetch(`/api/drinks/${drinkId}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    },
                    credentials: 'include',
                    body: formData,
                });

                const data = JSON.parse(await response.text());

                if (response.ok) {
                    alert(data.message);
                    window.location.href = '/drinks';
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
                        alert(data.message || 'نتوانستیم نوشیدنی را ویرایش کنیم. دوباره تلاش کنید.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('خطایی رخ داد دوباره تلاش کنید');
            }
        });

        fetchDrink();
    </script>
@endsection
