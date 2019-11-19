<?php


namespace App\Http\Controllers\Api\V1;

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
#region GetTransForm
    /*$items = [];
    foreach ($students as $item) {
        $items[] = $item->transform();
    }

    return $this->successRequest([
        'meta' => build_meta_paging($students),
        'items' => $items
    ]);*/
#endregion
#region tao100record
    /*//tao 100 record
          $maxlength = 100;
           $chars = 'a_b_c_d_e_f_g_h_i_j_k_l_m_n_o_p_q_r_s_t_u_v_w_x_y_z';
           $chars = explode('_', $chars);
           $charsCount = count($chars);
           for ($i = 0; $i <= $maxlength; $i++) {
               Student::create([
                   'identification_num' => $i,
                   'full_name' => $chars[$i % $charsCount],
                   'course_name' => 'k14',
               ]);
           }
           return;*/
#endregion
#region Repository
////        $students = $this->studentRepository->paginate();
#endregion
    /**
     * @return View
     */
    public function viewList()
    {
        // Input
        $identification_num = $this->request->get('id');// nhận request get key id từ client gán vào $identification_num
        $name = $this->request->get('name');            // nhận request get key name từ client gán vào $name
        $params = [                        // khai báo giá trị mảng $params['is_paginate'] có tồn tại(bằng 1)
            'is_paginate' => 1,
            // 'is_detail'=>1,
        ];
        if (!empty($identification_nums)) {
            $params['identification_nums'] = $identification_nums;
        }
        if (!empty($identification_num)) { //nếu tồn tại input $identification_num
            $params['identification_num'] = $identification_num; //gán  $params['identification_num'] =$identification_num
        }
        if (!empty($name)) {//nếu tồn tại input $name
            $params['full_name'] = $name;//gán  $params['full_name'] =$name
        }
        $students = $this->studentRepository->getStudents($params);//biến $students= getStudents($params) từ studentRepository với tham số mảng $params
        #region Output
        $viewData = ['students' => $students, 'name' => $name, 'id' => $identification_num];// key name và key id lấy giá trị $name và $identification_num như cũ
        return view('student-list', $viewData);// trả về view student-list.blade.php
        // return $this->successRequest($viewData);
        #endregion
    }

    /**
     * @return View
     */
    public function viewCreateForm()
    {
        #region POST
        if ($this->request->isMethod('POST')) {
            //#region Validation
            $validator = \Validator::make($this->request->all(), [//biến validator....????
                'identification_num' => 'numeric|required',// key identification_num ở view add-student-form.blade.php yêu cầu kiểu số
                'full_name' => 'string|required',// key full_name ở view add-student-form.blade.php yêu cầu string
                'course_name' => 'string|nullable'//key course_name ở view add-student-form.blade.php yêu cầu string
            ]);

            if ($validator->fails()) { //biến $validator gọi hàm thông báo thất bại trả về giá trị true
                return redirect('api/students/create-form');// trỏ tới route api/students/create-form lần nữa
            }
            #endregion
            //#region Input
            $full_name = $this->request->get('full_name'); //biến $full_name lấy giá trị của key full_name ở view add-student-form.blade.php
            $course_name = $this->request->get('course_name');//biến $course_name lấy giá trị của key course_name ở view add-student-form.blade.php
            $identification_num = $this->request->get('identification_num');//biến $identification_num lấy giá trị của key identification_num ở view add-student-form.blade.php
            #endregion
            #region check duplicate
            $checkStudent = Student::where('identification_num', $identification_num)->first();
            if (!empty($checkStudent)) {
                return view('add-student-form', [
                    'isDuplicate' => true,
                    'identification_num' => $identification_num,
                    'full_name' => $full_name,
                    'course_name' => $course_name,
                ]);
            }
            #endregion
            #region insert
            $student = Student::create([//insert sinh viên thông qua enrity Student đã kết nối với bảng students ở mysql
                'full_name' => $full_name,// trường full_name trong bảng student sẽ lấy giá trị của biến $full_name
                'identification_num' => $identification_num,// trường identification_num trong bảng student sẽ lấy giá trị của biến $identification_num
                'course_name' => $course_name,// trường course_name trong bảng student sẽ lấy giá trị của biến $course_name
            ]);
            $student->save();
            return redirect('api/v1/students/view-list');
            #endregion
        }
        #endregion
        #region GET
        return view('add-student-form', [
            "isDuplicate" => false,
            'full_name' => '',
            'identification_num' => '',
            'course_name' => '',
        ]);
        #endregion
    }

    /**
     * @return RedirectResponse|Redirector
     * @throws \Exception
     */
    public function delete()
    {
        #region Validation
        $validator = \Validator::make($this->request->all(), [//biến validator lấy hết các request`
            'id' => 'required_without:ids',
            'ids' => 'required_without:id',
        ]);

        if ($validator->fails()) { //biến $validator gọi hàm thông báo thất bại trả về giá trị true
            return redirect('api/students/edit-form');// trỏ tới route api/students/create-form lần nữa
        }
        #endregion

        //#region  Input
        $id = $this->request->get('id');       // gán giá trị của key id ở view add-student-form.blade.php cho biến $id
        $ids = $this->request->get('ids');
        #endregion

        #region Delete
        $params = [];
        if (!empty($ids)) {
            $params['ids'] = $ids;
        } else {
            $params['id'] = $id;
        }

        $students = $this->studentRepository->getStudents($params);

        foreach ($students as $student) {
            $student->delete();
        }
        #endregion

        return redirect('api/students/view-list'); // trỏ tới route api/students/view-list
    }

    public function viewEditForm()
    {
        #region POST
        if ($this->request->isMethod('POST')) {   //nếu client post lên sever
            #region Validation
            $validator = \Validator::make($this->request->all(), [//biến validator lấy hết các request`
                'identification_num' => 'numeric|required',// key identification_num ở view add-student-form.blade.php yêu cầu kiểu số
                'full_name' => 'string|required',// key full_name ở view add-student-form.blade.php yêu cầu string
                'course_name' => 'string|nullable'//key course_name ở view add-student-form.blade.php yêu cầu string
            ]);

            if ($validator->fails()) { //biến $validator gọi hàm thông báo thất bại trả về giá trị true
                return redirect('api/students/edit-form');// trỏ tới route api/students/create-form lần nữa
            }
            #endregion

            #region Input
            $identification_num = $this->request->get('identification_num');
            $full_name = $this->request->get('full_name');
            $course_name = $this->request->get('course_name');
            #endregion

            //#region Update
            $id = $this->request->get('id');
            $params = [                        // khai báo giá trị mảng $params['is_paginate'] có tồn tại(bằng 1)
                'is_detail' => 1,
                'id' => $id
            ];

            // $studentEdit = Student::find($id);
            $studentEdit = $this->studentRepository->getStudents($params);
            $studentEdit->full_name = $full_name;
            $studentEdit->course_name = $course_name;
            $studentEdit->identification_num = $identification_num;
            $studentEdit->save();
            return redirect('api/v1/students/view-list');
            #endregion

        }
        #endregion

        #region GET
        //#region Input
        $id = $this->request->get('id');

        $params = [                        // khai báo giá trị mảng $params['is_paginate'] có tồn tại(bằng 1)
            'is_detail' => 1,
            'id' => $id];
        #endregion
        //#region Get detail
        // $studentEdit = Student::find($id);
        $studentEdit = $this->studentRepository->getStudents($params);
        return view('edit-student-form', [      //trả về view add-student-form.blade.php nếu client dùng get
            "isDuplicate" => false,                  // gán giá trị mặc định cho biến $isDuplicate
            'full_name' => $studentEdit->full_name,
            'identification_num' => $studentEdit->identification_num,
            'course_name' => $studentEdit->course_name,]);
        #endregion
        #endregion
    }

}
