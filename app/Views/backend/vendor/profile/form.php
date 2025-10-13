<?=view('backend/include/header') ?>

<div class="page-content table_page">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Account Profile</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="<?=base_url('admin') ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <p><small>Upload your showroom image to show on website</small></p>
                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                            <img 
                                            src="<?=image_check(@$row->image,'user.png')?>" loading="lazy" class="img-thumbnail material-shadow update-profile-image-img" alt="user-profile-image">
                                            <label class="avatar-xs p-0 profile-photo-edit">
                                                <form class="row g-3 form_data" action="<?=$data['route'].'/update-profile-image'?>" method="post" enctype="multipart/form-data" id="form_data_submit_profile" novalidate>
                                                    <input  type="file" class="profile-img-file-input update-profile-image " accept="image/*" name="image">
                                                    <button type="submit" id="submit_profile_image_btn" style="display:none;">fsa</button>
                                                </form>
                                                <span for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                        <h5 class="fs-16 mb-1"><?=@$row->company_name?></h5>
                                        <p class="text-muted mb-0"><?=@$row->area?></p>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-lg-9">

                        <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0 flex-grow-1">Profile</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="live-preview">
                                        <form class="row g-3 form_data" action="<?=$data['route']?>/update" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>
                                            
                                            <div class="col-md-4">
                                                <label class="form-label">Showroom Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="company_name" placeholder="" value="<?=@$row->company_name?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">City <span class="text-danger">*</span></label>
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
                                                <label class="form-label">Area <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="area" placeholder="" value="<?=@$row->area?>" required>
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

                                            <div class="col-md-4">
                                                <label for="name" class="form-label">Dealer Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="i.e Giannina" value="<?=$row->name?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="mobile" class="form-label">Dealer Contact <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="mobile" name="mobile" placeholder="i.e 1234567890" value="<?=$row->phone?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="email" class="form-label">Dealer Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="i.e example@gmail.com" value="<?=$row->email?>" required>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <label class="form-label">Authorized Person <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="authorized_person" placeholder="" value="<?=@$row->authorized_person?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Authorized Contact <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="person_contact" placeholder="" value="<?=@$row->person_contact?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Sales Contact <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="sales_contact" placeholder="" value="<?=@$row->sales_contact?>" required>
                                            </div>
                                            
                                            
                                            <div class="col-md-4">
                                                <label class="form-label">GST No <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-uppercase" name="gst" placeholder="" value="<?=@$row->gst?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">PAN No Firm <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-uppercase" name="pan" placeholder="" value="<?=@$row->pan?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Udyam No <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-uppercase" name="udyam" placeholder="" value="<?=@$row->udyam?>" required>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <label class="form-label">Workshop Address <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="workshop_address" placeholder="" value="<?=@$row->workshop_address?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Service Contact No <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="service_contact" placeholder="" value="<?=@$row->service_contact?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Spares & Accessories Contact <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="spares_accessories_contact" placeholder="" value="<?=@$row->spares_accessories_contact?>" required>
                                            </div>
                                            
                                            
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button class="btn btn-primary" type="submit">Update Profile</button>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-4 col-6 hide">
                                                <label for="gender" class="form-label">Sex <span class="text-danger">*</span></label>
                                                <select class="form-select" id="gender" name="gender" >
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                    <option value="3">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6 hide">
                                                <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="age" name="age" placeholder="i.e 32" value="<?=$row->age?>" >
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->


<script>
$(".update-profile-image").on('change', function(){
  var files = [];
  var j=1;
  var upload_div = "update-profile-image-img";
  var name = $(this).data('name');
  $( "."+upload_div ).empty();
    for (var i = 0; i < this.files.length; i++)
    {
        if (this.files && this.files[i]) 
        {
            var reader = new FileReader();
            reader.onload = function (e) {
            $('.'+upload_div).attr("src",e.target.result);
            $("#submit_profile_image_btn").trigger("click");
            j++;
        }
        reader.readAsDataURL(this.files[i]);
    }
  }      
});
</script>
<?=view('backend/include/footer') ?>