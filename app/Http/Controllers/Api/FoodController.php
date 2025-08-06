<?php

namespace App\Http\Controllers\Api;

use App\Enums\FoodType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreRequest;
use App\Http\Requests\Food\UpdateRequest;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class FoodController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::json([
            'result' => FoodResource::collection(Food::all()
                ->whereIn('type', [FoodType::BURGER->value, FoodType::SANDWICH->value])),
            'message' => 'All foods'
        ]);
    }

    public function show(Food $food): JsonResponse
    {
        return Response::json([
            'result' => $food->toResource(FoodResource::class),
            'message' => 'food Found'
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $image = time() . '.' . $validated['image']->getClientOriginalExtension();
        $validated['image']->move(public_path('images/' . $validated['type'].'s'), $image);

        $newFood = Food::create([
            'name' => $validated['name'],
            'ingredients' => $validated['ingredients'],
            'price' => $validated['price'],
            'type' => $validated['type'],
            'img_url' => 'images/' . $validated['type'] . 's/' . $image,
        ]);

        return Response::json([
            'result' => $newFood->toResource(FoodResource::class),
            'message' => 'food stored'
        ], 201);
    }

    public function update(UpdateRequest $request, Food $food): JsonResponse
    {
        $validated = $request->validated();

        $image = null;

        if (array_key_exists('image', $validated)) {
            $image = time() . '.' . $validated['image']->getClientOriginalExtension();
            $validated['image']->move(public_path('images/' . $food->type . 's'), $image);
        }

        $food->update([
            'name' => $validated['name'],
            'ingredients' => $validated['ingredients'],
            'price' => $validated['price'] ?? $food->price,
            'img_url' => $image ? 'images/' . $food->type . 's/' . $image : $food->img_url,
        ]);

        return Response::json([
            'result' => $food->toResource(FoodResource::class),
            'message' => 'food updated'
        ]);
    }

    public function destroy(Food $food): JsonResponse
    {
        $food->delete();

        return Response::json([
            'result' => FoodResource::collection(Food::all()
                ->whereIn('type', [FoodType::BURGER->value, FoodType::SANDWICH->value])),
            'message' => 'food deleted'
        ]);
    }

    public function burgers(): JsonResponse
    {
        return Response::json([
            'result' => FoodResource::collection(Food::all()->where('type', FoodType::BURGER->value)),
            'message' => 'all burgers'
        ]);
    }

    public function sandwiches(): JsonResponse
    {
        return Response::json([
            'result' => FoodResource::collection(Food::all()->where('type', FoodType::SANDWICH->value)),
            'message' => 'all sandwiches'
        ]);
    }

    public function extras(): JsonResponse
    {
        return Response::json([
            'result' => FoodResource::collection(Food::all()->where('type', FoodType::EXTRA->value)),
            'message' => 'all extras'
        ]);
    }
}
