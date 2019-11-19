<?php

namespace App\Api\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SubjectRepository
 */
interface SubjectRepository extends RepositoryInterface
{
    public function getSubjects($params = [],$limit = 0);
}
