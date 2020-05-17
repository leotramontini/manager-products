<?php

namespace Tests\Unit\Controllers;

use Manager\Support\StatusSupport;
use Mockery;
use Tests\TestCase;
use Manager\Models\Status;
use Manager\Models\Product;
use Illuminate\Http\UploadedFile;

class ProductControllerTest extends TestCase
{
    protected $baseResource;

    public function setUp(): void
    {
        parent::setUp();

        $this->baseResource = '/api/product';
    }

    public function testListProduct()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $expected = [
            'data' => [
                [
                    'id'    => $product->id,
                    'name'  => $product->name,
                    'status' => [
                        'id'    => $status->id,
                        'name'  => $status->name
                    ],
                    'image_path' => asset("storage/images/$product->image_path")
                ]
            ]
        ];

        $response = $this->json('GET', $this->baseResource);
        $response->assertJson($expected)
        ->assertStatus(200);
    }

    public function testListProductShouldBeFail()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $response = $this->json('GET', $this->baseResource . '?' . $this->faker->name . '=' . $this->faker->name);
        $response
        ->assertStatus(404);
    }

    public function testDeleteProduct()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $expected = [
            'data' => [
                'message' => 'Product delete with success'
            ]
        ];

        $response = $this->json('DELETE', $this->baseResource . "/$product->id");
        $response->assertJson($expected)
            ->assertStatus(200);
    }

    public function testDeleteProductShouldBeFail()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $productId = $product->id + $this->faker->randomDigitNotNull;

        $response = $this->json('DELETE', $this->baseResource . "/$productId");
        $response
            ->assertStatus(422);
    }

    public function testUpdateProduct()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $newName = $this->faker->name;

        $expected = [
            'data' => [
                'id'    => $product->id,
                'name'  => $newName,
                'status' => [
                    'id'    => $status->id,
                    'name'  => $status->name
                ],
                'image_path' => asset("storage/images/$product->image_path")
            ]
        ];

        $response = $this->json('PUT', $this->baseResource . "/$product->id", ['name' => $newName]);
        $response->assertJson($expected)
            ->assertStatus(200);
    }

    public function testUpdateProductShouldBeFail()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $newName = $this->faker->name;

        $productId = $product->id + $this->faker->randomDigitNotNull;
        $response = $this->json('PUT', $this->baseResource . "/$productId", ['name' => $newName]);
        $response
            ->assertStatus(422);
    }

    public function testCreateProducts()
    {
        factory(Status::class)->create([
            'alias' => StatusSupport::STATUS_PRODUCT_PENDING
        ]);

        $uploadedImage  = Mockery::mock(UploadedFile::class);
        $uploadedImage
            ->shouldReceive('extension')
            ->once()
            ->andReturn('png');

        $uploadedImage
            ->shouldReceive('storeAs')
            ->once()
            ->andReturn(true);

        $expected = [
            'data' => [
                'id',
                'name',
                'status' => [
                    'id',
                    'name'
                ],
                'image_path'
            ]
        ];

        $product = [
            'name'  => $this->faker->name,
            'image' => $uploadedImage
        ];

        $response = $this->json('POST', $this->baseResource, $product);

        $response
            ->assertJsonStructure($expected)
            ->assertStatus(200);
    }

    public function testCreateProductsShouldBeFail()
    {
        $uploadedImage  = Mockery::mock(UploadedFile::class);
        $uploadedImage
            ->shouldReceive('extension')
            ->once()
            ->andReturn('png');

        $uploadedImage
            ->shouldReceive('storeAs')
            ->once()
            ->andReturn(true);

        $expected = [
            'message',
            'status_code'
        ];

        $product = [
            'image' => $uploadedImage
        ];

        $response = $this->json('POST', $this->baseResource, $product);

        $response
            ->assertJsonStructure($expected)
            ->assertStatus(500);
    }
}
