<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'Administrator';
    case User = 'Costumer';
}
