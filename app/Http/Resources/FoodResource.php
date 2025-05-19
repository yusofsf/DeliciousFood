<?php

namespace App\Http\Resources;

use Binafy\LaravelCart\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $qty = null;
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            $qty = Cart::query()->firstOrCreate(['user_id' => $user->id])->items()
                ->where('itemable_id', $this->id)
                ->where('itemable_type', '=', 'App\Models\Food')->first()?->quantity;
        }

        return [
            'name' => $this->name,
            'quantity' => $qty ?? '0',
            'id' => $this->id,
            'img_url' => $this->img_url,
            'price' => $this->price,
            'ingredients' => $this->ingredients,
            'type' => $this->type
        ];
    }
}
