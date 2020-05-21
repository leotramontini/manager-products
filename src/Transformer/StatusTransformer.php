<?php

namespace Manager\Transformer;

use League\Fractal\TransformerAbstract;
use Manager\Models\Status;

class StatusTransformer extends TransformerAbstract
{
    /**
     * @param \Manager\Models\Status $status
     * @return array
     */
    public function transform(Status $status)
    {
        return [
            'id'    => $status->id,
            'name'  => $status->name,
            'alias' => $status->alias
        ];
    }
}
