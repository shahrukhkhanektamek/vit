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

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?=base_url() ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">		
	<link rel="stylesheet" href="<?=base_url() ?>assets/plugins/dropzone/dropzone.min.css">
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Kyc Update</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Kyc Update</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<?=view("partner/nav"); ?>

						<div class="col-md-7 col-lg-8 col-xl-9">

							<div class="col-md-12">
								  <?php if($user->kyc_step==1){?>
					              <div class="alert alert-success show" role="alert"><strong>Success</strong> - Your Kyc Is Approved. You can change your kyc.
					              </div>
					              <?php }else if($user->kyc_step==0){ ?>										              
					              <div class="alert alert-info show" role="alert"><strong>Information</strong> - Update Your Kyc  
					              </div>

					              <?php }else if($user->kyc_step==2){ ?>
					              <div class="alert alert-info show" role="alert"><strong>Information</strong> - Your Kyc Is Under Review
					              </div>
					              <?php }else if($user->kyc_step==3){ ?>
					              <div class="alert alert-danger show" role="alert"><strong>Warning</strong> - Your Kyc Rejected!
					              </div>
					              <?php } ?>
							</div>

							<form class="form_data" action="<?=($data['route'].'/update'); ?>" method="post" id="ProfileForm" novalidate >
								
								
								<!-- About Me -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">About Me</h4>
										<div class="form-group mb-0">
											<textarea class="form-control" rows="5" name="about"><?=@$user->about ?></textarea>
										</div>
									</div>
								</div>
								<!-- /About Me -->
								
								

								<!-- Bank Details -->
								<div class="card contact-card">
									<div class="card-body">
										<h4 class="card-title">Bank Details</h4>
										<div class="row form-row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Your Name as per Bank Account</label>
													<input type="text" class="form-control" name="bank_holder_name" value="<?=@$kyc->bank_holder_name ?>" value="<?=@$kyc->bank_holder_name ?>" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Your Nomani Name</label>
													<input type="text" class="form-control" name="nomani" value="<?=@$kyc->nomani ?>" >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">IFSC</label>
													<input type="text" class="form-control" name="ifsc" value="<?=@$kyc->ifsc ?>" >
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Bank Name</label>
													<input type="text" class="form-control" name="bank_name" value="<?=@$kyc->bank_name ?>" >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Account Number</label>
													<input type="text" class="form-control" name="account_number" value="<?=@$kyc->account_number ?>" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Account Type</label>
													<select class="select" name="account_type" >
										                <option value="0" >Select Type</option>
										                <option value="Saving" <?php if(@$kyc->account_type=='Saving') echo'selected'; ?> >Saving</option>
										                <option value="Current" <?php if(@$kyc->account_type=='Current') echo'selected'; ?>>Current</option>
										            </select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">PAN Card</label>
													<input type="text" class="form-control" name="pan" value="<?=@$kyc->pan ?>" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Bank Registered Mobile</label>
													<input type="number" class="form-control" name="rg_mobile" value="<?=@$kyc->rg_mobile ?>" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Bank Registered Email</label>
													<input type="text" class="form-control" name="rg_email" value="<?=@$kyc->rg_email ?>">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="control-label">Address</label>
													<input type="text" class="form-control" name="address" value="<?=@$kyc->address ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Bank Passbook Image</label>
													<?php
			                                             $file_data = array(
			                                                 "position"=>1,
			                                                 "columna_name"=>"passbook_image",
			                                                 "multiple"=>false,
			                                                 "accept"=>'image/*',
			                                                 "col"=>"col-md-12",
			                                                 "alt_text"=>"none",
			                                                 "row"=>@$kyc,
			                                             );
			                                        ?>
			                                        <?=view('upload-multiple/index',compact('file_data','db','data'))?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">PanCard Image</label>
													<?php
			                                             $file_data = array(
			                                                 "position"=>2,
			                                                 "columna_name"=>"pancard_image",
			                                                 "multiple"=>false,
			                                                 "accept"=>'image/*',
			                                                 "col"=>"col-md-12",
			                                                 "alt_text"=>"none",
			                                                 "row"=>@$kyc,
			                                             );
			                                        ?>
			                                        <?=view('upload-multiple/index',compact('file_data','db','data'))?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Aadhar Front Image</label>
													<?php
			                                             $file_data = array(
			                                                 "position"=>3,
			                                                 "columna_name"=>"aadharfront_image",
			                                                 "multiple"=>false,
			                                                 "accept"=>'image/*',
			                                                 "col"=>"col-md-12",
			                                                 "alt_text"=>"none",
			                                                 "row"=>@$kyc,
			                                             );
			                                        ?>
			                                        <?=view('upload-multiple/index',compact('file_data','db','data'))?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Aadhar Back Image</label>
													<?php
			                                             $file_data = array(
			                                                 "position"=>4,
			                                                 "columna_name"=>"aadharback_image",
			                                                 "multiple"=>false,
			                                                 "accept"=>'image/*',
			                                                 "col"=>"col-md-12",
			                                                 "alt_text"=>"none",
			                                                 "row"=>@$kyc,
			                                             );
			                                        ?>
			                                        <?=view('upload-multiple/index',compact('file_data','db','data'))?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Bank Details -->

								

								
								<!-- Institution Info -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Info</h4>
										
									<?php if($role==3){ ?>
										<!-- advocate -->
										<div class="row form-row">
											<div class="col-md-4">
												<div class="form-group">
													<label>Bar Council Registration Number</label>
													<input type="text" class="form-control" name="bar_number" value="<?=@$kyc->bar_number ?>" >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Enrollment Year</label>
													<input type="text" class="form-control" name="enrollment_year" value="<?=@$kyc->enrollment_year ?>" >
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Practicing Court(s)</label>
													<input type="text" class="form-control" name="practicing_court" value="<?=@$kyc->practicing_court ?>">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Specialization </label>
													<select class="select" name="specialization[]" multiple >
														<option value="">Select</option>
														<?php
														$list = $db->table("service")->where(["status"=>1,"service_type"=>2,])->get()->getResultObject();
														foreach ($list as $key => $value) {
														$selected = '';
														if(!empty($partner_specializations))
														{
															if(in_array($value->id, $partner_specializations)) $selected = 'selected';
														}
														?>
															<option value="<?=$value->id ?>" <?=$selected ?> ><?=$value->name ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Services </label>
													<select class="select" name="service[]" multiple >
														<option value="">Select</option>
														<?php
														$list = $db->table("service")->where(["status"=>1,"service_type"=>1,])->get()->getResultObject();
														foreach ($list as $key => $value) {
														$selected = '';
														if(!empty($partner_services))
														{
															if(in_array($value->id, $partner_services)) $selected = 'selected';
														}
														?>
															<option value="<?=$value->id ?>" <?=$selected ?> ><?=$value->name ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>License Upload</label>
													<?php
			                                             $file_data = array(
			                                                 "position"=>5,
			                                                 "columna_name"=>"license",
			                                                 "multiple"=>false,
			                                                 "accept"=>'image/*',
			                                                 "col"=>"col-md-2",
			                                                 "alt_text"=>"none",
			                                                 "row"=>@$kyc,
			                                             );
			                                        ?>
			                                        <?=view('upload-multiple/index',compact('file_data','db','data'))?>
												</div>
											</div>
										</div>
									<?php } ?>
									<?php if($role==4){ ?>
										<!-- CA -->
										<div class="row form-row">
											<div class="col-md-6">
												<div class="form-group">
													<label>ICAI Membership Number</label>
													<input type="text" class="form-control" name="membership_number" value="<?=@$kyc->membership_number ?>" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Firm Name</label>
													<input type="text" class="form-control" name="firm_name" value="<?=@$kyc->firm_name ?>">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Certificate Upload</label>
													<?php
			                                             $file_data = array(
			                                                 "position"=>6,
			                                                 "columna_name"=>"certificate",
			                                                 "multiple"=>false,
			                                                 "accept"=>'image/*',
			                                                 "col"=>"col-md-2",
			                                                 "alt_text"=>"none",
			                                                 "row"=>@$kyc,
			                                             );
			                                        ?>
			                                        <?=view('upload-multiple/index',compact('file_data','db','data'))?>
												</div>
											</div>
										</div>
									<?php } ?>


									<?php if($role==5){ ?>
										<!-- Adviser  -->
										<div class="row form-row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Expertise Area</label>
													<select class="select" name="expertise[]" multiple >
														<option value="">Select</option>
														<?php
														$list = $db->table("service")->where(["status"=>1,"service_type"=>3,])->get()->getResultObject();
														foreach ($list as $key => $value) {
														$selected = '';
														if(!empty($partner_expertises))
														{
															if(in_array($value->id, $partner_expertises)) $selected = 'selected';
														}
														?>
															<option value="<?=$value->id ?>" <?=$selected ?> ><?=$value->name ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Certification Details</label>
													<select class="select" name="certification[]" multiple >
														<option value="">Select</option>
														<?php
														$list = $db->table("certification")->where(["status"=>1,])->get()->getResultObject();
														foreach ($list as $key => $value) {
														$selected = '';
														if(!empty($partner_certifications))
														{
															if(in_array($value->id, $partner_certifications)) $selected = 'selected';
														}
														?>
															<option value="<?=$value->id ?>" <?=$selected ?> ><?=$value->name ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Certificate Upload</label>
													<?php
			                                             $file_data = array(
			                                                 "position"=>7,
			                                                 "columna_name"=>"certificate",
			                                                 "multiple"=>false,
			                                                 "accept"=>'image/*',
			                                                 "col"=>"col-md-2",
			                                                 "alt_text"=>"none",
			                                                 "row"=>@$kyc,
			                                             );
			                                        ?>
			                                        <?=view('upload-multiple/index',compact('file_data','db','data'))?>
												</div>
											</div>
										</div>
									<?php } ?>


									</div>
								</div>
								<!-- /Institution Info -->
								
								<!-- Pricing -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Appointment Pricing</h4>										
										<div class="form-group mb-0">
											<div id="pricing_select">
												<div class="custom-control custom-radio custom-control-inline">
													<input type="number" class="form-control" name="appointment_amount" value="<?=@$kyc->appointment_amount ?>"  placeholder="20">
												</div>
											</div>
										</div>										
									</div>
								</div>
								<!-- /Pricing -->

								<!-- Pricing -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Experience</h4>										
										<div class="form-group mb-0">
											<div id="pricing_select">
												<div class="custom-control custom-radio custom-control-inline">
													<input type="number" class="form-control" name="experience" value="<?=@$kyc->experience ?>"  placeholder="20">
												</div>
											</div>
										</div>										
									</div>
								</div>
								<!-- /Pricing -->
								
								
							 
								<!-- Education -->
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Education</h4>
										<div class="education-info">
											
								<?php echo view('upload-multiple/education',compact('row','db','data','partner_educations','partner_education')); ?>



										</div>
										<div class="add-more">
											<a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
										</div>
									</div>
								</div>
								<!-- /Education -->
							
															
							
								
								<div class="submit-section submit-btn-bottom">
									<button type="submit" class="btn btn-primary">Save Changes</button>
								</div>
							</form>
							
						</div>


						
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
			





<script>

// Education Add More
	
    $(".education-info").on('click','.trash', function () {
		$(this).closest('.education-cont').remove();
		return false;
    });

    $(".add-education").on('click', function () {

    	let ttm = Date.now();
		
		var educationcontent = '<div class="row form-row education-cont">' +
			'<div class="col-12 col-md-10 col-lg-11">' +
				'<div class="row form-row">' +
					'<div class="col-12 col-md-6 col-lg-4">' +
						'<div class="form-group">' +
							'<label>Degree</label>' +
							`<select class="select" name="education[]" id="select${ttm}"><option value="">Select</option>
							<?php
							$list = $db->table("education")->where(["status"=>1,])->get()->getResultObject();
							foreach ($list as $key => $value) {
							?>
								<option value="<?=$value->id ?>" ><?=$value->name ?></option>
							<?php } ?>
							</select>` +
						'</div>' +
					'</div>' +
					'<div class="col-12 col-md-6 col-lg-4">' +
						'<div class="form-group">' +
							'<label>College/Institute</label>' +
							'<input type="text" class="form-control" name="collage[]">' +
						'</div>' +
					'</div>' +
					'<div class="col-12 col-md-6 col-lg-4">' +
						'<div class="form-group">' +
							'<label>Year of Completion</label>' +
							'<input type="text" class="form-control" name="year_complete[]">' +
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>' +
			'<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
		'</div>';
		
        $(".education-info").append(educationcontent);
        $("#select"+ttm).select2();
        return false;
    });
	
	// Experience Add More
	
    $(".experience-info").on('click','.trash', function () {
		$(this).closest('.experience-cont').remove();
		return false;
    });

    $(".add-experience").on('click', function () {
		
		var experiencecontent = '<div class="row form-row experience-cont">' +
			'<div class="col-12 col-md-10 col-lg-11">' +
				'<div class="row form-row">' +
					'<div class="col-12 col-md-6 col-lg-4">' +
						'<div class="form-group">' +
							'<label>Hospital Name</label>' +
							'<input type="text" class="form-control">' +
						'</div>' +
					'</div>' +
					'<div class="col-12 col-md-6 col-lg-4">' +
						'<div class="form-group">' +
							'<label>From</label>' +
							'<input type="text" class="form-control">' +
						'</div>' +
					'</div>' +
					'<div class="col-12 col-md-6 col-lg-4">' +
						'<div class="form-group">' +
							'<label>To</label>' +
							'<input type="text" class="form-control">' +
						'</div>' +
					'</div>' +
					'<div class="col-12 col-md-6 col-lg-4">' +
						'<div class="form-group">' +
							'<label>Designation</label>' +
							'<input type="text" class="form-control">' +
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>' +
			'<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
		'</div>';
		
        $(".experience-info").append(experiencecontent);
        return false;
    });	

</script>




<?=view("web/include/footer"); ?>