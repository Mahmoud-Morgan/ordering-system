<?php

namespace App\Repositories\Implementations;

use App\Models\Product;
use App\Repositories\IProductRepository;

class ProductRepository extends Repository implements IProductRepository
{
    public function __construct(Product $product)
    {
        $this->setModel($product);
    }

}
