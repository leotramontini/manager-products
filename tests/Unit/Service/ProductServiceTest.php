<?php

namespace Tests\Unit\Service;

use Illuminate\Http\UploadedFile;
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

        $extension      = $this->faker->name;
        $productName    = $this->faker->name;

        $uploadedImage  = Mockery::mock(UploadedFile::class);
        $uploadedImage
            ->shouldReceive('extension')
            ->once()
            ->andReturn($extension);

        $uploadedImage
            ->shouldReceive('storeAs')
            ->once()
            ->andReturn(true);

        $this->productRepository
            ->shouldReceive('create')
            ->once()
            ->andThrow(new Product());

        $product = [
            'name'  => $productName,
            'image' => $uploadedImage
        ];

        $this->assertInstanceOf(Product::class , $this->productService->createProduct($product));
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

        $extension      = $this->faker->name;
        $productName    = $this->faker->name;

        $uploadedImage  = Mockery::mock(UploadedFile::class);
        $uploadedImage
            ->shouldReceive('extension')
            ->once()
            ->andReturn($extension);

        $uploadedImage
            ->shouldReceive('storeAs')
            ->once()
            ->andReturn(true);

        $this->productRepository
            ->shouldReceive('create')
            ->once()
            ->andThrow(Exception::class);

        $product = [
            'name'  => $productName,
            'image' => $uploadedImage
        ];

        $this->expectException(ServiceProcessException::class);
        $this->productService->createProduct($product);
    }

    public function testDeleteProduct()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $this->productRepository
            ->shouldReceive('delete')
            ->once()
            ->with($product->id)
            ->andReturn(1);

        $this->assertEquals(1, $this->productService->deleteProduct($product->id));
    }

    public function testDeleteProductShouldBeFail()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $this->productRepository
            ->shouldReceive('delete')
            ->once()
            ->with($product->id)
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->productService->deleteProduct($product->id);
    }

    public function testUpdateProduct()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $newName = $this->faker->name;
        $extension = $this->faker->name;

        $uploadedImage  = Mockery::mock(UploadedFile::class);
        $uploadedImage
            ->shouldReceive('extension')
            ->once()
            ->andReturn($extension);

        $uploadedImage
            ->shouldReceive('storeAs')
            ->once()
            ->andReturn(true);

        $this->productRepository
            ->shouldReceive('update')
            ->once()
            ->andReturn(new Product());

        $this->assertInstanceOf(Product::class, $this->productService->updateProduct(['name' => $newName, 'image' => $uploadedImage], $product->id));
    }

    public function testUpdateProductShouldBeFail()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $newName = $this->faker->name;

        $this->productRepository
            ->shouldReceive('update')
            ->once()
            ->with(['name' => $newName], $product->id)
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->productService->updateProduct(['name' => $newName], $product->id);
    }
    public function testListProduct()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $this->productRepository
            ->shouldReceive('findWhere')
            ->once()
            ->with(['id' => $product->id])
            ->andReturn($product);

        $this->assertInstanceOf(Product::class, $this->productService->listProduct(['id' => $product->id]));
    }

    public function testListProductShouldBeFail()
    {
        $this->productRepository
            ->shouldReceive('findWhere')
            ->once()
            ->with([])
            ->andThrow(Exception::class);

        $this->expectException(ServiceProcessException::class);
        $this->productService->listProduct([]);
    }
}
