<?=view("web/include/header"); ?>
<?php 
$role = 0;	
$user_id = 0;	
$user = get_user();
if(!empty($user))
{
	$role = $user->role;
	$user_id = $user->id;
	$user_role = get_role_by_id($user->role);
}
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">    
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<style>
    .bgColor {
    width: 100%;
    height: 150px;
    background-color: #fff4be;
    border-radius: 4px;
    margin-bottom: 30px;
}

.inputFile {
    padding: 5px;
    background-color: #FFFFFF;
    border: #F0E8E0 1px solid;
    border-radius: 4px;
}

.btnSubmit {
    background-color: #696969;
    padding: 5px 30px;
    border: #696969 1px solid;
    border-radius: 4px;
    color: #FFFFFF;
    margin-top: 10px;
}

#uploadFormLayer {
    padding: 20px;
}

input#crop {
    padding: 5px 25px 5px 25px;
    background: lightseagreen;
    border: #485c61 1px solid;
    color: #FFF;
    visibility: hidden;
}

#cropped_img {
    margin-top: 40px;
}

#cropbox {
    max-width: 100%;
    height: auto;
}

</style>

			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Profile Settings</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<!-- Profile Sidebar -->
						<?=view("user/nav"); ?>						
						<!-- / Profile Sidebar -->

						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									
									<!-- Profile Settings Form -->
									<form class="form_data" action="<?=($data['route'].'/update'); ?>" method="post" id="ProfileForm" novalidate >
										<div class="row form-row">
											<div class="col-12 col-md-12">
												<div class="form-group">
													<div class="change-avatar">
														<div class="profile-img">
															<img src="<?=image_check($user->image,'user.png') ?>" alt="User Image">
														</div>
														<div class="upload-img">
															<div class="change-photo-btn">
																<span class="crop-modal-open"><i class="fa fa-upload"></i> Upload Photo</span>
																<!-- <input type="file" class="upload"> -->
															</div>
															<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
														</div>
													</div>
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label>First Name</label>
													<input type="text" class="form-control" value="<?=$user->name ?>" name="name" required>
												</div>
											</div>
											
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label>Email ID</label>
													<input type="email" class="form-control" name="email" value="<?=$user->email?>" required>
												</div>
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label>Mobile</label>
													<input type="number" class="form-control" name="phone" value="<?=$user->phone?>" required>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
												<label>Address</label>
													<input type="text" class="form-control" name="address" value="<?=$user->address?>" required>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Country</label>
													<select class="form-control" id="country" required name="country">
														<option value="">Select Country</option>
														<?php
														$country = $db->table("countries")->where(["id"=>$user->country,])->get()->getFirstRow();
														if(!empty($country)){
														?>
															<option selected value="<?=$country->id ?>"><?=$country->name ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>State</label>
													<select class="form-control" id="state" required name="state">
														<option value="">Select State</option>
														<?php
														$country = $db->table("states")->where(["id"=>$user->state,])->get()->getFirstRow();
														if(!empty($country)){
														?>
															<option selected value="<?=$country->id ?>"><?=$country->name ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>City</label>
													<input type="text" class="form-control" name="city" value="<?=$user->city ?>" required>
												</div>
											</div>

											<div class="col-12 col-md-6">
												<div class="form-group">
													<label>Zip Code</label>
													<input type="text" class="form-control" name="pincode" value="<?=$user->pincode?>" required>
												</div>
											</div>
											
										</div>
										<div class="submit-section">
											<button type="submit" class="btn btn-primary ">Save Changes</button>
										</div>
									</form>
									<!-- /Profile Settings Form -->
									
								</div>
							</div>
						</div>


						
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
			


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        

        <div class="row">
            <div class="col-lg-6" style="margin: 0 auto;">
                <label for="formFile" class="form-label">Select Picture</label>
                <label style="display: block;">
                    <input class="form-control crop-image-upload" type="file" name="image" data-target="image" id="imageUpload" accept="image/*"  required>
                </label>
                <div class="crop-div">
                    <img class="upload-img-view img-thumbnail mt-2 mb-2 image" id="imagePreview"
                    onerror="this.src='{{asset('storage/app/public/upload/user.png')}}'"
                    src="<?=image_check($user->image,'user.png') ?>" alt="banner image"/ style="width: 100%;">
                </div>
            </div>

        </div>
        <!-- end card -->
        


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="cropButton">Crop and Upload</button>
      </div>
    </div>
  </div>
</div>





<script>
$(document).ready(function() {
    var cropper;
    const imagePreview = document.getElementById('imagePreview');

    
    $('.crop-modal-open').on('click', function(e) {
    	$("#exampleModal").addClass('show');
    });
    $('.close-modal').on('click', function(e) {
    	$(".modal").removeClass('show');
    });

    $('#imageUpload').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                
                // Initialize Cropper.js when the image loads
                imagePreview.onload = function() {
                    setTimeout(() => {
                        if (cropper) {
                            cropper.destroy();
                        }
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 1,
                            viewMode: 1,
                            dragMode: 'move',
                            cropBoxResizable: false, // Prevent resizing of the crop box
                            cropBoxMovable: false, 
                        });
                    }, 100);
                };
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle cropping and upload
    $('#cropButton').on('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
               
                width: 300,   // Adjust output width
                height: 300   // Adjust output height
            });
            
            // Convert canvas to data URL and send it to the server
            canvas.toBlob(function(blob) {
                
                
                
                /* Convert data URL to blob */
                function dataURLToBlob(dataURL) {
                    const byteString = atob(dataURL.split(',')[1]);
                    const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
                    const ab = new ArrayBuffer(byteString.length);
                    const ia = new Uint8Array(ab);
                    for (let i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    return new Blob([ab], { type: mimeString });
                }
                
                
                
                const dataURL = canvas.toDataURL('image/jpeg');
                const formData = new FormData();
                formData.append('croppedImage', dataURLToBlob(dataURL), 'cropped_image.jpg');
                
                
                

                
                // const formData = new FormData();
                // formData.append('croppedImage', blob, 'cropped_image.jpg');
                formData.append('id', '<?=$user->id?>');
                
                // Send the cropped image to the server
                $.ajax({
                    url: "<?=($data['route'].'/update-profile-image') ?>",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                   xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                $('#progressBar').css('width', percentComplete + '%');
                                $('#progressText').text(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                     },
                    success: function(response) {
                        loader("hide");
                        response = admin_response_data_check(response);
                        if(response.status==200)
                        {
                            $(".crop-div").html(`
                                <img class="" id="cropbox"
                                src="`+response.data.image+`" alt="banner image" />
                            `);
                            $("#tempimagename").val(response.data.imagename);
                            imageCrop();
                            $(".alert-success").show();
                        }
                        else
                        {
                            error_message(response.message);
                        }
                    },
                    error: function(error) {
                        loader("hide");
                        response = admin_response_data_check(response);
                        if(response.status==200)
                        {
                            $(".crop-div").html(`
                                <img class="" id="cropbox"
                                src="`+response.data.image+`" alt="banner image" />
                            `);
                            $("#tempimagename").val(response.data.imagename);
                            imageCrop();
                            $(".alert-success").show();
                        }
                        else
                        {
                            error_message(response.message);
                        }
                    }
                });
            });
        }
    });
});
</script>



<?=view("web/include/footer"); ?>