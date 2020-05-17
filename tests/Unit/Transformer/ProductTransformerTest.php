<?php


namespace Tests\Unit\Transformer;

use Tests\TestCase;
use Manager\Models\Status;
use Manager\Models\Product;
use Manager\Transformer\ProductTransformer;

class ProductTransformerTest extends TestCase
{
    protected $transformer;

    public function setUp(): void
    {
        parent::setUp();

        $this->transformer = new ProductTransformer();
    }

    public function testTransform()
    {
        $status = factory(Status::class)->create();

        $product = factory(Product::class)->create([
            'status_id' => $status->id
        ]);

        $expected = [
            'id'        => $product->id,
            'name'      => $product->name,
            'status'    => [
                'id'    => $status->id,
                'name'  => $status->name
            ],
            'image_path' => asset("storage/images/$product->image_path")
        ];

        $this->assertEquals($expected, $this->transformer->transform($product));
    }
}
