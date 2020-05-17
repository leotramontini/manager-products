<?php

namespace Manager\Service;

use Exception;
use Illuminate\Support\Arr;
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

            $nameImage = $this->storeImage(Arr::get($productData, 'image'));

            return $this->productRepository->create([
                'name'          => Arr::get($productData, 'name'),
                'status_id'     => $pendingStatus->id,
                'image_path'    => $nameImage
            ]);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage(), $error->getCode());
        }
    }

    /**
     * @param int $productId
     * @return int
     * @throws \Manager\Exceptions\ServiceProcessException
     */
    public function deleteProduct($productId)
    {
        try {
            return $this->productRepository->delete($productId);
        } catch (Exception $error) {
            throw new ServiceProcessException($error);
        }
    }

    /**
     * @param array $productData
     * @param int $productId
     * @return \Illuminate\Support\Collection
     * @throws \Manager\Exceptions\ServiceProcessException
     */
    public function updateProduct($productData, $productId)
    {
        try {
            return $this->productRepository->update($productData, $productId);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage(), $error->getCode());
        }
    }

    /**
     * @param array $filter
     * @return \Illuminate\Support\Collection
     * @throws \Manager\Exceptions\ServiceProcessException
     */
    public function listProduct($filter)
    {
        try {
            return $this->productRepository->findWhere($filter);
        } catch (Exception $error) {
            throw new ServiceProcessException($error->getMessage());
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

    /**
     * @param \Illuminate\Http\UploadedFile $image
     * @return string
     */
    public function storeImage($image)
    {
        $extension  = $image->extension();
        $path       = 'public/images';
        $nameImage  = md5(microtime()) . '.' . $extension;

        $image->storeAs($path, $nameImage, 'local');
        return $nameImage;
    }
}
