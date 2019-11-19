<?php

namespace App\Api\Repositories\Eloquent;

use App\Api\Criteria\ShopCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Api\Repositories\Contracts\UserRepository;
use App\Api\Repositories\Contracts\StudentRepository;
use App\Api\Entities\Student;
use App\Api\Validators\StudentValidator;
use App\Api\Criteria\StudentCriteria;

/**
 * Class StudentRepositoryEloquent
 */
class StudentRepositoryEloquent extends BaseRepository implements StudentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Student::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }

    /**
     * @param array $params
     * @param int $limit
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getStudents($params = [],$limit = 0)//truyền 1 hoặc 2 tham số
    {
        $this->pushCriteria(new StudentCriteria($params));  //nạp $params vào StudentCriteria
        if(!empty($params['is_paginate'])) { //nếu tồn tại biến $params['is_paginate'] ở controller
            $item = $this->paginate();            //thì trả về cho controller giá trị phân trang
        } elseif(!empty($params['is_detail'])) {   //nếu tồn tại biến $params['is_detail'] ở controller
            $item = $this->first();            //thì trả về cho controller 1 giá trị đầu tiên k phân trang
        } else {
            $item = $this->all();            //ngược lại trả về cho controller tất cả giá trị k phân trang
        }
        $this->popCriteria(new StudentCriteria($params));//lấy ... từ StudentCriteria
        return $item;
    }
    public function deleteStudents($params = [],$limit = 0)
    {
       // $this->pushCriteria(new StudentCriteria($params));
        if(!empty($params['id']))
        {
            $item=$this->delete($params['id']);
        }
        else $item=$this->paginate();
      //  $this->popCriteria(new StudentCriteria($params));//lấy ... từ StudentCriteria
        return $item;
    }
}
