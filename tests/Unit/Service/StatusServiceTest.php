<?php

namespace Tests\Unit\Service;

use Mockery;
use Tests\TestCase;
use Manager\Models\Status;
use Manager\Service\StatusService;
use Manager\Repositories\StatusRepository;
use Manager\Exceptions\ServiceProcessException;

class StatusServiceTest extends TestCase
{
    protected $statusService;
    protected $statusRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->statusRepository = Mockery::mock(StatusRepository::class);
        $this->statusService    = new StatusService($this->statusRepository);
    }

    public function testGetAllStatus()
    {
        $status = collect(factory(Status::class));

        $this->statusRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($status);

        $this->assertEquals($status, $this->statusService->getAllStatus());
    }

    public function testGetAllStatusShouldBeFail()
    {
        $this->statusRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn(collect([]));

        $this->expectException(ServiceProcessException::class);
        $this->statusService->getAllStatus();
    }
}
