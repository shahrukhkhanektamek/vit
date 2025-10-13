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
                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                            <img 
                                            src="<?=image_check(@$row->image,'user.png')?>" loading="lazy" class="rounded-circle avatar-xl img-thumbnail  material-shadow update-profile-image-img" alt="user-profile-image">
                                            <label class="avatar-xs p-0 rounded-circle profile-photo-edit">
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
                                        <h5 class="fs-16 mb-1"><?=$row->name?></h5>
                                        <p class="text-muted mb-0">Founder</p>
                                        <p class="text-muted mb-0"><?=gender($row->gender)?></p>
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
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="i.e Giannina" value="<?=$row->name?>" required>
                                                <div class="invalid-feedback">Please provide a valid name.</div>
                                            </div>
                                            <!--<div class="col-md-6">-->
                                            <!--    <label for="userldesignation" class="form-label">Designation</label>-->
                                            <!--    <input type="text" class="form-control" id="userldesignation" name="userldesignation" placeholder="i.e Founder" required>-->
                                            <!--    <div class="invalid-feedback">Please provide a valid last name.</div>-->
                                            <!--</div>-->
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <label for="gender" class="form-label">Sex <span class="text-danger">*</span></label>
                                                <select class="form-select" id="gender" name="gender" required>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="3">Other</option>
                                                </select>
                                                <div class="invalid-feedback">Please enter sex</div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="mobile" class="form-label">Phone number <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="mobile" name="mobile" placeholder="i.e 1234567890" value="<?=$row->phone?>" required>
                                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="i.e example@gmail.com" value="<?=$row->email?>" required>
                                                <div class="invalid-feedback">Please provide a valid email address.</div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button class="btn btn-primary" type="submit">Update Profile</button>
                                                </div>
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