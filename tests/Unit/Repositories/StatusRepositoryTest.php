<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Manager\Models\Status;
use Manager\Repositories\StatusRepository;

class StatusRepositoryTest extends TestCase
{
    public function testModel()
    {
        $this->assertEquals(Status::class, StatusRepository::model());
    }
}
