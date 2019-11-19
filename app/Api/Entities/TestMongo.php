<?php

namespace App\Api\Entities;

use Moloquent\Eloquent\Model as Moloquent;
use App\Api\Transformers\TestMongoTransformer;
use Moloquent\Eloquent\SoftDeletes;

class TestMongo extends Moloquent
{
	use SoftDeletes;

	protected $collection = '';

    protected $fillable = [];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function transform()
    {
        $transformer = new TestMongoTransformer();

        return $transformer->transform($this);
    }

}
