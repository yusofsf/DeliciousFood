@extends('layouts.app')

@section('title', 'تایید ایمیل')

@section('content')
    <div class="container mx-auto px-4 py-8" dir="rtl">
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        تأیید ایمیل
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        لطفاً ایمیل خود را بررسی کنید و روی لینک تأیید کلیک کنید.
                    </p>
                </div>

                <div class="mt-8 space-y-6">
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <div class="mr-3">
                                <p class="text-sm text-blue-700">
                                    اگر ایمیل تأیید را دریافت نکرده‌اید، می‌توانید با کلیک روی دکمه زیر، درخواست ارسال
                                    مجدد کنید.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="email-verify" method="POST" class="mt-6">
                        <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            ارسال مجدد ایمیل تأیید
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('email-verify').addEventListener('submit', async function (e) {
                e.preventDefault();

                await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include',
                });

                try {
                    const response = await fetch('/api/email/verification-notification', {
                        method: 'POST',
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
                        window.location.href = '/checkout';
                    } else {
                        if (data.errors) {
                            let errorMessage = '';
                            Object.keys(data.errors).forEach((key) => {
                                errorMessage += data.errors[key][0] + '\n';
                            });
                            alert(errorMessage);
                        } else {
                            alert(data.message);
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('خطایی رخ داد. دوباره تلاش کنید.');
                }
            });
        </script>
@endsection