<?php


namespace Tests\Unit\Repositories;

use Manager\Models\Product;
use Manager\Repositories\ProductRepository;
use PHPUnit\Framework\TestCase;

class ProductsRepositoryTest extends TestCase
{
    public function testModel()
    {
        $this->assertEquals(Product::class, ProductRepository::model());
    }
}
