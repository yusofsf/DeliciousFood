<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Delicious Food</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="w-full h-full bg-gray-500 flex justify-between flex-col items-center">
<div class="w-10/12 h-full">
    <div class="p-2 m-2 flex flex-row items-center justify-evenly border-b-2 border-white">
        <div class="px-4">
            <h1 class="w-fit text-gray-700 italic font-sans text-3xl"><span class="text-white">Delicious</span> Food
            </h1>
        </div>
        <div class="flex items-center justify-center">
            <div id="loginDiv"
                 class="px-12 text-xl border-r-2 border-r-white hover:text-white ease-in-out duration-500">
                <button class="cursor-pointer" onclick="login()">ورود</button>
            </div>
            <div id="registerDiv"
                 class="px-12 text-xl border-r-2 border-r-white hover:text-white ease-in-out duration-500">
                <button class="cursor-pointer" onclick="register()">ثبت نام</button>
            </div>
            <div id="dashboard" class="px-12 text-xl hover:text-white ease-in-out duration-500 hidden">
                <button class="cursor-pointer" onclick="dashboard()">داشبورد</button>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-center gap-12 m-2 bg-gray-800">
        <h2 class="cursor-pointer text-white p-4 hover:bg-gray-500 ease-in-out duration-500" id="drinks">نوشیدنی ها</h2>
        <h2 class="cursor-pointer text-white p-4 hover:bg-gray-500 ease-in-out duration-500" id="extras">پیش غذا و
            مخلفات</h2>
        <h2 class="cursor-pointer text-white p-4 hover:bg-gray-500 ease-in-out duration-500" id="sandwiches">ساندویچ
            ها</h2>
        <h2 class="cursor-pointer text-white p-4 hover:bg-gray-500 ease-in-out duration-500" id="burgers">برگر ها</h2>
    </div>
    <section class="flex flex-col items-center justify-center">
        <div id="burger" class="grid grid-cols-2 rounded-xl border-2 border-white m-2">
            <div id="burgerLoading" class="col-span-2 flex justify-center items-center p-8">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white"></div>
            </div>
            <div id="noBurgersMessage" class="col-span-2 flex justify-center items-center p-8 hidden">
                <div class="rounded-lg bg-white p-8 text-center shadow-md">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="hidden" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        ></path>
                    </svg>
                    <p class="mt-1 text-sm text-gray-500">برگری ثبت نشده است.</p>
                </div>
            </div>
        </div>
        <div id="sandwich" class="grid grid-cols-2 rounded-xl border-2 border-white m-2 hidden">
            <div id="sandwichLoading" class="col-span-2 flex justify-center items-center p-8">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white"></div>
            </div>
            <div id="noSandwichesMessage" class="col-span-2 flex justify-center items-center p-8 hidden">
                <div class="rounded-lg bg-white p-8 text-center shadow-md">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="hidden" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        ></path>
                    </svg>
                    <p class="mt-1 text-sm text-gray-500">ساندویچی ثبت نشده است.</p>
                </div>
            </div>
        </div>
        <div id="drink" class="grid grid-cols-2 rounded-xl border-2 border-white m-2 hidden">
            <div id="drinkLoading" class="col-span-2 flex justify-center items-center p-8">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white"></div>
            </div>
            <div id="noDrinksMessage" class="col-span-2 flex justify-center items-center p-8 hidden">
                <div class="rounded-lg bg-white p-8 text-center shadow-md">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="hidden" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        ></path>
                    </svg>
                    <p class="mt-1 text-sm text-gray-500">نوشیدنی ثبت نشده است.</p>
                </div>
            </div>
        </div>
        <div id="extra" class="grid grid-cols-2 rounded-xl border-2 border-white m-2 hidden">
            <div id="extraLoading" class="col-span-2 flex justify-center items-center p-8">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white"></div>
            </div>
            <div id="noExtrasMessage" class="col-span-2 flex justify-center items-center p-8 hidden">
                <div class="rounded-lg bg-white p-8 text-center shadow-md">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="hidden" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        ></path>
                    </svg>
                    <p class="mt-1 text-sm text-gray-500">پیش غذایی ثبت نشده است.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Shopping Cart Sidebar -->
