<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\decreaseQtyRequest;
use App\Http\Requests\Cart\DeleteFromCartRequest;
use App\Http\Requests\Cart\increaseQtyRequest;
use App\Http\Resources\UserCartResource;
use App\Interfaces\CartServiceInterface;
use App\Services\CartService;
use Binafy\LaravelCart\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    public function __construct(private readonly CartServiceInterface $cartService)
    {
    }

    public function addToCart(AddToCartRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->cartService->addToCart($validated['type'], $validated['id']);

        return Response::json([
            'result' => UserCartResource::collection(Cart::where('user_id', Auth::user()->id)->get()),
            'message' => 'cart item added'
        ], 201);
    }

    public function deleteFromCart(DeleteFromCartRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->cartService->deleteFromCart($validated['type'], $validated['id']);

        return Response::json([
            'result' => UserCartResource::collection(Cart::where('user_id', Auth::user()->id)->get()),
            'message' => 'cart item deleted'
        ]);
    }

    public function increaseQuantity(increaseQtyRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->cartService->increaseQuantity($validated['type'],
            $validated['id']);

        return Response::json([
            'result' => UserCartResource::collection(Cart::where('user_id', Auth::user()->id)->get()),
            'message' => 'cart item increased'
        ]);
    }

    public function decreaseQuantity(decreaseQtyRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->cartService->decreaseQuantity($validated['type'], $validated['id']);

        return Response::json([
            'result' => UserCartResource::collection(Cart::where('user_id', Auth::user()->id)->get()),
            'message' => 'cart item decreased'
        ]);
    }

    public function show(): JsonResponse
    {
        return Response::json([
            'result' => UserCartResource::collection(Cart::where('user_id', Auth::user()->id)->get()),
            'message' => 'cart items'
        ]);
    }
}
