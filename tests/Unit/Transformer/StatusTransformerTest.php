<?php

namespace Tests\Unit\Transformer;

use Tests\TestCase;
use Manager\Models\Status;
use Manager\Transformer\StatusTransformer;

class StatusTransformerTest extends TestCase
{
    protected $transformer;

    public function setUp(): void
    {
        parent::setUp();

        $this->transformer = new StatusTransformer();
    }

    public function testTransform()
    {
        $status = factory(Status::class)->create();

        $expected = [
            'id'    => $status->id,
            'name'  => $status->name,
            'alias' => $status->alias
        ];

        $this->assertEquals($expected, $this->transformer->transform($status));
    }
}
