<?=view('backend/include/header') ?>

<div class="page-content">
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

        <?php include('profile-card.php') ?>

        <div class="row">

            <form class="row g-3 form_data" action="<?=$data['route'].'/change-password-action'?>" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>

                 <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?=encript(@$row->id)?>">
                
                <!--end col-->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 flex-grow-1"><?=$data['title']?> Change Password</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row g-3">
                                    
                                    

                                    <div class="col-md-4">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" placeholder="" value="" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">ConfirmPassword <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="cpassword" placeholder="" value="" required>
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

    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->







<?=view('backend/include/footer') ?>