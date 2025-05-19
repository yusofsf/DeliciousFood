<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drink\StoreRequest;
use App\Http\Requests\Drink\UpdateRequest;
use App\Http\Resources\DrinkResource;
use App\Models\Drink;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class DrinkController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::json([
            'result' => DrinkResource::collection(Drink::all()),
            'message' => 'All drinks'
        ]);
    }

    public function show(Drink $drink): JsonResponse
    {
        return Response::json([
            'result' => $drink->toResource(DrinkResource::class),
            'message' => 'All drinks'
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $image = time() . '.' . $validated['image']->getClientOriginalExtension();
        $validated['image']->move(public_path('images/drinks'), $image);

        $newDrink = Drink::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'img_url' => 'images/drinks/' . $image,
        ]);

        return Response::json([
            'result' => $newDrink->toResource(DrinkResource::class),
            'message' => 'drink stored'
        ], 201);
    }

    public function update(UpdateRequest $request, Drink $drink): JsonResponse
    {
        $validated = $request->validated();

        $image = null;

        if (array_key_exists('image', $validated)) {
            $image = time() . '.' . $validated['image']->getClientOriginalExtension();
            $validated['image']->move(public_path('images/drinks'), $image);
        }

        $drink->update([
            'name' => $validated['name'],
            'price' => $validated['price'] ?? $drink->price,
            'img_url' => $image ? 'images/drinks/' . $image : $drink->img_url,
        ]);

        return Response::json([
            'result' => $drink->toResource(DrinkResource::class),
            'message' => 'drink updated'
        ]);
    }

    public function destroy(Drink $drink): JsonResponse
    {
        $drink->delete();

        return Response::json([
            'message' => 'drink deleted'
        ]);
    }
}
