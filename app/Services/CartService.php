<?php

namespace App\Services;

use App\Interfaces\CartServiceInterface;
use App\Models\Drink;
use App\Models\Food;
use Binafy\LaravelCart\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService implements CartServiceInterface
{
    private Cart $cart;

    public function __construct()
    {
        $this->cart = Cart::query()->firstOrCreate(['user_id' => Auth::user()->id]);
    }

    public function deleteFromCart(string $type, int $id): void
    {
        $item = strtolower($type) === 'drink' ? Drink::find($id) : Food::find($id);

        $this->cart->removeItem($item);
    }

    public function increaseQuantity(string $type, int $id): void
    {
        $item = strtolower($type) === 'drink' ? Drink::find($id) : Food::find($id);

        if (!$item) {
            return;
        }

        $cartItem = $this->cart->items()
            ->where('itemable_id', $id)
            ->where('itemable_type', get_class($item))
            ->first();

        if (!$cartItem) {
            $this->addToCart($type, $id);
            return;
        }

        $this->cart->increaseQuantity($item);
    }

    public function addToCart(string $type, int $id): void
    {
        $item = strtolower($type) === 'drink' ? Drink::find($id) : Food::find($id);

        $this->cart->storeItem($item);
    }

    public function decreaseQuantity(string $type, string $id): void
    {
        $item = strtolower($type) === 'drink' ? Drink::find($id) : Food::find($id);

        if (!$item) {
            return;
        }

        $this->cart->decreaseQuantity($item);
    }

    public function emptyCart(): void
    {
        $this->cart->emptyCart();
    }
}