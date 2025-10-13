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

        <form class="row g-3 form_data" action="<?=$data['route']?>/update" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>

            <!-- @csrf -->
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
                                <div class="col-md-3">
                                    <label class="form-label">Page Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="" value="<?=@$row->page_name?>" required>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label">Page Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="slug" placeholder="" value="<?=@$row->slug?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" placeholder="" value="<?=@$row->meta_title?>" >
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Author <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="author" placeholder="" value="<?=@$row->meta_author?>" >
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Keywords <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="keywords" placeholder="" value="<?=@$row->meta_keywords?>" >
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" ><?=@$row->meta_description?></textarea>
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