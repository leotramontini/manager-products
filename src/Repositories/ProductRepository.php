<?php

namespace Manager\Repositories;

use Manager\Models\Product;
use Prettus\Repository\Eloquent\BaseRepository;

class ProductRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Product::class;
    }
}
