<?php

namespace App\Api\Repositories\Eloquent;

use App\Api\Criteria\SubjectCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Api\Repositories\Contracts\UserRepository;
use App\Api\Repositories\Contracts\subjectRepository;
use App\Api\Entities\Subject;
use App\Api\Validators\SubjectValidator;

/**
 * Class SubjectRepositoryEloquent
 */
class SubjectRepositoryEloquent extends BaseRepository implements SubjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subject::class;
    }

    /**
     * @param array $params
     * @param int $limit
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getSubjects($params = [],$limit = 0)//truyền 1 hoặc 2 tham số
    {
        $this->pushCriteria(new SubjectCriteria($params));  //nạp $params vào StudentCriteria
        if(!empty($params['is_paginate'])) { //nếu tồn tại biến $params['is_paginate'] ở controller
            $item = $this->paginate();            //thì trả về cho controller giá trị phân trang
        } elseif(!empty($params['is_detail'])) {   //nếu tồn tại biến $params['is_detail'] ở controller
            $item = $this->first();            //thì trả về cho controller 1 giá trị đầu tiên k phân trang
        } else {
            $item = $this->all();            //ngược lại trả về cho controller tất cả giá trị k phân trang
        }
        $this->popCriteria(new SubjectCriteria($params));//lấy ... từ StudentCriteria
        return $item;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }
}
