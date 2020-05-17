<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use Manager\Support\StatusSupport;

class StatusSupportTest extends TestCase
{
    public function testGetAllStatuses()
    {
        $expected = [
            [
                'name'  => 'Produto pendente',
                'alias' => StatusSupport::STATUS_PRODUCT_PENDING
            ],
            [
                'name'  => 'Produto em análise',
                'alias' => StatusSupport::STATUS_PRODUCT_UNDER_ANALYSIS
            ],
            [
                'name'  => 'Produto aprovado',
                'alias' => StatusSupport::STATUS_PRODUCT_APPROVED
            ],
            [
                'name'  => 'Produto negado',
                'alias' => StatusSupport::STATUS_PRODUCT_REFUSED
            ]
        ];

        $this->assertEquals($expected, StatusSupport::getAllStatuses());
    }
}
