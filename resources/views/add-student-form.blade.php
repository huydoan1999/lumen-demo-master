@extends('layouts.app')

@section('content') {{--section ....???????--}}
    <h3>Tạo sinh viên</h3>
    <form onsubmit="/api/students/create-form" method="POST">{{--onsubmit.......????????--}}
        <div class="form-group">
            <label for="inputFullName">Mã số sinh viên<span class="text-danger">*</span></label>
            <input name="identification_num" type="number" class="form-control {{$isDuplicate ? 'is-invalid' : ''}}" id="in" required
                   placeholder="Mã số sinh viên" value="{{$identification_num}}">
            @if($isDuplicate){{--nếu biến $isDuplicate có giá trị true--}}
                <div class="invalid-feedback"> {{--trả về bảng thông báo mã sinh viên tồn tại--}}
                    Mã sinh viên đã tồn tại
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="inputFullName">Họ và tên<span class="text-danger">*</span></label>
            <input name="full_name" type="text" class="form-control" id="inputFullName"
                   placeholder="Họ và tên" required value="{{$full_name}}">
        </div>
        <div class="form-group">
            <label for="inputCourseName">Khóa</label>
            <input name="course_name" type="text" class="form-control" id="inputCourseName"
                   placeholder="Khóa" value="{{$course_name}}">
        </div>
        <div class="row m-0">
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a type="button" class="ml-2 btn btn-link" href="/api/v1/students/view-list">Hủy</a> {{--trỏ tới danh sách sinh viên--}}
        </div>
    </form>
@endsection