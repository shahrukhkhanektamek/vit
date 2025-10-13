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
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="" value="<?=@$row->name?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Designation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="designation" placeholder="" value="<?=@$row->designation?>" required>
                                </div>


                                <div class="col-lg-12">
                                    <label class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="message" rows="4" required><?=@$row->message?></textarea>
                                </div>



                                <div class="col-lg-12">
                                    <label class="form-label">Image <span class="text-danger">*</span> <small>If you want to covert .webp file <a href="https://cloudconvert.com/jpg-to-webp" target="_blank">Click to open link</a></small></label>
                                    <div class="col-lg-12">
                                        <input class="form-control upload-single-image" type="file" name="image" data-target="image" accept="image/*" @if(empty($row))  @endif>
                                        <img class="upload-img-view img-thumbnail mt-2 mb-2 image" id="viewer" style="width:auto;height:120px;overflow:hidden;" src="<?=image_check(@$row->image)?>" alt="banner image"/>
                                    </div>
                                </div>

                               


                               
                                <div class="col-md-12">
                                    <label for="planStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" id="planStatus" name="status" data-minimum-results-for-search="Infinity" required>
                                        <option value="1" <?php if(!empty(@$row) && @$row->status==1) echo'selected' ?> >Active</option>
                                        <option value="0" <?php if(!empty(@$row) && @$row->status==0) echo'selected' ?> >Disable</option>
                                    </select>
                                    <div class="invalid-feedback">Please select any on option.</div>
                                </div>
                                <div class="col-12">
                                    <div class="text-start">
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