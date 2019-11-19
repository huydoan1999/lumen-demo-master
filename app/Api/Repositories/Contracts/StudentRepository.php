<?php

namespace App\Api\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface StudentRepository
 */
interface StudentRepository extends RepositoryInterface
{
    public function getStudents($params = [], $limit = 0);
    public function deleteStudents($params = [],$limit = 0);
}
