<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CartServiceInterface;
use App\Mail\OrderInvoice;
use App\Models\Drink;
use App\Models\Food;
use App\Models\Order;
use Binafy\LaravelCart\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function __construct(private readonly CartServiceInterface $cartService)
    {
    }

    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', Order::class);

        return Response::json([
            'result' => Order::with('user')->get(),
            'message' => 'All orders'
        ]);

    }

    public function confirm(): JsonResponse
    {
        Gate::authorize('confirm', Order::class);

        if (!Auth::user()->hasVerifiedEmail()) {
            return Response::json([
                'message' => 'first verify your email'
            ]);
        }

        $totalPrice = 0;
        $orderItems = [];

        foreach (Cart::query()->firstOrCreate(['user_id' => Auth::user()->id])->items()->get() as $cartItem) {
            $item = $cartItem->itemable_type === 'App\Models\Drink' ? Drink::find($cartItem->itemable_id) : Food::find($cartItem->itemable_id);

            $orderItem = [];

            $orderItem['name'] = $item->name;
            $orderItem['price'] = $item->price;
            $orderItem['quantity'] = $cartItem->quantity;
            $orderItem['img_url'] = $item->img_url;
            $orderItem['type'] = $cartItem->itemable_type === 'App\Models\Drink' ? 'drink' : $item->type;
            $totalPrice += $orderItem['price'] * $orderItem['quantity'];

            $orderItems[] = $orderItem;
        }

        $newOrder = Auth::user()->orders()->create([
            'total_price' => $totalPrice
        ]);

        $newOrder->orderItems()->createMany($orderItems);

        Mail::to(Auth::user())->send(new OrderInvoice($newOrder));

        $this->cartService->emptyCart();

        return Response::json([
            'result' => $newOrder,
            'message' => 'order stored'
        ], 201);
    }

    public function cancel(Order $order): JsonResponse
    {
        Gate::authorize('cancel', Order::class);

        $order->update([
            'cancelled' => true
        ]);

        return Response::json([
            'result' => $order,
            'message' => 'order cancelled'
        ]);
    }

    public function show(Order $order): JsonResponse
    {
        Gate::authorize('view', Order::class);

        return Response::json([
            'result' => $order->orderItems()->get(),
            'message' => 'All order items'
        ]);
    }
}
