<?php

namespace Manager\Repositories;

use Manager\Models\Status;
use Prettus\Repository\Eloquent\BaseRepository;

class StatusRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Status::class;
    }
}
