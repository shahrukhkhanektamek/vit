<?=view('backend/include/header') ?>

<div class="page-content table_page">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0"><?=$data['page_title']?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('/admin')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a ><?=$data['title']?></a></li>
                            <li class="breadcrumb-item active"><?=$data['page_title']?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <form class="row g-3 form_data" action="<?=$data['route'].'/update'?>" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>

             <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?=encript(@$row->id)?>">
            
            <!--end col-->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1"><?=$data['title']?> Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">
                                
                                <div class="col-md-4">
                                    <label class="form-label">Student <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" id="select-all-user" name="user_id" required>
                                        <option value="">Select</option>
                                        <?php  
                                        if(!empty($row))
                                        {
                                            $users = $db->table("users")->where(["id"=>$row->user_id,])->get()->getFirstRow();
                                            if(!empty($users))
                                            {
                                        ?>
                                        <option value="<?=$users->id ?>" selected><?=$users->name.' ('.env('APP_SORT').$users->user_id.')' ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Duration <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="duration" placeholder="" value="<?=@$row->duration?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Semester <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="semester" placeholder="" value="<?=@$row->semester?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Student Id No. <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="student_id_no" placeholder="" value="<?=@$row->student_id_no?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Batch Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="batch_code" placeholder="" value="<?=@$row->batch_code?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Course <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="course" placeholder="" value="<?=@$row->course?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Grade <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="grade" placeholder="" value="<?=@$row->grade?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Place <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="place" placeholder="" value="<?=@$row->place?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Issue Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="issue_date" placeholder="" value="<?=@$row->issue_date?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" id="planStatus" name="status" required>
                                        <option value="1" <?php if(!empty(@$row) && @$row->status==1) echo'selected' ?> >Active</option>
                                        <option value="0" <?php if(!empty(@$row) && @$row->status==0) echo'selected' ?> >Disable</option>
                                    </select>
                                    <div class="invalid-feedback">Please select any on option.</div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">                                
                                <div class="col-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success btn-label"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </form>
        <!--end row-->
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->


<?=view('backend/include/footer') ?>

<script>
$(".required-info").on('click','.trash', function () {
    $(this).closest('.required-cont').remove();
    return false;
});

$(".add-required").on('click', function () {

    let ttm = Date.now();
    
    var requiredcontent = '<div class="row form-row required-cont">' +
        '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
                
                '<div class="col-12 ">' +
                    '<div class="form-group">' +
                        '<label>Required</label>' +
                        '<input type="text" class="form-control" name="document_area[]">' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>' +
        '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="ri-delete-bin-6-line"></i></a></div>' +
    '</div>';
    
    $(".required-info").append(requiredcontent);
    $("#select"+ttm).select2();
    return false;
});
</script>


<script>
$(".faq-info").on('click','.trash', function () {
    $(this).closest('.faq-cont').remove();
    return false;
});

$(".add-faq").on('click', function () {

    let ttm = Date.now();
    
    var faqcontent = '<div class="row form-row faq-cont">' +
        '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
                
                '<div class="col-6 ">' +
                    '<div class="form-group">' +
                        '<label>QSN.</label>' +
                        '<input type="text" class="form-control" name="faqqsn[]">' +
                    '</div>' +
                '</div>' +

                '<div class="col-6 ">' +
                    '<div class="form-group">' +
                        '<label>ANS.</label>' +
                        '<input type="text" class="form-control" name="faqans[]">' +
                    '</div>' +
                '</div>' +


            '</div>' +
        '</div>' +
        '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="ri-delete-bin-6-line"></i></a></div>' +
    '</div>';
    
    $(".faq-info").append(faqcontent);
    $("#select"+ttm).select2();
    return false;
});
</script>


