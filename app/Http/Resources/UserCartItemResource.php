<?php

namespace App\Http\Resources;

use App\Models\Drink;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCartItemResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->itemable_id,
            'name' => $this->itemable_type === "App\Models\Food" ? Food::findOrFail($this->itemable_id)->name :
                Drink::findOrFail($this->itemable_id)->name,
            'quantity' => $this->quantity,
            'img_url' => $this->itemable_type === "App\Models\Food" ? Food::findOrFail($this->itemable_id)->img_url :
                Drink::findOrFail($this->itemable_id)->img_url,
            'price' => $this->itemable_type === "App\Models\Food" ? Food::findOrFail($this->itemable_id)->price :
                Drink::findOrFail($this->itemable_id)->price,
            'type' => $this->itemable_type === "App\Models\Food" ? "Food" : "Drink"
        ];
    }
}
