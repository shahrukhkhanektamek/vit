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
                        <input type="hidden" name="id" value="<?=encript(@$row->id)?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body frm">
                                        <div class="row gy-3">
                                            <div class="col-lg-4 ">
                                                <label class="form-label" for="product-title-input">Phone</label>
                                                <input type="text" class="form-control" placeholder="Enter Mobile number" name="mobile" value="<?=@$form_data->mobile?>" required>
                                            </div>

                                            <div class="col-lg-4 ">
                                                <label class="form-label" for="product-title-input">WhatsApp Number</label>
                                                <input type="text" class="form-control" placeholder="Enter WhatsApp number" name="whatsapp" value="<?=@$form_data->whatsapp?>" required>
                                            </div>

                                            <div class="col-lg-4 ">
                                                <label class="form-label" for="product-title-input">Email</label>
                                                <input type="text" class="form-control" placeholder="Enter Email address" name="email" value="<?=@$form_data->email?>" required>
                                            </div>

                                            <div class="col-lg-6 ">
                                                <label class="form-label" for="product-title-input">Address</label>
                                                <textarea class="form-control" name="address" required><?=@$form_data->address?></textarea>
                                            </div>

                                            <div class="col-lg-6 ">
                                                <label class="form-label" for="product-title-input">Map Link</label>
                                                <textarea class="form-control" name="location_map" required><?=@$form_data->location_map?></textarea>
                                            </div>

                                            <div class="col-lg-12 ">
                                                <label class="form-label" for="product-title-input">Google Map</label>
                                                <textarea class="form-control" name="google_map" rows="4" required><?=@$form_data->google_map?></textarea>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label" for="product-title-input">Open Time</label>
                                                <input type="text" class="form-control" placeholder="Open Time" name="school_time" value="<?=@$form_data->school_time?>" required>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label" for="product-title-input">Facebook Link</label>
                                                <input type="text" class="form-control" placeholder="#" name="facebook" value="<?=@$form_data->facebook?>" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="product-title-input">Twitter Link</label>
                                                <input type="text" class="form-control" placeholder="#" name="twitter" value="<?=@$form_data->twitter?>" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="product-title-input">Linkedin Link</label>
                                                <input type="text" class="form-control" placeholder="#" name="linkedin" value="<?=@$form_data->linkedin?>" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="product-title-input">Instagram Link</label>
                                                <input type="text" class="form-control" placeholder="#" name="instagram" value="<?=@$form_data->instagram?>" required>
                                            </div>
                                            <div class="col-lg-4 hide">
                                                <label class="form-label" for="product-title-input">Telegram Link</label>
                                                <input type="text" class="form-control" placeholder="#" name="telegram" value="<?=@$form_data->telegram?>" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label" for="product-title-input">Youtube Video Link</label>
                                                <input type="text" class="form-control" placeholder="#" name="youtube" value="<?=@$form_data->youtube?>" required>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                        <div class="text-start mt-3">
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