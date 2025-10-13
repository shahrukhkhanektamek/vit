<?=view('backend/include/header') ?>
<style>
    .live_comment h3 {
    margin: 22px 0 0 0;
}
</style>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?=base_url() ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">       
<link rel="stylesheet" href="<?=base_url() ?>assets/plugins/dropzone/dropzone.min.css">


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

      
            <!--end col-->
            <div class="col-lg-12">


                <div class="card">
                    <div class="card-body">
                        <div class="live_comment">
                            <div class="row">

                                    
                                    <div class="col-12 mt-2">
                                        <label>Document Type</label>
                                        <select class="form-control select" id="document-type">   
                                            <optgroup label="Civil Matters"><option value="Plaint">Plaint</option>
                                               <option value="Written Statement">Written Statement</option>
                                               <option value="Civil Appeal">Civil Appeal</option>
                                               <option value="Execution Petition">Execution Petition</option>
                                               <option value="Affidavit in Evidence">Affidavit in Evidence</option>
                                               <option value="Injunction Application">Injunction Application</option>
                                            </optgroup>
                                            <optgroup label="Criminal Matters"><option value="Bail Application (Anticipatory)">Bail Application (Anticipatory)</option>
                                               <option value="Bail Application (Regular)">Bail Application (Regular)</option>
                                               <option value="Criminal Complaint">Criminal Complaint</option>
                                               <option value="Criminal Appeal">Criminal Appeal</option>
                                               <option value="Quashing Petition (FIR/Chargesheet)">Quashing Petition (FIR/Chargesheet)</option>
                                            </optgroup>
                                            <optgroup label="Family Law">
                                                <option value="Divorce Petition (Mutual Consent)">Divorce Petition (Mutual Consent)</option>
                                                <option value="Divorce Petition (Contested)">Divorce Petition (Contested)</option>
                                                <option value="Child Custody Petition">Child Custody Petition</option>
                                                <option value="Maintenance Application (CrPC 125)">Maintenance Application (CrPC 125)</option>
                                            </optgroup>
                                            <optgroup label="Specific Acts">
                                                <option value="Complaint under Section 138 NI Act">Complaint under Section 138 NI Act</option>
                                                <option value="Consumer Complaint">Consumer Complaint</option>
                                                <option value="RTI Application">RTI Application</option>
                                                <option value="DRT Application">DRT Application</option>
                                            </optgroup>
                                            <optgroup label="Agreements &amp; Affidavits">
                                                <option value="General Affidavit">General Affidavit</option>
                                                <option value="Rental Agreement">Rental Agreement</option>
                                                <option value="Sale Agreement (Movable Property)">Sale Agreement (Movable Property)</option>
                                                <option value="General Power of Attorney">General Power of Attorney</option>
                                                <option value="Legal Notice">Legal Notice</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label>Provide Case Details</label>
                                        <textarea class="form-control" id="comment" rows="5" placeholder="e.g., 'My name is John Doe, son of Richard Doe, resident of 123 Main St, New Delhi. I need a bail application regarding FIR No. 456/2024 at Vasant Kunj police station. The allegations are of theft under section...'"></textarea>
                                    </div>

                                    
                                
                                <div class="col-12 mt-2">
                                    <label style="color: white;">sd</label>
                                    <button class="btn btn-primary btn_live w-100" id="submit-comment">Generate Document</button>
                                </div>
                            </div>
                        </div>
                        <div class="hide" style="display:none;" id="output"></div>
                    </div>
                </div>

                <div class="card resaponse-area-card">
                    <i class="ri-file-copy-line resaponse-area-copy-btn" onclick="copyDivText('set-res')"></i>
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
            <!--end col-->
        
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->



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
        form.append("document_type",$("#document-type").val());
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




<?=view('backend/include/footer') ?>