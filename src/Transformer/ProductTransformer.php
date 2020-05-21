<?php

namespace Manager\Transformer;

use Manager\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product)
    {
        $status = $product->status;

        return [
            'id'        => $product->id,
            'name'      => $product->name,
            'status'    => [
                'id'    => $status->id,
                'name'  => $status->name,
                'alias' => $status->alias
            ],
            'image_path' => asset("storage/images/$product->image_path")
        ];
    }
}
