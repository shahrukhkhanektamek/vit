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
.me, .boat{
    text-align: right;
    margin-bottom: 5px;
    box-shadow: 0px 0px 9px -4px rgba(0, 0, 0, 0.5);
    width: 50%;
    margin: 25px 0 25px auto;
    padding: 5px 10px;
    border-radius: 5px;
}
.boat {
    margin: auto 0 0 0;
    text-align: left;
}
#live_chat {
    overflow: auto;
    padding: 20px 15px;
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
									<li class="breadcrumb-item active" aria-current="page">Ask Ally</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Ask Ally</h2>
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
										<div class="col-xl-12 col-lg-12">
											<div class="right_side">							
												<div class="fcrse_3">
													
													<div class="live_chat" id="live_chat">
														<div class="chat1 resaponse-area" id="chat1">
															
														</div>
													</div>
													<div class="live_comment">
														<div class="row">
															<div class="col-11">
																<input class="form-control" id="comment" type="text" placeholder="Say Something..." />
															</div>
															<div class="col-1">
																<button class="btn btn-primary btn_live"  id="submit-comment"><i class="fa fa-search"></i></button>																
															</div>
														</div>
													</div>
													<div class="hide" style="display:none;" id="output"></div>
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
      // event.preventDefault();
   		console.log("{fasf");
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
   		if(comment.trim()=='')
   			return false;

        $(".chat1").append(`<div class="me">${(comment)}</div>`);
        $(".chat1").append(`<div class="boat wait"><span class="dot-loader"><span></span><span></span><span></span></span></div>`);
        $("#comment").val('');
        var div = document.getElementById("live_chat");
  			div.scrollTop = div.scrollHeight;
      
        var form = new FormData();
        form.append("comment",comment);
        // form.append("id","{{request()->input('id')}}");
        var settings = {
          "url": "<?=($data['route'].'/gemini/ask-ally/action') ?>",
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
            
            response = admin_response_data_check(response);
            if(response.status==200)
            {
              	$(".chat1").append(`<div class="boat">${(response.message)}</div>`);
              	$(".wait.boat").remove();
              	var div = document.getElementById("live_chat");
  				div.scrollTop = div.scrollHeight;
            }
        });
   }






</script>




<?=view("web/include/footer"); ?>