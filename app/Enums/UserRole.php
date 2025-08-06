<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'Administrator';
    case USER = 'Costumer';
}
