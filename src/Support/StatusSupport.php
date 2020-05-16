<?php


namespace Manager\Support;


class StatusSupport
{
    /**
     * @const string
     */
    const STATUS_PRODUCT_PENDING = 'product.pending';

    /**
     * @const string
     */
    const STATUS_PRODUCT_UNDER_ANALYSIS = 'product.under_analysis';

    /**
     * @const string
     */
    const STATUS_PRODUCT_APPROVED = 'product.approved';

    /**
     * @const string
     */
    const STATUS_PRODUCT_REFUSED = 'product.refused';


    /**
     * @return array
     */
    public static function getAllStatuses() : array
    {
        return [
            [
                'name'  => 'Produto pendente',
                'alias' => self::STATUS_PRODUCT_PENDING
            ],
            [
                'name'  => 'Produto em análise',
                'alias' => self::STATUS_PRODUCT_UNDER_ANALYSIS
            ],
            [
                'name'  => 'Produto aprovado',
                'alias' => self::STATUS_PRODUCT_APPROVED
            ],
            [
                'name'  => 'Produto negado',
                'alias' => self::STATUS_PRODUCT_REFUSED
            ]
        ];
    }
}
