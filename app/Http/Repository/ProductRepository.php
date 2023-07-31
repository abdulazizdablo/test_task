<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;

class ProductRepository
{
    public function assignProduct(Product $product, User $user)
    {
        $user->products()->save($product);
    }
}