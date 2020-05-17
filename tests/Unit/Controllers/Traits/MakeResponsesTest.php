<?php


namespace Tests\Unit\Controllers\Traits;

use Mockery;
use Tests\TestCase;
use Manager\Models\Product;
use Dingo\Api\Http\Response;
use Illuminate\Support\Collection;
use Dingo\Api\Http\Response\Factory;
use Manager\Transformer\ProductTransformer;
use Manager\Controllers\Traits\MakesResponses;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class MakeResponsesTest extends TestCase
{
    use MakesResponses;

    protected $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->response = Mockery::mock(Factory::class);
    }

    public function testItem()
    {
        $this->response
            ->shouldReceive('item')
            ->once()
            ->andReturn(Mockery::mock(Response::class));

        $this->assertInstanceOf(Response::class, $this->item(Mockery::mock(Product::class), ProductTransformer::class));
    }

    public function testCollection()
    {
        $this->response
            ->shouldReceive('collection')
            ->once()
            ->andReturn(Mockery::mock(Response::class));

        $this->assertInstanceOf(Response::class, $this->collection(Mockery::mock(Collection::class), ProductTransformer::class));
    }

    public function testArray()
    {
        $this->response
            ->shouldReceive('array')
            ->with([])
            ->once()
            ->andReturn(Mockery::mock(Response::class));

        $this->assertInstanceOf(Response::class, $this->array([]));
    }

    public function testThrowErrorNotFound()
    {
        $this->response
            ->shouldReceive('errorNotFound')
            ->once()
            ->andThrow(Mockery::mock(HttpException::class));

        $this->expectException(HttpException::class);
        $this->throwErrorNotFound();
    }

    public function testThrowErrorBadRequest()
    {
        $this->response
            ->shouldReceive('errorBadRequest')
            ->once()
            ->andThrow(Mockery::mock(HttpException::class));

        $this->expectException(HttpException::class);
        $this->throwErrorBadRequest();
    }

    public function testThrowStore()
    {
        $this->expectException(StoreResourceFailedException::class);
        $this->throwErrorStore();
    }

    public function testThrowUpdate()
    {
        $this->expectException(UpdateResourceFailedException::class);
        $this->throwErrorUpdate();
    }

    public function testThrowDelete()
    {
        $this->expectException(DeleteResourceFailedException::class);
        $this->throwErrorDelete();
    }
}
