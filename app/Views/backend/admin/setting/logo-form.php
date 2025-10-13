<?=view('backend/include/header') ?>
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div
                                class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0"><?=$data['page_title']?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="<?=base_url('/admin')?>">Home</a></li>
                                        <li class="breadcrumb-item active"><?=$data['page_title']?>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <form class="needs-validation form_data" action="<?=$data['route']?>" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>
                        <!-- @csrf -->
                        <input type="hidden" name="id" value="<?=decript(@$row->id)?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body frm">
                                        <div class="row">
                                            
                                            <div class="col-lg-12">
                                                <label class="form-label" for="product-title-input">Company Name</label>
                                                <input type="text" class="form-control" placeholder="Company Name" name="company_name" value="<?=@$form_data->company_name?>" required>
                                            </div>

                                            <div class="col-lg-6">
                                                <label class="form-label" for="product-title-input">Logo <small>If you want to covert .webp file <a href="https://cloudconvert.com/jpg-to-webp" target="_blank">Click to open link</a></small></label>

                                                <div class="col-lg-12">
                                                    <input class="form-control upload-single-image" type="file" name="logo_image" data-target="logo_image" accept="image/webp">
                                                    <img class="upload-img-view img-thumbnail mt-2 mb-2 logo_image" id="viewer"
                                                    onerror="this.src='<?=base_url('upload/default.jpg')?>'"
                                                    src="<?=base_url('upload/')?>/<?=@$form_data->logo_image?>" alt="banner image"/>
                                                </div>
                                            </div>
                                            

                                            <div class="col-lg-6">
                                                <label class="form-label" for="product-title-input">Favicon <small>If you want to covert .webp file <a href="https://cloudconvert.com/jpg-to-webp" target="_blank">Click to open link</a></small></label>

                                                <div class="col-lg-12">
                                                    <input class="form-control upload-single-image" type="file" name="favicon_image" data-target="favicon_image" accept="image/webp">
                                                    <img class="upload-img-view img-thumbnail mt-2 mb-2 favicon_image" id="viewer"
                                                    onerror="this.src='<?=base_url('upload/default.jpg')?>'"
                                                    src="<?=base_url('upload/')?>/<?=@$form_data->favicon_image?>" alt="banner image"/>
                                                </div>
                                            </div>

                                            
                                            

                                        </div>
                                        <!-- end card -->
                                        <div class="text-center mt-2 mb-3">
                                            <button type="submit" class="btn btn-success w-sm">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                    </form>
                </div>
            </div>
<?=view('backend/include/footer') ?>