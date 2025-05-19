<?php

namespace App\Interfaces;

interface CartServiceInterface
{
    public function addToCart(string $type, int $id): void;

    public function deleteFromCart(string $type, int $id): void;

    public function increaseQuantity(string $type, int $id): void;

    public function decreaseQuantity(string $type, string $id): void;

    public function emptyCart(): void;
}
