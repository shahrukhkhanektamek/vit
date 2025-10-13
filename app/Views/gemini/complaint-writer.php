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
<style>
	.live_comment h3 {
    margin: 22px 0 0 0;
}
</style>

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
									<li class="breadcrumb-item active" aria-current="page"> Legal Research</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title"> Legal Research</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						
						<?php
							if($role==2) echo view("user/nav"); 
							if(in_array($role,[3,4,5,5])) echo view("partner/nav"); 
						?>
						

						<div class="col-md-7 col-lg-8 col-xl-9">

								

								

								<div class="card">
									<div class="card-body">
										<div class="live_comment">
											<div class="row">

													
													<div class="col-12"><h3>Jurisdiction</h3></div>
													
													<div class="col-6 mt-2">
														<label>State</label>
														<select class="form-control select" id="state">
															<?php $states = $db->table("states")->get()->getResultObject();
															foreach ($states as $key => $value) {
															?>
															   <option value="<?=$value->name ?>"><?=$value->name ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-6 mt-2">
														<label>District</label>
														<input class="form-control"  type="text" id="district" placeholder="District..." id="District" />														
													</div>
													<div class="col-12 mt-2">
														<label>Police Station</label>
														<input class="form-control" id="police-station" type="text" placeholder="e.g., Vasant Kunj Police Station" />
													</div>


													<div class="col-12"><h3>Parties Involved</h3></div>
													<div class="col-6 mt-2">
														<label>Complainant Name</label>
														<input class="form-control" id="complainant-name" type="text" placeholder="" />
													</div>
													<div class="col-6 mt-2">
														<label>Complainant Address</label>
														<input class="form-control" id="complainant-address" type="text" placeholder="" />
													</div>
													<div class="col-6 mt-2">
														<label>Accused Name</label>
														<input class="form-control" id="accused-name" type="text" placeholder="" />
													</div>
													<div class="col-6 mt-2">
														<label>Accused Address</label>
														<input class="form-control" id="accused-address" type="text" placeholder="" />
													</div>


													<div class="col-12"><h3>Incident Details</h3></div>
													<div class="col-6 mt-2">
														<label>Date of Incident</label>
														<input class="form-control" id="date-of-incident" type="date" placeholder="" />
													</div>
													<div class="col-6 mt-2">
														<label>Location of Incident</label>
														<input class="form-control" id="location-of-incident" type="text" placeholder="" />
													</div>
													<div class="col-12">
														<label>Description of Incident</label>
														<textarea class="form-control" id="description-of-incident" rows="5" placeholder="Clearly describe the events as they happened..."></textarea>
													</div>

													
												
												<div class="col-12 mt-2">
													<label style="color: white;">sd</label>
													<button class="btn btn-primary btn_live w-100" id="submit-comment">Generate Complaint</button>
												</div>
											</div>
										</div>
										<div class="hide" style="display:none;" id="output"></div>
									</div>
								</div>

								<div class="card resaponse-area-card">
									<div class="card-body">
										<div class="fcrse_3">													
											<div class="live_chat" id="live_chat">
												<div class="chat1 resaponse-area" id="chat1">
													<pre id="set-res"></pre>
												</div>
											</div>
											
										</div>	
											
									</div>
								</div>
							
								
						

														
							
						</div>


						
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
			







<script>
	
   $(document).on("click", "#submit-comment",(function(e) {
      event.preventDefault();
      submit_comment();
   }));

    const myInput = document.getElementById("comment");
	myInput.addEventListener("keydown", function (event) {
	    if (event.key === "Enter") {
	      submit_comment(); // call your custom function
	    }
	});

   function submit_comment()
   {
   		var comment = $("#comment").val();
   		// if(comment.trim()=='')
   		// 	return false;

   		$("#submit-comment").attr("disabled", true)
   		data_loader("#chat1",1);
   		$(".resaponse-area-card").show();


        // $(".chat1").append(`<div class="me">${(comment)}</div>`);
        $(".chat1").append(`<div class="boat wait"><span class="dot-loader"><span></span><span></span><span></span></span></div>`);
        // $("#comment").val('');
        var div = document.getElementById("live_chat");
  			div.scrollTop = div.scrollHeight;
      
        var form = new FormData();
        
        form.append("comment",comment);
        form.append("state",$("#state").val());
        form.append("district",$("#district").val());
        form.append("police_station",$("#police-station").val());
        form.append("complainant_name",$("#complainant-name").val());
        form.append("complainant_address",$("#complainant-address").val());
        form.append("accused_name",$("#accused-name").val());
        form.append("accused_address",$("#accused-address").val());
        form.append("date_of_incident",$("#date-of-incident").val());
        form.append("location_of_incident",$("#location-of-incident").val());
        form.append("description_of_incident",$("#description-of-incident").val());

        var settings = {
          "url": "<?=$data['actionUrl'] ?>",
          "method": "POST",
          "timeout": 0,
          "processData": false,
          "headers": {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           },
          "mimeType": "multipart/form-data",
          "contentType": false,
          "dataType": "json",
          "data": form
        };
        $.ajax(settings).always(function (response) {
            
   		$("#submit-comment").attr("disabled", false);

   			data_loader("#chat1",0);

            response = admin_response_data_check(response);
            if(response.status==200)
            {
              	$("#set-res").html(`<div class="boat"><pre>${(response.message)}</pre></div>`);
              	$(".wait.boat").remove();
              	var div = document.getElementById("live_chat");
  				div.scrollTop = div.scrollHeight;
            }
        });
   }






</script>




<?=view("web/include/footer"); ?>