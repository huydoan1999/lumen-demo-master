<?php

namespace App\Api\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Api\Repositories\Contracts\UserRepository;
use App\Api\Repositories\Contracts\testMongoRepository;
use App\Api\Entities\TestMongo;
use App\Api\Validators\TestMongoValidator;

/**
 * Class TestMongoRepositoryEloquent
 */
class TestMongoRepositoryEloquent extends BaseRepository implements TestMongoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TestMongo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }
}
