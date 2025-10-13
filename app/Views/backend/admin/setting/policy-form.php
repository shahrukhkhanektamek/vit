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
                                        <div class="row">
                                            

                                            
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="product-title-input">Terms & Conditions</label>
                                                <textarea class="form-control" name="terms_policy" required><?=@$form_data->terms_policy?></textarea>
                                                <script>CKEDITOR.replace( 'terms_policy' );</script>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="product-title-input">Privacy Policy </label>
                                                <textarea class="form-control" name="privacy_policy" required><?=@$form_data->privacy_policy?></textarea>
                                                <script>CKEDITOR.replace( 'privacy_policy' );</script>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="product-title-input">Refund Policy </label>
                                                <textarea class="form-control" name="refund_policy" required><?=@$form_data->refund_policy?></textarea>
                                                <script>CKEDITOR.replace( 'refund_policy' );</script>
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