<?php

namespace App\Http\Controllers\Api;

use App\Enums\FoodType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        Gate::allowIf(fn(User $user) => $user->isAdmin());

        return Response::json([
            'result' => User::all(),
            'message' => 'All Users'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        Gate::allowIf(fn(User $user) => $user->isAdmin());

        $user->delete();

        return Response::json([
            'message' => 'user deleted'
        ]);
    }

    public function userOrders(): JsonResponse
    {
        Gate::allowIf(fn(User $user) => $user->isUser());

        return Response::json([
            'result' => Auth::user()->orders()->get(),
            'message' => 'All User Orders'
        ]);
    }

    public function userFoods(): JsonResponse
    {
        Gate::allowIf(fn(User $user) => $user->isUser());

        return Response::json([
            'result' => Auth::user()->orderItems()->whereIn('type', [FoodType::SANDWICH->value, FoodType::BURGER->value])->get(),
            'message' => 'All User foods ordered'
        ]);
    }

    public function userExtras(): JsonResponse
    {
        Gate::allowIf(fn(User $user) => $user->isUser());

        return Response::json([
            'result' => Auth::user()->orderItems()->where('type', FoodType::EXTRA->value)->get(),
            'message' => 'All User extras ordered'
        ]);
    }

    public function userDrinks(): JsonResponse
    {
        Gate::allowIf(fn(User $user) => $user->isUser());

        return Response::json([
            'result' => Auth::user()->orderItems()->where('type', 'drink')->get(),
            'message' => 'All User drinks ordered'
        ]);
    }
}
