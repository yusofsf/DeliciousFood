<?php

namespace App\Http\Requests\Food;

use App\Enums\FoodType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required|max:255',
            'ingredients' => 'string|required|max:255',
            'image' => 'image|mimes:jpg,png,webp|max:4096|required',
            'price' => 'string|required|max:255',
            'type' => [Rule::enum(FoodType::class), 'required'],
        ];
    }
}
