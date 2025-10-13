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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js"></script>
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


												<div class="col-md-12 mt-2">
													<div class="form-group mb-0">
														<div class="drag-area" style="height:200px;width:100%;margin-bottom:10px;"> 
														    <div class="upload-icon">
														    	<p>Drag & drop a PDF here, or click to select a file PDF files only</p>
														      <i class="ri-file-upload-line"></i> 
														    </div>
														    <input type="file" id="pdfUpload" accept=".pdf">
														</div>
													</div>
												</div>
												<div class="col-12 d-none">
													<textarea class="form-control" id="comment" rows="5" placeholder="Paste text here or upload a document above..."></textarea>
												</div>
												
												<div class="col-12 mt-2">
													<label style="color: white;">sd</label>
													<button class="btn btn-primary btn_live w-100" id="submit-comment">Analyze Document</button>
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
   		if(comment.trim()=='')
   			return false;

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
        form.append("Jurisdiction",$("#Jurisdiction").val());
        form.append("ResearchType",$("#ResearchType").val());
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


<script>
	document.getElementById('pdfUpload').addEventListener('change', function(e) {
	    const file = e.target.files[0];
	    if (!file) return;

	    const reader = new FileReader();
	    reader.onload = function(event) {
	        const typedArray = new Uint8Array(event.target.result);

	        pdfjsLib.getDocument(typedArray).promise.then(function(pdf) {
	            let allText = '';

	            const totalPages = pdf.numPages;
	            let pagePromises = [];

	            for (let i = 1; i <= totalPages; i++) {
	                pagePromises.push(
	                    pdf.getPage(i).then(function(page) {
	                        return page.getTextContent().then(function(textContent) {
	                            let pageText = textContent.items.map(item => item.str).join(' ');
	                            allText += pageText + '\n\n';
	                        });
	                    })
	                );
	            }

	            Promise.all(pagePromises).then(function() {
	                $("#comment").val(allText);
	            });
	        });
	    };
	    reader.readAsArrayBuffer(file);
	});

</script>





<?=view("web/include/footer"); ?>