<div id="cartSidebar"
     class="fixed top-0 right-0 h-full w-80 bg-gray-800 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-4 border-b border-gray-700">
        <div class="flex justify-between items-center">
            <h2 class="text-white text-xl font-bold">سبد خرید</h2>
            <button onclick="toggleCart()" class="text-white hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div id="cartItems" class="overflow-y-auto h-[calc(100vh-200px)] p-4">
        <!-- Cart items will be rendered here -->
    </div>

    <div class="absolute bottom-0 w-full p-4 bg-gray-800 border-t border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <span class="text-white text-lg">مجموع:</span>
            <span id="cartTotal" class="text-white text-lg font-bold">0 تومان</span>
        </div>
        <button onclick="confirmOrder()"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-xl transition duration-300">
            تایید سفارش
        </button>
    </div>
</div>

<!-- Cart Toggle Button -->
<button onclick="toggleCart()" id="toggleCart"
        class="fixed top-4 right-10 bg-gray-800 text-white p-3 rounded-full shadow-lg hover:bg-gray-700 transition duration-300">
    <div class="relative">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <span id="cartCount"
              class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
    </div>
</button>

<p class="fixed bottom-2">Developed By <a href="https://www.github.com/yusofsf" target="_blank" class="text-gray-200">Yusofsf</a>
</p>
</body>
<script>
    const isUser = localStorage.getItem('user_role') === 'Costumer';

    let burgers = document.getElementById("burgers")
    let sandwiches = document.getElementById("sandwiches")
    let drinks = document.getElementById("drinks")
    let extras = document.getElementById("extras")

    let burger = document.getElementById("burger")
    let sandwich = document.getElementById("sandwich")
    let extra = document.getElementById("extra")
    let drink = document.getElementById("drink")

    function sandwichShow() {
        burger.classList.add('hidden')
        extra.classList.add('hidden')
        drink.classList.add('hidden')
        sandwich.classList.remove('hidden')

        burgers.classList.remove('border-white')
        sandwiches.classList.add('border-white')
        drinks.classList.remove('border-white')
        extras.classList.remove('border-white')

        fetchSandwiches()
    }

    function burgerShow() {
        sandwich.classList.add('hidden')
        extra.classList.add('hidden')
        drink.classList.add('hidden')
        burger.classList.remove('hidden')

        burgers.classList.add('border-white')
        sandwiches.classList.remove('border-white')
        drinks.classList.remove('border-white')
        extras.classList.remove('border-white')

        fetchBurgers()
    }

    function extraShow() {
        burger.classList.add('hidden')
        sandwich.classList.add('hidden')
        drink.classList.add('hidden')
        extra.classList.remove('hidden')

        burgers.classList.remove('border-white')
        sandwiches.classList.remove('border-white')
        drinks.classList.remove('border-white')
        extras.classList.add('border-white')

        fetchExtras()
    }

    function drinkShow() {
        burger.classList.add('hidden')
        extra.classList.add('hidden')
        sandwich.classList.add('hidden')
        drink.classList.remove('hidden')

        burgers.classList.remove('border-white')
        sandwiches.classList.remove('border-white')
        drinks.classList.add('border-white')
        extras.classList.remove('border-white')

        fetchDrinks()
    }

    sandwiches.addEventListener("click", sandwichShow)
    burgers.addEventListener("click", burgerShow)
    extras.addEventListener("click", extraShow)
    drinks.addEventListener("click", drinkShow)

    async function fetchBurgers() {
        const noBurgersMessage = document.getElementById('noBurgersMessage');
        const burgerLoading = document.getElementById('burgerLoading')

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });

        try {
            const response = await fetch(`/api/foods/burgers/show`, {
                headers: localStorage.getItem('token') ? {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                } : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'include',
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result.length > 0) {
                    renderBurgers(data.result);
                } else {
                    noBurgersMessage.classList.remove('hidden');
                    burgerLoading.classList.add('hidden')
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/dashboard';
                }
            }
        } catch (error) {
            console.error('Error fetching foods:', error);
            showError();
        }
    }

    async function fetchSandwiches() {
        const noSandwichesMessage = document.getElementById('noSandwichesMessage');
        const sandwichLoading = document.getElementById('sandwichLoading')

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });
        try {
            const response = await fetch(`/api/foods/sandwiches/show`, {
                headers: localStorage.getItem('token') ? {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                } : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'include',
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result.length > 0) {
                    renderSandwiches(data.result);
                } else {
                    noSandwichesMessage.classList.remove('hidden')
                    sandwichLoading.classList.add('hidden')
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/dashboard';
                }
            }
        } catch (error) {
            console.error('Error fetching foods:', error);
            showError();
        }
    }

    async function fetchExtras() {
        const noExtrasMessage = document.getElementById('noExtrasMessage')
        const extraLoading = document.getElementById('extraLoading')

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });
        try {
            const response = await fetch(`/api/foods/extras/show`, {
                headers: localStorage.getItem('token') ? {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                } : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'include',
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result.length > 0) {
                    renderExtras(data.result);
                } else {
                    noExtrasMessage.classList.remove('hidden')
                    extraLoading.classList.add('hidden')
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/dashboard';
                }
            }
        } catch (error) {
            console.error('Error fetching foods:', error);
            showError();
        }
    }

    async function fetchDrinks() {
        const noDrinksMessage = document.getElementById('noDrinksMessage')
        const drinkLoading = document.getElementById('drinkLoading');

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });
        try {
            const response = await fetch(`/api/drinks`, {
                headers: localStorage.getItem('token') ? {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                } : {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                credentials: 'include',
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result.length > 0) {
                    renderDrinks(data.result);
                } else {
                    noDrinksMessage.classList.remove('hidden')
                    drinkLoading.classList.add('hidden')
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/dashboard';
                }
            }
        } catch (error) {
            console.error('Error fetching foods:', error);
            showError();
        }
    }

    function renderBurgers(burgers) {
        document.getElementById('burger').innerHTML = burgers.map((burger) => {
            return `<div class="flex flex-col items-center rounded-xl m-2 p-2 bg-gray-700 min-w-100">
                <div class="flex items-center w-full">
                    <div class="m-1 flex-1">
                        <h3 class="text-center rounded-3xl text-white text-md mb-2">${burger.name}</h3>
                        <p class="text-gray-400 text-sm text-center">${burger.ingredients}</p>
                    </div>
                    <div>
                        <img class="w-10 h-10 rounded-3xl" src=${burger.img_url} alt="burger">
                    </div>
                </div>
                <div class='flex items-center justify-between w-full mt-2' dir="rtl">
                    <p class="text-white">قیمت:</p>
                    <p class="text-gray-400 text-sm text-center">${burger.price}</p>
                </div>
                ${isUser || checkIsLoggedIn() ? `
                    <div class="flex items-center justify-between w-full mt-2">
                    <div class="flex items-center gap-2">
                        <button onclick="decreaseQty(${burger.id}, 'Food')"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">-
                        </button>
                        <span id="qty-${burger.id}"
                              class="text-white mx-2">${burger.quantity ? burger.quantity : '0'}</span>
                        <button onclick="increaseQty(${burger.id}, 'Food')"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">+
                        </button>
                    </div>
                    <button onclick="removeFromCart(${burger.id}, 'Food')"
                            class="text-red-500 hover:text-red-700 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>` : ``
            }
            </div>`;
        }).join(``);
    }

    function renderExtras(extras) {
        document.getElementById('extra').innerHTML =
            extras.map((extra) => {
                return `<div class="flex flex-col items-center rounded-xl m-2 p-2 bg-gray-700 min-w-100">
                    <div class="flex items-center w-full">
                        <div class="m-1 flex-1">
                            <h3 class="text-center rounded-3xl text-white text-md mb-2">${extra.name}</h3>
                            <p class="text-gray-400 text-sm text-center">${extra.ingredients}</p>
                        </div>
                        <div>
                            <img class="w-10 h-10 rounded-3xl" src=${extra.img_url} alt="extra">
                        </div>
                    </div>
                    <div class='flex items-center justify-between w-full mt-2' dir="rtl">
                        <p class="text-white">قیمت:</p>
                        <p class="text-gray-400 text-sm text-center">${extra.price}</p>
                    </div>
                    ${isUser || checkIsLoggedIn() ? `
                    <div class="flex items-center justify-between w-full mt-2">
                        <div class="flex items-center gap-2">
                            <button onclick="decreaseQty(${extra.id}, 'Food')" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">-</button>
                            <span id="qty-${extra.id}" class="text-white mx-2">${extra.quantity ? extra.quantity : '0'}</span>
                            <button onclick="increaseQty(${extra.id}, 'Food')" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">+</button>
                        </div>
                        <button onclick="removeFromCart(${extra.id}, 'Food')" class="text-red-500 hover:text-red-700 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>` : ``}
                </div>`;
            }).join(``)
    }

    function renderDrinks(drinks) {
        document.getElementById('drink').innerHTML =
            drinks.map((drink) => {
                return `<div class="flex flex-col items-center rounded-xl m-2 p-2 bg-gray-700 min-w-100">
                    <div class="flex items-center w-full">
                        <div class="m-1 flex-1">
                            <h3 class="text-center rounded-3xl text-white text-md mb-2">${drink.name}</h3>
                        </div>
                        <div>
                            <img class="w-10 h-10 rounded-3xl" src=${drink.img_url} alt="drink">
                        </div>
                    </div>
                    <div class='flex items-center justify-between w-full mt-2' dir="rtl">
                        <p class="text-white">قیمت:</p>
                        <p class="text-gray-400 text-sm text-center">${drink.price}</p>
                    </div>
                    ${isUser || checkIsLoggedIn() ? `
                   <div class="flex items-center justify-between w-full mt-2">
                        <div class="flex items-center gap-2">
                            <button onclick="decreaseQty(${drink.id}, 'Drink')" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">-</button>
                            <span id="qty-${drink.id}-drink" class="text-white mx-2">${drink.quantity ? drink.quantity : '0'}</span>
                            <button onclick="increaseQty(${drink.id}, 'Drink')" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">+</button>
                        </div>
                        <button onclick="removeFromCart(${drink.id}, 'Drink')" class="text-red-500 hover:text-red-700 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>` : ``}
                </div>`;
            }).join('')
    }

    function renderSandwiches(sandwiches) {
        document.getElementById('sandwich').innerHTML =
            sandwiches.map((sandwich) => {
                return `<div class="flex flex-col items-center rounded-xl m-2 p-2 bg-gray-700 min-w-100">
                    <div class="flex items-center w-full">
                        <div class="m-1 flex-1">
                            <h3 class="text-center rounded-3xl text-white text-md mb-2">${sandwich.name}</h3>
                            <p class="text-gray-400 text-sm text-center">${sandwich.ingredients}</p>
                        </div>
                        <div>
                            <img class="w-10 h-10 rounded-3xl" src=${sandwich.img_url} alt="sandwich">
                        </div>
                    </div>
                    <div class='flex items-center justify-between w-full mt-2' dir="rtl">
                        <p class="text-white">قیمت:</p>
                        <p class="text-gray-400 text-sm text-center">${sandwich.price}</p>
                    </div>
                    ${isUser || checkIsLoggedIn() ? `
                    <div class="flex items-center justify-between w-full mt-2">
                        <div class="flex items-center gap-2">
                            <button onclick="decreaseQty(${sandwich.id}, 'Food')" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">-</button>
                            <span id="qty-${sandwich.id}" class="text-white mx-2">${sandwich.quantity ? sandwich.quantity : '0'}</span>
                            <button onclick="increaseQty(${sandwich.id}, 'Food')" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg transition duration-300">+</button>
                        </div>
                        <button onclick="removeFromCart(${sandwich.id}, 'Food')" class="text-red-500 hover:text-red-700 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>` : ``
                }
                </div>`;
            }).join('')
    }

    function login() {
        window.location.href = '/login';
    }

    function register() {
        window.location.href = '/register';
    }

    function cart() {
        window.location.href = `/users/${localStorage.getItem('user_id')}/cart`
    }

    async function addToCart(productId, type) {
        if (checkIsLoggedIn()) {
            alert('لطفا اول وارد شوید');
            return;
        }

        const formData = {
            'id': productId,
            'type': type
        };

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });

        try {
            const response = await fetch(`/api/carts/add-to-cart`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                },
                credentials: 'include',
                body: JSON.stringify(formData)
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result[0]?.items) {
                    renderCart(data.result[0].items);
                    const item = data.result[0].items.find(item => item.id === productId);
                    if (item) {
                        updateQuantityDisplay(productId, item.quantity, type);
                    }
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/login';
                } else {
                    alert('خطا در افزودن به سبد خرید');
                }
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            alert('خطا در افزودن به سبد خرید');
        }
    }

    async function removeFromCart(productId, type) {
        if (checkIsLoggedIn()) {
            alert('لطفا اول وارد شوید');
            return;
        }

        let qtyVal;

        if (type.toLowerCase() === 'food') {
            qtyVal = Number(document.getElementById(`qty-${productId}`).textContent);
        } else {
            qtyVal = Number(document.getElementById(`qty-${productId}-drink`).textContent);
        }

        if (qtyVal === 0) {
            alert('در سبد خرید موجود نمی باشد');
            return;
        }

        const formData = {
            'id': productId,
            'type': type
        };

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });

        try {
            const response = await fetch(`/api/carts/delete-from-cart`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                },
                credentials: 'include',
                body: JSON.stringify(formData)
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result[0]?.items) {
                    renderCart(data.result[0].items);
                    updateQuantityDisplay(productId, 0, type);
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/login';
                } else {
                    alert('خطا در حذف از سبد خرید');
                }
            }
        } catch (error) {
            console.error('Error removing from cart:', error);
            alert('خطا در حذف از سبد خرید');
        }
    }

    async function increaseQty(productId, type) {
        if (checkIsLoggedIn()) {
            alert('لطفا اول وارد شوید');
            return;
        }

        let qtyVal;

        if (type.toLowerCase() === 'food') {
            qtyVal = Number(document.getElementById(`qty-${productId}`).textContent);
        } else {
            qtyVal = Number(document.getElementById(`qty-${productId}-drink`).textContent);
        }

        if (qtyVal === 0) {
            await addToCart(productId, type);
            return;
        }

        const formData = {
            'id': productId,
            'type': type,
        };

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });

        try {
            const response = await fetch(`/api/carts/increaseQuantity`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                },
                credentials: 'include',
                body: JSON.stringify(formData)
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result[0]?.items) {
                    renderCart(data.result[0].items);
                    const item = data.result[0].items.find(item => item.id === productId);
                    if (item) {
                        updateQuantityDisplay(productId, item.quantity, type);
                    }
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/login';
                } else {
                    alert('خطا در افزایش تعداد');
                }
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
            alert('خطا در افزایش تعداد');
        }
    }

    async function decreaseQty(productId, type) {
        if (checkIsLoggedIn()) {
            alert('لطفا اول وارد شوید');
            return;
        }
        let qtyVal;

        if (type.toLowerCase() === 'food') {
            qtyVal = Number(document.getElementById(`qty-${productId}`).textContent);
        } else {
            qtyVal = Number(document.getElementById(`qty-${productId}-drink`).textContent);
        }

        console.log(qtyVal)

        if (qtyVal < 2) {
            await removeFromCart(productId, type);
            return;
        }

        const formData = {
            'id': productId,
            'type': type,
        };

        await fetch('/sanctum/csrf-cookie', {
            credentials: 'include',
        });

        try {
            const response = await fetch(`/api/carts/decreaseQuantity`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                },
                credentials: 'include',
                body: JSON.stringify(formData)
            });

            const data = JSON.parse(await response.text());

            if (response.ok) {
                if (data.result && data.result[0]?.items) {
                    renderCart(data.result[0].items);
                    const item = data.result[0].items.find(item => item.id === productId);
                    if (item) {
                        updateQuantityDisplay(productId, item.quantity, type);
                    }
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                    window.location.href = '/login';
                } else {
                    alert('خطا در کاهش تعداد');
                }
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
            alert('خطا در کاهش تعداد');
        }
    }

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
                    renderCart(data.result[0].items);
                }
            } else {
                if (response.status === 403) {
                    alert(data.message);
                }
            }
        } catch (error) {
            console.error('Error fetching carts:', error);
            showError();
        }
    }

    if (!checkIsLoggedIn()) {
        fetchCart();
    }


    function dashboard() {
        window.location.href = '/dashboard'
    }

    function toggleCart() {
        if (checkIsLoggedIn()) {
            alert('برای دیدن سبد خرید ابتدا وارد شوید')
            return;
        }
        const sidebar = document.getElementById('cartSidebar');
        const toggleCart = document.getElementById('toggleCart');
        toggleCart.classList.toggle('hidden')
        sidebar.classList.toggle('translate-x-full');
    }

    function renderCart(items) {
        const cartItems = document.getElementById('cartItems');
        const cartCount = document.getElementById('cartCount');
        const cartTotal = document.getElementById('cartTotal');

        let total = 0;
        let count = 0;

        cartItems.innerHTML = items.map(item => {
            total += item.price * item.quantity;
            count += item.quantity;
            return `
                <div class="flex items-center justify-between mb-4 p-2 bg-gray-700 rounded-lg">
                    <div class="flex-1">
                        <h3 class="text-white font-medium">${item.name}</h3>
                        <p class="text-gray-400 text-sm">${item.price} تومان</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="decreaseQty(${item.id}, '${item.type}')" class="bg-gray-600 text-white px-2 py-1 rounded">-</button>
                        <span id="cart-qty-${item.id}" class="text-white mx-2">${item.quantity}</span>
                        <button onclick="increaseQty(${item.id}, '${item.type}')" class="bg-gray-600 text-white px-2 py-1 rounded">+</button>
                        <button onclick="removeFromCart(${item.id}, '${item.type}')" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
        }).join('');

        cartCount.textContent = count;
        cartTotal.textContent = `${total.toLocaleString()} تومان`;
    }

    function checkIsLoggedIn() {
        return !localStorage.getItem("user_id");
    }

    if (checkIsLoggedIn()) {
        document.getElementById("registerDiv").classList.remove('border-r-2');
        document.getElementById("registerDiv").classList.remove('border-r-white');
    } else {
        document.getElementById("dashboard").classList.remove('hidden');
        document.getElementById("loginDiv").classList.add('hidden');
        document.getElementById("registerDiv").classList.add('hidden');
    }

    function confirmOrder() {
        window.location.href = '/checkout';
    }

    // Update the quantity display in the food cards
    function updateQuantityDisplay(id, quantity, type) {
        let qtyElement;

        if (type.toLowerCase() === 'drink') {
            qtyElement = document.getElementById(`qty-${id}-drink`);
        } else {
            qtyElement = document.getElementById(`qty-${id}`);
        }

        if (qtyElement) {
            qtyElement.textContent = quantity;
        }
    }

    burgerShow()
</script>
</html>
