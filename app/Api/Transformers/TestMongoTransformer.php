<?php

namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\Entities\TestMongo;

/**
 * Class TestMongoTransformer
 */
class TestMongoTransformer extends TransformerAbstract
{

    /**
     * Transform the \TestMongo entity
     * @param \TestMongo $model
     *
     * @return array
     */
    public function transform(TestMongo $model)
    {
        return [
            'id'         => $model->_id,

            

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
