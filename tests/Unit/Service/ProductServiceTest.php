<?php

namespace Tests\Unit\Service;

use Manager\Exceptions\ServiceProcessException;
use Mockery;
use Exception;
use Tests\TestCase;
use Manager\Models\Product;
use Manager\Models\Status;
use Manager\Support\StatusSupport;
use Manager\Service\ProductService;
use Manager\Repositories\StatusRepository;
use Manager\Repositories\ProductRepository;

class ProductServiceTest extends TestCase
{
    protected $productService;
    protected $statusRepository;
    protected $productRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->statusRepository       = Mockery::mock(StatusRepository::class);
        $this->productRepository      = Mockery::mock(ProductRepository::class);
        $this->productService   = new ProductService($this->productRepository, $this->statusRepository);
    }

    public function testCreateProducts()
    {
        $status = factory(Status::class)->create([
            'alias' => StatusSupport::STATUS_PRODUCT_PENDING
        ]);

        $this->statusRepository
            ->shouldReceive('findWhere')
            ->once()
            ->with(['alias' => StatusSupport::STATUS_PRODUCT_PENDING])
            ->andReturn($status);


        $product = [
            'name' => 'Produto A',
            'image_path' => '/a'
        ];

        $productFinal = factory(Product::class)->create(array_merge($product, [
            'status_id' => $status->id
        ]));

        $this->productRepository
            ->shouldReceive('create')
            ->once()
            ->with(array_merge($product, [
                'status_id' => $status->id
            ]))
            ->andReturn($productFinal);

        $this->assertEquals($productFinal, $this->productService->createProduct($product));
    }

    public function testCreateProductsShouldBeFail()
    {
        $status = factory(Status::class)->create([
            'alias' => StatusSupport::STATUS_PRODUCT_PENDING
        ]);

        $this->statusRepository
            ->shouldReceive('findWhere')
            ->once()
            ->with(['alias' => StatusSupport::STATUS_PRODUCT_PENDING])
            ->andReturn($status);


        $product = [
            'name' => 'Produto A',
            'image_path' => '/a'
        ];

        $this->productRepository
            ->shouldReceive('create')
            ->once()
            ->with(array_merge($product, [
                'status_id' => $status->id
            ]))
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->productService->createProduct($product);
    }
}
