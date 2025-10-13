<?=view('backend/include/header') ?>

        
        <div class="page-content">
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







                <?php include('profile-card.php') ?>






               
                    <div class="row mt-4">
                                

                        
                        

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <a href="<?=$data['route'].'/edit/'.encript($row->id)?>">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-edit text-success"></i>
                                            </span>                                                
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Edit Profile Detail</p>
                                            </div>
                                        </div>      
                                    </a>                                  
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <a href="<?=$data['route'].'/change-password/'.encript($row->id)?>">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-hide text-success"></i>
                                            </span>                                                
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Change Username password</p>
                                            </div>
                                        </div>      
                                    </a>                                  
                                </div>
                            </div>
                        </div>


                  

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <a href="<?=$data['route'].'/login-history'.'?id='.encript($row->id)?>">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="ri-login-box-line text-success"></i>
                                            </span>                                                
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Login History</p>
                                            </div>
                                        </div>      
                                    </a>                                  
                                </div>
                            </div>
                        </div>
                  

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <a href="<?=base_url(route_to('lead-enquiry.list')).'?partner-id='.encript($row->id)?>">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="ri-list-check text-success"></i>
                                            </span>                                                
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Lead History</p>
                                            </div>
                                        </div>      
                                    </a>                                  
                                </div>
                            </div>
                        </div>
                      
                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <a >
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-envelope text-success"></i>
                                            </span>                                                
                                        </div>                                                    
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Send Password On Mail</p>
                                            </div>
                                        </div>      
                                        <button class="btn btn-success" id="send_password">Send</button>
                                    </a>                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <a >
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-block text-success"></i>
                                            </span>                                                
                                        </div>                                                    
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Account Block/Unblock</p>
                                            </div>
                                        </div>      
                                        <button class="btn btn-success block_unblock block-button">Block</button>
                                        <button class="btn btn-success block_unblock unblock-button">Unblock</button>
                                    </a>                                  
                                </div>
                            </div>
                        </div>


                        
                        
                        
                    </div>




            </div>
        </div>
           

<?=view('backend/include/footer') ?>

<div class="modal fade zoomIn" id="assignPakcageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">

                <div class="col-lg-12">
                    <label class="form-label" for="product-title-input">Select Year To Assign</label>
                    <select class="form-select mb-3" id="assignYear">
                        <option value="">Select Year</option>
                        <option value="1">1 Year</option>
                        <option value="2">2 Years</option>
                        <option value="3">3 Years</option>
                        <option value="4">4 Years</option>
                        <option value="5">5 Years</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <label class="form-label" for="product-title-input">Select Transaction Status</label>
                    <select class="form-select mb-3" id="assignTransaction">
                        <option value="">Select Transaction Status</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <label class="form-label" for="product-title-input">Select India/International</label>
                    <select class="form-select mb-3" id="paymentType">
                        <option value="">Select India/International</option>
                        <option value="1">India</option>
                        <option value="2">International</option>
                    </select>
                </div>

                <div class="mt-2 text-center">
                    
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-success assign-now">Assign Now</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade zoomIn" id="assignPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body row">

                <div class="col-lg-6">
                    <label class="form-label mt-0 mb-0" for="product-title-input">Select Post Type</label>
                    <select class="form-select mb-3" id="postType">
                        <option value="">Select Post Type</option>
                        <option value="1">Video</option>
                        <option value="2">Audio</option>
                        <option value="3">Image</option>
                        <option value="4">PDF</option>
                        <option value="5">Article</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <label class="form-label mt-0 mb-0" for="product-title-input">Select Post To Assign</label>
                    <select class="form-select mb-3" id="search-post">
                        <option value="">Select Post</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <label class="form-label mt-2 mb-0" for="product-title-input">Select Transaction Status</label>
                    <select class="form-select mb-3" id="assignTransaction2">
                        <option value="">Select Transaction Status</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <label class="form-label mt-2 mb-0" for="product-title-input">Select India/International</label>
                    <select class="form-select mb-3" id="paymentType2">
                        <option value="">Select India/International</option>
                        <option value="1">India</option>
                        <option value="2">International</option>
                    </select>
                </div>

                <div class="mt-2 text-center">
                    
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-success assign-post-now">Assign Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
  







    <!-- Start Include Script -->
    @include('admin.headers.mainjs')
    <!-- End Include Script -->

    <!-- leaderboard_show_hide -->

    <script>


        $(document).on("click", ".assign-pakcage-modal",(function(e) {
            event.preventDefault();
            $("#assignPakcageModal").modal("show");
        }));
        $(document).on("click", ".assign-now",(function(e) {
          loader("show");
            var form = new FormData();
            form.append("id","{{Crypt::encryptString($row->id)}}");
            form.append("year",$("#assignYear").val());
            form.append("transaction_status",$("#assignTransaction").val());
            form.append("payment_type",$("#paymentType").val());
            var settings = {
              "url": "{{$data['back_btn']}}/package-assing-action",
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
                loader("hide");
                response = admin_response_data_check(response);
            });
       }));


        $(document).on("click", ".assign-post-modal",(function(e) {
            event.preventDefault();
            $("#assignPostModal").modal("show");
        }));
        $(document).on("click", ".assign-post-now",(function(e) {
          loader("show");
            var form = new FormData();
            form.append("id","{{Crypt::encryptString($row->id)}}");
            form.append("post_id",$("#search-post").val());
            form.append("post_type",$("#postType").val());
            form.append("transaction_status",$("#assignTransaction2").val());
            form.append("payment_type",$("#paymentType2").val());
            var settings = {
              "url": "{{$data['back_btn']}}/post-assing-action",
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
                loader("hide");
                response = admin_response_data_check(response);
            });
       }));


        $(document).on("click", "#send_password",(function(e) {
          loader("show");
            var form = new FormData();
            form.append("user_id","{{Crypt::encryptString($row->id)}}");
            var settings = {
              "url": "{{$data['back_btn']}}/send_password",
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
                loader("hide");
                response = admin_response_data_check(response);
            });
       }));
        $(document).on("click", ".block_unblock",(function(e) {
          loader("show");
            var form = new FormData();
            form.append("user_id","<?=encript($row->id)?>");
            var settings = {
              "url": "<?=$data['route']?>/block_unblock/<?=encript($row->id)?>",
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
                loader("hide");
                response = admin_response_data_check(response);
                
                $(".block-button, .unblock-button").hide();
                if(response.status==200) $(".block-button").show();
                else $(".unblock-button").show();

            });
       }));

        var status = "<?=$row->status?>";
        $(".block-button, .unblock-button").hide();
        if(status==1) $(".block-button").show();
        else $(".unblock-button").show();

    </script>




