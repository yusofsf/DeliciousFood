<?php

namespace App\Policies;

use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->isUser() || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function cancel(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function confirm(User $user): bool
    {
        return $user->isUser();
    }
}
