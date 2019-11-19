<?php $__env->startSection('content'); ?> 
<h3>Tạo sinh viên</h3>
<form onsubmit="/api/students/repair-form" method="POST">
    <div class="form-group">
        <label for="inputFullName">Mã số sinh viên<span class="text-danger">*</span></label>
        <input name="identification_num" type="number" class="form-control <?php echo e($isDuplicate ? 'is-invalid' : ''); ?>" id="in" required
               placeholder="Mã số sinh viên" value="<?php echo e($identification_num); ?>">
        <?php if($isDuplicate): ?>
        <div class="invalid-feedback"> 
            Mã sinh viên đã tồn tại
        </div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="inputFullName">Họ và tên<span class="text-danger">*</span></label>
        <input name="full_name" type="text" class="form-control" id="inputFullName"
               placeholder="Họ và tên" required value="<?php echo e($full_name); ?>">
    </div>
    <div class="form-group">
        <label for="inputCourseName">Khóa</label>
        <input name="course_name" type="text" class="form-control" id="inputCourseName"
               placeholder="Khóa" value="<?php echo e($course_name); ?>">
    </div>
    <div class="row m-0">
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a type="button" class="ml-2 btn btn-link" href="/api/students/view-list">Hủy</a> 
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>