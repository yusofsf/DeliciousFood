@extends('layouts.app')

@section('title', 'غذای جدید')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="mb-5 text-center text-3xl font-bold">ثبت غذا جدید</h1>
        <form id="foodForm" class="rounded-lg bg-white p-6 shadow-md" dir="rtl">
            <div class="flex items-center mb-6">
                <label for="name" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">نام غذا</label>
                <input
                        type="text"
                        name="name"
                        id="name"
                        class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        autocomplete="off"
                />
            </div>
            <div class="flex items-center mb-6">
                <label for="ingredients" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">
                    مواد داخل غذا
                </label>
                <input
                        type="text"
                        name="ingredients"
                        id="ingredients"
                        class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required/>
            </div>
            <div class="flex items-center mb-6">
                <label for="price" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">
                    قیمت غذا
                </label>
                <input
                        type="number"
                        name="price"
                        id="price"
                        min="10000"
                        class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required/>
            </div>
            <div class="flex items-center mb-6">
                <label for="image" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">
                    عکس غذا
                </label>
                <input
                        type="file"
                        name="image"
                        id="image"
                        class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required/>
            </div>
            <div class="flex items-center mb-6">
                <label for="type" class="mb-2 block text-sm font-bold text-gray-700 w-1/3">نوع غذا</label>
                <select
                        name="type"
                        id="type"
                        class="w-2/3 rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="burger">برگر</option>
                    <option value="sandwich">ساندویچ</option>
                    <option value="extra">پیش غذا و مخلفات</option>
                </select>
            </div>
            <div class="flex justify-between">
                <a href="/dashboard"
                   class="mr-2 rounded-lg bg-gray-500 px-4 py-2 text-white transition-colors duration-300 hover:bg-gray-600">
                    لغو
                </a>
                <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-white transition-colors duration-300 hover:bg-blue-700">
                    ذخیره غذا
                </button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('foodForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('image', document.getElementById('image').files[0]);
            formData.append('ingredients', document.getElementById('ingredients').value);
            formData.append('type', document.getElementById('type').value);
            formData.append('price', document.getElementById('price').value);

            try {
                await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include',
                });

                const response = await fetch('/api/foods', {
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
                    window.location.href = `/foods`;
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
                        alert(data.message || 'نتوانستیم غذا را ایجاد کنیم. دوباره تلاش کنید.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('خطایی رخ داد دوباره تلاش کنید');
            }
        });
    </script>
@endsection
