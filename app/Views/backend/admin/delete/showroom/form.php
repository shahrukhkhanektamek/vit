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
                                


                                <div class="col-md-4">
                                    <label class="form-label">Showroom Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="company_name" placeholder="" value="<?=@$row->company_name?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Showroom City <span class="text-danger">*</span></label>
                                    <select class="" name="city" id="select-city" required>
                                        <option value="">Select City</option>
                                        <?php
                                            $client_logo = $db->table('city')->where(["id"=>@$row->city,])->get()->getFirstRow();
                                            if(!empty($client_logo)) {
                                        ?>
                                            <option value="<?=$client_logo->id ?>" selected ><?=$client_logo->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Showroom Area <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="area" placeholder="" value="<?=@$row->area?>" required>
                                </div>
                                
                                
                                
                                <div class="col-md-4">
                                    <label class="form-label">Dealer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="" value="<?=@$row->name?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Dealer Contact <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="phone" placeholder="" value="<?=@$row->phone?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Dealer Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="" value="<?=@$row->email?>" required>
                                </div>

                                
                                

                                <div class="col-md-12">
                                    <label class="form-label">Available Brands <span class="text-danger">*</span></label>
                                    <select class="" name="brand[]" required multiple>
                                        <option value="">Select Brand</option>
                                        <?php
                                            $cateList = $db->table('client_logo')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(!empty($row))
                                                {
                                                    $oldBtand = json_decode($row->brand);
                                                    if(!empty($oldBtand))
                                                    {
                                                        if(in_array($value->id, $oldBtand)) $selected = 'selected';
                                                    }
                                                }
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                


                           <?php if(empty($row)){ ?>
                                <div class="col-md-4">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="password" placeholder="" value="<?=@$row->password?>" required>
                                </div>
                           <?php } ?>


                           <?php if(!empty($row)){ ?>
                                    <div class="col-md-4">
                                        <label class="form-label">Authorized Person <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="authorized_person" placeholder="" value="<?=@$row->authorized_person?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Person Contact <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="person_contact" placeholder="" value="<?=@$row->person_contact?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Sales Contact <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="sales_contact" placeholder="" value="<?=@$row->sales_contact?>" required>
                                    </div>
                                    

                                    <div class="col-md-4">
                                        <label class="form-label">GST No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="gst" placeholder="" value="<?=@$row->gst?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">PAN No Firm <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="pan" placeholder="" value="<?=@$row->pan?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Udyam No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="udyam" placeholder="" value="<?=@$row->udyam?>" required>
                                    </div>
                                    
                                    

                                    <div class="col-md-4">
                                        <label class="form-label">Workshop Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="workshop_address" placeholder="" value="<?=@$row->workshop_address?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Service Contact No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="service_contact" placeholder="" value="<?=@$row->service_contact?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Spares & Accessories Contact <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="spares_accessories_contact" placeholder="" value="<?=@$row->spares_accessories_contact?>" required>
                                    </div>
                                <?php } ?>
                              






                                <div class="col-md-6 hide">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="slug" placeholder="" value="<?=@$row->slug?>" >
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