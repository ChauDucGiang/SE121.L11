<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use \App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Product::class;
    }
}
