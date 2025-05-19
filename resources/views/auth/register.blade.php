<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ثبت نام</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-500">
<div class="mx-auto w-full max-w-md p-6">
    <div class="rounded-lg bg-gray-200 p-8 shadow-lg">
        <h2 class="mb-6 text-center text-2xl font-bold">ایجاد حساب کاربری</h2>
        <form id="registerForm" class="space-y-4">
            <div>
                <label for="user_name" class="block text-sm font-medium text-gray-700">نام کاربری</label>
                <input
                        type="text"
                        id="user_name"
                        name="user_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                        dir="ltr"
                        autocomplete="off"
                />
            </div>
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">شماره موبایل</label>
                <input
                        type="text"
                        id="phone_number"
                        name="phone_number"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                        dir="ltr"
                        autocomplete="off"
                />
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">آدرس ایمیل</label>
                <input
                        type="email"
                        id="email"
                        name="email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                        dir="ltr"
                        autocomplete="off"
                />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">پسورد</label>
                <input
                        type="password"
                        id="password"
                        name="password"
                        dir="ltr"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    تکرار پسورد
                </label>
                <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                        dir="ltr"
                />
            </div>
            <div>
                <button
                        type="submit"
                        class="flex w-full justify-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                >
                    ثبت نام
                </button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                حساب کاربری دارید؟
                <a href="/login" class="font-medium text-gray-800 hover:text-gray-400">وروذ</a>
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = {
            user_name: document.getElementById('user_name').value,
            phone_number: document.getElementById('phone_number').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value,
        };

        try {
            const response = await fetch('/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                localStorage.setItem('token', data.token);

                localStorage.setItem('user_id', data.result.id);

                localStorage.setItem('user_role', data.result.role);

                alert(data.message);
                window.location.href = '/';
            } else {
                if (data.errors) {
                    let errorMessage = '';
                    Object.keys(data.errors).forEach((key) => {
                        errorMessage += data.errors[key][0] + '\n';
                    });
                    alert(errorMessage);
                } else {
                    alert(data.message || 'نتوانستیم شمارا ثبت نام کنیم. دوباره تلاش کنید.');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('خطایی رخ داد. دوباره تلاش کنید.');
        }
    });
</script>
</body>
</html>
