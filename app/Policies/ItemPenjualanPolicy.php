<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ItemPenjualan;

class ItemPenjualanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function deltete(User $user, ItemPenjualan $itempenjualan): bool
    {
        return $user->role->name === 'admin';
    }
}
