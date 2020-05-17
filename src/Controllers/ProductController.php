<?php

namespace Manager\Controllers;

use Illuminate\Http\Request;
use Manager\Service\ProductService;
use Manager\Transformer\ProductTransformer;
use Manager\Exceptions\ServiceProcessException;

class ProductController extends BaseController
{

    /**
     * @var \Manager\Service\ProductService $productService
     */
    protected $productService;

    /**
     * ProductController constructor.
     * @param \Manager\Service\ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $product = $this->productService->createProduct($request->all());
        } catch (ServiceProcessException $error) {
            $this->throwErrorStore($error->getMessage(), $error->getCode());
        }

        return $this->item($product, new ProductTransformer());
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function delete($productId)
    {
        try {
            $this->productService->deleteProduct($productId);
        } catch (ServiceProcessException $error)  {
            $this->throwErrorDelete($error->getMessage());
        }

        return $this->array([
            'data' => [
                'message' => 'Product delete with success'
            ]
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $productId
     * @return mixed
     */
    public function update(Request $request, $productId)
    {
        try {
            $product = $this->productService->updateProduct($request->all(), $productId);
        } catch (ServiceProcessException $error) {
            $this->throwErrorUpdate($error->getMessage());
        }
        return $this->item($product, new ProductTransformer());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $products = $this->productService->listProduct($request->all());
        } catch (ServiceProcessException $error) {
            $this->throwErrorNotFound($error->getMessage());
        }

        return $this->collection($products, new ProductTransformer());
    }
}
