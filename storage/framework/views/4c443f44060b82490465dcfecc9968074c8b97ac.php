<?php /*use Illuminate\Pagination\LengthAwarePaginator; */?>
<?php $__env->startSection('content'); ?>
    <h3>Danh sách sinh viên</h3>
    <!-- Search form -->
    <form class="form-inline md-form mr-auto mb-4" onsubmit="/api/students/view-list" method="GET">
        <input name="name" class="form-control mr-sm-2" type="text" placeholder="Họ tên" aria-label="Search"
               value="<?php echo e($name); ?>">
        <input name="id" class="form-control mr-sm-2" type="text" placeholder="MSSV" aria-label="Search"
               value="<?php echo e($id); ?>">
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
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input type="checkbox" name="id[<?php echo e($index); ?>]" value="<?php echo e($student->id); ?>"/></td>
                    <th scope="row"><?php echo e($index); ?> </th> 
                    <td><?php echo e($student->identification_num); ?></td>
                    <td><?php echo e($student->full_name); ?></td>
                    <td><?php echo e($student->course_name); ?></td>
                    <td>
                        <button type="button" class="btn btn-danger float-right" data-toggle="modal"
                                data-target="#btnDeleteItem<?php echo e($student->id); ?>"> 
                            Xóa
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="btnDeleteItem<?php echo e($student->id); ?>" tabindex="-1" role="dialog"
                             aria-labelledby="btnDeleteItem<?php echo e($student->id); ?>Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có muốn xoá sinh viên <?php echo e($student->full_name); ?>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng
                                        </button>
                                        <a href="/api/students/delete?id=<?php echo e($student->id); ?>"
                                           class="btn btn-danger">Xóa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="/api/v1/students/edit-form?id=<?php echo e($student->id); ?>"
                           class="btn btn-success float-right">Sửa</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </form>
    <?php
    $paginator = $students;
    ?>
    <?php if(!empty($paginator)): ?>
        <?php if($paginator->lastPage() > 1): ?>
            <ul class="pagination">
                <li class="<?php echo e(($paginator->currentPage() == 1) ? ' disabled' : ''); ?>">
                    <a style="padding-right: 2px" href="<?php echo e($paginator->url(1)); ?>">Previous</a>
                </li>
                <?php for($i = 1; $i <= $paginator->lastPage(); $i++): ?>
                    <li class="page-item <?php echo e(($paginator->currentPage() == $i) ? ' active' : ''); ?>">
                        <a style="padding: 2px" href="<?php echo e($paginator->url($i)); ?>"><?php echo e($i); ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo e(($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : ''); ?>">
                    <a style="padding-left: 2px" href="<?php echo e($paginator->url($paginator->currentPage()+1)); ?>">Next</a>
                </li>
            </ul>
        <?php endif; ?>
        <Br><br>
        <div>Tổng số sinh viên: <?php echo e($paginator->total()); ?></div>
    <?php endif; ?>
    
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>