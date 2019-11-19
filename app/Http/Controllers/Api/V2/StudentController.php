<?php


namespace App\Http\Controllers\Api\V2;

use App\Api\Entities\Kpi;
use App\Api\Entities\Student;
use App\Api\Entities\Subject;
use App\Api\Repositories\Contracts\StudentRepository;
use App\Http\Controllers\Controller;
use Dompdf\Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Laravel\Lumen\Http\Redirector;


class StudentController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * StudentController constructor.
     * @param Request $request
     * @param StudentRepository $studentRepository
     */
    public function __construct(
        Request $request,
        StudentRepository $studentRepository
    )
    {
        $this->request = $request;
        $this->studentRepository = $studentRepository;
    }


    /**
     * List students
     * @return mixed
     */
    public function listItems()
    {
        #region Input
        $full_name = $this->request->get('full_name');// gán biến $full_name bằng key full name ở route list
        $course_name=$this->request->get('course_name');
        $id=$this->request->get('id');
        $identification_num=$this->request->get('identification_num');
        #endregion

        #region Get student list
        $params =[
            'is_paginate' => 1    // khai báo mảng $params['is_paginate']=1
        ];
        if (!empty($identification_num)) {
            $params['identification_num'] = $identification_num;
        }
        if (!empty($id)) {
            $params['id'] = $id;
        }
        if (!empty($full_name)) {
            $params['full_name'] = $full_name;
        }
        if (!empty($course_name)) {
            $params['course_name'] = $course_name;
        }

        $students = $this->studentRepository->getStudents($params);

        $items = [];
        foreach ($students as $student) {
            $items[] = $student->transform();
        }
        #endregion

        $data = [
            'items' => $items,
            'meta' => build_meta_paging($students)
        ];
        return $this->successRequest($data);
    }

    public function add()
    {
        #region Validation
        $validator = \Validator::make($this->request->all(), [
            'identification_num' => 'required|numeric',
            'full_name' => 'required|string',
            'course_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator->messages()->toArray());
        }
        #endregion

        #region Input
        $full_name = $this->request->get('full_name');
        $course_name = $this->request->get('course_name');
        $identification_num = $this->request->get('identification_num');
        #endregion

        #region Check duplicate id_num
        $checkParams = [
            'is_detail' => 1,
            'identification_num' => $identification_num
        ];
        $checkStudent = $this->studentRepository->getStudents($checkParams);
        if (!empty($checkStudent)) {
            return $this->errorBadRequest('Mã sinh viên đã tồn tại');
        }
        #endregion

        #region Insert Student
        $attributes = [
            'full_name' => $full_name,
            'identification_num' => $identification_num,
        ];
        if (!empty($course_name)) {
            $attributes['course_name'] = $course_name;
        }
        $student = $this->studentRepository->create($attributes);
        #endregion

        return $this->successRequest($student->transform());
    }

    public function delete()
    {
        #region Validation
        $validator = \Validator::make($this->request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator->messages()->toArray());
        }
        #endregion

        #region Input
        $id = $this->request->get('id');
        #endregion

        #region Check student exists
        $checkParams = [
            'is_detail' => 1,
            'id' => $id,
        ];
        $checkStudent = $this->studentRepository->getStudents($checkParams);
        if (empty($checkStudent)) {
            return $this->errorBadRequest('Sinh viên không tồn tại');
        }
        #endregion

        #region Delete
        $checkStudent->delete();
        #endregion

        return $this->successRequest('Thành công');
    }

    public function edit()
    {
        #region Validation
        $validator = \Validator::make($this->request->all(), [
            'id' => 'required',
            'identification_num' => 'required|numeric',
            'full_name' => 'required|string',
            'course_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator->messages()->toArray());
        }
        #endregion

        #region Input
        $id = $this->request->get('id');
        $full_name = $this->request->get('full_name');
        $course_name = $this->request->get('course_name');
        $identification_num = $this->request->get('identification_num');
        #endregion

        #region Check student exists
        $checkParams = [
            'is_detail' => 1,
            'id' => $id,
        ];
        $Student = $this->studentRepository->getStudents($checkParams);
        if (empty($Student)) {
            return $this->errorBadRequest('Sinh viên không tồn tại');
        }
        #endregion

        #region Check duplicate id_num
        $checkDupParams = [
            'is_detail' => 1,
            'identification_num' => $identification_num,
            'exclude_id' => $Student->id
        ];
        $checkDuplicateStudent = $this->studentRepository->getStudents($checkDupParams);
        if (!empty($checkDuplicateStudent)) {
            return $this->errorBadRequest('Mã sinh viên đã tồn tại');
        }
        #endregion

        #region Update Student
        $Student->full_name = $full_name;
        $Student->identification_num = $identification_num;
        $Student->course_name = $course_name;
        $Student->save();
        #endregion

        return $this->successRequest($Student->transform());
    }


}
