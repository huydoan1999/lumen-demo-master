<?php

namespace App\Api\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Class BranchCriteria
 */
class StudentCriteria implements CriteriaInterface
{
    protected $params;
    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)  //hàm apply kế thừa từ interface CriteriaInterface
    {
        $query = $model->newQuery();     //khởi tạo câu query

        if(!empty($this->params['id'])) {   //nếu tồn tại params['id'] ở controller
            $query->where('id',$this->params['id']); // câu query= select from where id=params['id']
        }
        if(!empty($this->params['ids'])) {   //nếu tồn tại params['id'] ở controller
            $query->whereIn('id',$this->params['ids']); // câu query= select from where id=params['id']
        }
        if(!empty($this->params['exclude_id'])) {   //nếu tồn tại params['id'] ở controller
            $query->where('id', '<>', $this->params['exclude_id']); // câu query= select from where id=params['id']
        }
        if(!empty($this->params['full_name'])) {// nếu tồn tại params['full_name'] ở controller
            $pattern = '%'.$this->params['full_name'].'%'; //gán $pattern='%$this->params['full_name']%'
            $query->where('full_name', 'like', $pattern);//câu query= select from where full_name like '%params['full_name']%'
        }
        if(!empty($this->params['course_name'])) {// nếu tồn tại params['full_name'] ở controller
            $query->where('course_name', $this->params['course_name']);//câu query= select from where full_name like '%params['full_name']%'
        }
        if(!empty($this->params['identification_num'])) {//nếu tồn tại params['identification_num'] ở controller
            $query->where('identification_num',$this->params['identification_num']);//câu query= select from where identification_num=params['identification_num']
        }
        if(!empty($this->params['identification_nums'])) {//nếu tồn tại params['identification_nums'] ở controller
            $query->whereIn('identification_num',$this->params['identification_nums']);//câu query= select from where identification_num in params['identification_nums']
        }
      /*  if(!empty($this->params['delete'])) {
            $query->delete('id',$this->params['id']);
        }*/
        return $query; //trả về câu query
    }
}
