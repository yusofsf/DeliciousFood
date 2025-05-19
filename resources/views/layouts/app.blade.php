<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Delicious Food')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-full h-full bg-gray-500 flex justify-between flex-col items-center">
<!-- Navigation -->
<nav class="bg-black shadow-lg w-full">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex flex-shrink-0 items-center">
                    <a href="/" class="text-xl font-bold text-gray-100">Delicious Food</a>
                </div>
                <div class="sm:ml-6 sm:flex sm:space-x-8" id="rightNav">
                    <a href="/dashboard"
                       class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-300 hover:text-gray-500">
                        داشبورد
                    </a>
                    <button onclick="orders()"
                            id="ordersButton"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-300 hover:text-gray-500">
                        سفارش ها
                    </button>
                    <button onclick="foods()"
                            id="foodsButton"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-300 hover:text-gray-500">
                        غذاها
                    </button>
                    <a href="/users"
                       id="users"
                       class="hidden border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-300 hover:text-gray-500">
                        کاربران
                    </a>
                    <button onclick="drinks()"
                            id="drinksButton"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-300 hover:text-gray-500">
                        نوشیدنی ها
                    </button>
                    <button onclick="extras()"
                            id="extrasButton"
                            class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:border-gray-300 hover:text-gray-500">
                        پیش غذا ها
                    </button>
                </div>
            </div>
            <button id="logout"
                    onclick="logout()"
                    class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-300 hover:text-gray-500 hover:border-gray-300">
                خروج
            </button>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container mx-auto px-4 py-8 w-10/12" dir="rtl">
    @yield('content')
</div>

<script>
    async function logout() {
        try {
            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });

            const response = await fetch(`/api/auth/logout`, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                },
                credentials: 'include',
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                localStorage.removeItem('token');
                localStorage.removeItem('user_id');
                localStorage.removeItem('user_role');
                window.location.href = '/';
            } else {
                if (response.status === 403) {
                    alert(data.message);
                }
            }
        } catch (error) {
            console.error('Error Logout:', error);
        }
    }

    function drinks() {
        if (localStorage.getItem('user_role') === 'Administrator') {
            window.location.href = `/drinks`;
        } else {
            window.location.href = `/users/user/orders/drinks`;
        }
    }

    function foods() {
        if (localStorage.getItem('user_role') === 'Administrator') {
            window.location.href = `/foods`;
        } else {
            window.location.href = `/users/user/orders/foods`;
        }
    }

    function orders() {
        if (localStorage.getItem('user_role') === 'Administrator') {
            window.location.href = `/orders`;
        } else {
            window.location.href = `/users/user/orders`;
        }
    }

    function extras() {
        if (localStorage.getItem('user_role') === 'Administrator') {
            window.location.href = `/foods/extras`;
        } else {
            window.location.href = `/users/user/orders/extras`;
        }
    }

    function showMenu(role) {
        const extrasButton = document.getElementById('extrasButton');
        const users = document.getElementById('users');

        if (!role) return;
        switch (role) {
            case 'Administrator':
                if (users) users.classList.remove('hidden');
                if (extrasButton) extrasButton.classList.add('hidden');
                if (users) users.classList.add('inline-flex');
                if (users) users.classList.add('items-center');
                return;
        }
    }

    showMenu(localStorage.getItem('user_role'))
</script>
</body>
</html>
