<?php

namespace Manager\Service;

use Exception;
use Manager\Support\StatusSupport;
use Manager\Repositories\StatusRepository;
use Manager\Repositories\ProductRepository;
use Manager\Exceptions\ServiceProcessException;

class ProductService
{
    /**
     * @var \Manager\Repositories\ProductRepository $productRepository
     */
    protected $productRepository;

    /**
     * @var \Manager\Repositories\StatusRepository $statusRepository
     */
    protected $statusRepository;

    /**
     * ProductService constructor.
     * @param \Manager\Repositories\ProductRepository $productRepository
     * @param \Manager\Repositories\StatusRepository $statusRepository
     */
    public function __construct(ProductRepository $productRepository, StatusRepository $statusRepository)
    {
        $this->statusRepository     = $statusRepository;
        $this->productRepository    = $productRepository;

    }

    /**
     * @param array $productData
     * @return \Illuminate\Support\Collection
     * @throws \Manager\Exception\ServiceProcessException
     */
    public function createProduct($productData)
    {
        try {
            $pendingStatus = $this->getStatusByAlias(StatusSupport::STATUS_PRODUCT_PENDING);

            return $this->productRepository->create(
                array_merge($productData, [
                    'status_id' => $pendingStatus->id
                ])
            );
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage(), $error->getCode());
        }
    }

    /**
     * @param string $statusAlias
     * @return \Illuminate\Support\Collection
     */
    public function getStatusByAlias($statusAlias)
    {
        return $this->statusRepository->findWhere([
            'alias' => $statusAlias
        ])->first();
    }
}
