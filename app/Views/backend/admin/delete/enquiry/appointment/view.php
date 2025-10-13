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



                        <!--end col-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Basic Detail</h4>
                                </div>

                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row g-3">
                                            
                                            <div class="col-md-4">
                                                <div class="card card-body m-0">
                                                    <label class="form-label">Name</label>
                                                    <p><?=$row->name?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card card-body m-0">
                                                    <label class="form-label">Email</label>
                                                    <p><?=$row->email?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card card-body m-0">
                                                    <label class="form-label">Mobile</label>
                                                    <p><?=$row->phone?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card card-body m-0">
                                                    <label class="form-label">Subject</label>
                                                    <p><?=$row->subject?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card card-body m-0">
                                                    <label class="form-label">Message</label>
                                                    <p><?=$row->coment?></p>
                                                </div>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->







                   
                    <!--end row-->
                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->

<?=view('backend/include/footer') ?>
