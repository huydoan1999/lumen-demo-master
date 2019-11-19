@extends('layouts.app')
<?php /*use Illuminate\Pagination\LengthAwarePaginator; */?>
@section('content')
    <h3>Danh sách sinh viên</h3>
    <!-- Search form -->
    <form class="form-inline md-form mr-auto mb-4" onsubmit="/api/students/view-list" method="GET">
        <input name="name" class="form-control mr-sm-2" type="text" placeholder="Họ tên" aria-label="Search"
               value="{{$name}}">
        <input name="id" class="form-control mr-sm-2" type="text" placeholder="MSSV" aria-label="Search"
               value="{{$id}}">
        <button type="submit" class="btn aqua-gradient btn-rounded btn-sm my-0">Search</button>
    </form>
    <form onsubmit="/api/students/delete" method="GET">
        <a href="/api/v1/students/create-form" class="float-right mb-2 btn btn-primary">Thêm</a>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">MSSV</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Khóa</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td><input type="checkbox" name="id[{{$index}}]" value="{{$student->id}}"/></td>
                    <th scope="row">{{$index}} </th> {{-- $index....???????????--}}
                    <td>{{$student->identification_num}}</td>
                    <td>{{$student->full_name}}</td>
                    <td>{{$student->course_name}}</td>
                    <td>
                        <button type="button" class="btn btn-danger float-right" data-toggle="modal"
                                data-target="#btnDeleteItem{{$student->id}}"> {{--$student->id ....?????--}}
                            Xóa
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="btnDeleteItem{{$student->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="btnDeleteItem{{$student->id}}Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có muốn xoá sinh viên {{$student->full_name}}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng
                                        </button>
                                        <a href="/api/students/delete?id={{$student->id}}"
                                           class="btn btn-danger">Xóa</a>{{--trỏ tới route xoá với method get đồng thời trả về biến $student->id cho controller delete--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="/api/v1/students/edit-form?id={{$student->id}}"
                           class="btn btn-success float-right">Sửa</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
    <?php
    $paginator = $students;
    ?>
    @if(!empty($paginator))
        @if ($paginator->lastPage() > 1)
            <ul class="pagination">
                <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                    <a style="padding-right: 2px" href="{{ $paginator->url(1) }}">Previous</a>
                </li>
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        <a style="padding: 2px" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                    <a style="padding-left: 2px" href="{{ $paginator->url($paginator->currentPage()+1) }}">Next</a>
                </li>
            </ul>
        @endif
        <Br><br>
        <div>Tổng số sinh viên: {{$paginator->total()}}</div>
    @endif
    {{--<nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#--}}{{--{{ $student->link() }}--}}{{--">Next</a></li>
        </ul>
    </nav>--}}
    {{--@foreach ($products as $product)
         {{ $product->product_name}}
    @endforeach
    {{ $products->links() }}--}}
@endsection
