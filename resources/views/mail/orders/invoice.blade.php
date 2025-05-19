<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاکتور سفارش</title>
</head>
<body style="margin: 0; padding: 0; font-family: Tahoma, Arial, sans-serif; background-color: #f4f4f4; direction: rtl;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4;">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <table width="600" cellpadding="0" cellspacing="0"
                   style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <!-- Header -->
                <tr>
                    <td style="padding: 30px; text-align: center; background-color: #4a90e2; border-radius: 8px 8px 0 0;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px;">فاکتور سفارش</h1>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding: 30px;">
                        <p style="color: #666666; font-size: 14px; margin-bottom: 30px;">
                            از خرید شما متشکریم. جزئیات سفارش شما در زیر آمده است.
                        </p>

                        <!-- Order Info -->
                        <table width="100%" cellpadding="10" cellspacing="0"
                               style="margin-bottom: 30px; border: 1px solid #e0e0e0; border-radius: 4px;">
                            <tr>
                                <td style="background-color: #f8f9fa; border-bottom: 1px solid #e0e0e0;">
                                    <strong>شماره سفارش:</strong> {{ $order->id }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #e0e0e0;">
                                    <strong>تاریخ سفارش:</strong> {{ $order->created_at->format('Y/m/d') }}
                                </td>
                            </tr>
                        </table>

                        <!-- Order Items -->
                        <table width="100%" cellpadding="10" cellspacing="0"
                               style="margin-bottom: 30px; border: 1px solid #e0e0e0; border-radius: 4px;">
                            <tr style="background-color: #f8f9fa;">
                                <th style="text-align: right; border-bottom: 2px solid #e0e0e0;">محصول</th>
                                <th style="text-align: center; border-bottom: 2px solid #e0e0e0;">تعداد</th>
                                <th style="text-align: left; border-bottom: 2px solid #e0e0e0;">قیمت واحد</th>
                                <th style="text-align: left; border-bottom: 2px solid #e0e0e0;">جمع</th>
                            </tr>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td style="border-bottom: 1px solid #e0e0e0;">{{ $item->name }}</td>
                                    <td style="text-align: center; border-bottom: 1px solid #e0e0e0;">{{ $item->quantity }}</td>
                                    <td style="border-bottom: 1px solid #e0e0e0;">{{ number_format($item->price) }}
                                        تومان
                                    </td>
                                    <td style="border-bottom: 1px solid #e0e0e0;">{{ number_format($item->quantity * $item->price) }}
                                        تومان
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <!-- Order Summary -->
                        <table width="100%" cellpadding="10" cellspacing="0"
                               style="margin-bottom: 30px; border: 1px solid #e0e0e0; border-radius: 4px;">
                            <tr>
                                <td style="border-bottom: 1px solid #e0e0e0;">
                                    <strong>جمع کل:</strong> {{ number_format($order->total_price) }} تومان
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="padding: 20px; text-align: center; background-color: #f8f9fa; border-radius: 0 0 8px 8px;">
                        <p style="color: #666666; margin: 0; font-size: 12px;">
                            با تشکر،<br>
                            {{ config('app.name') }}
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
