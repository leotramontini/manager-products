<?php

namespace Manager\Service;

use Exception;
use Manager\Exceptions\EmptyResult;
use Manager\Repositories\StatusRepository;
use Manager\Exceptions\ServiceProcessException;

class StatusService
{
    /**
     * @var \Manager\Repositories\StatusRepository
     */
    protected $statusRepository;

    /**
     * StatusService constructor.
     * @param \Manager\Repositories\StatusRepository $statusRepository
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Manager\Exceptions\ServiceProcessException
     */
    public function getAllStatus()
    {
        try {
             $statuses = $this->statusRepository->all();

             if ($statuses->isEmpty()) {
                 throw new EmptyResult();
             }

             return $statuses;
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
        }
    }
}
