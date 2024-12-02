<?php

namespace App\Repositories\Cart;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function get() : Collection;
    
    public function add(ProductVariant $productVariant, $quantity = 1, $color_id = null, $size_id = null);


    public function update($id, $quantity);

    public function delete($id);

    public function empty();

    public function total() : float;
}