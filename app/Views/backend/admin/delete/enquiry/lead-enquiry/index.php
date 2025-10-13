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
                                        <li class="breadcrumb-item active"><?=$data['page_title']?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- <div class="alert alert-success" role="alert">
                        <i class="ri-checkbox-circle-line"></i> You <b>Successfully</b> created your teacher in our system!
                    </div>
                    <div class="alert alert-warning" role="alert">
                    <i class="ri-alert-line"></i> <strong>Error:</strong> something went wrong, pleaser try again!
                    </div> -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1"><?=$data['page_title']?></h5>
                                </div>
                                <div class="card-header">
                                    <div class="row mt-2">
                                        <div class="col-md-2 hide">
                                            <select class="form-control status" id="statuschange">
                                               <option value="1">Paid</option>
                                               <option value="0">Unpaid</option>
                                            </select>
                                         </div>
                                         <div class="col-md-1 hide">
                                            <select class="form-control order_by" id="order_by">
                                               <option value="desc">DESC</option>
                                               <option value="asc">ASC</option>
                                            </select>
                                         </div>
                                         <div class="col-md-2 hide">
                                            <select class="form-control limit" id="limit">
                                               <option value="12">12</option>
                                               <option value="24">24</option>
                                               <option value="36">36</option>
                                               <option value="100">100</option>
                                            </select>
                                         </div>
                                         <div class="col-md-6 mb-2 hide">
                                            <select class="form-control " id="select-all-partner">
                                               <option value="">All Partner</option>
                                            </select>
                                         </div>
                                         <div class="col-md-6 hide">
                                            <select class="form-control " id="select-all-employee">
                                               <option value="">All Employee</option>
                                            </select>
                                         </div>

                                        <div class="col-sm-3">
                                            <div class="">
                                                <input type="date" class="form-control" id="from-date" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="">
                                                <input type="date" class="form-control" id="to-date" value="">
                                            </div>
                                        </div>

                                         <div class="col-md-4">
                                            <div class="navbar-item navbar-form">
                                                  <div class="form-group">
                                                     <input type="text" class="form-control search-input" placeholder="Search Email Id.">
                                                  </div>
                                            </div>
                                         </div>
                                         <div class="col-md-2">
                                            <button href="{{$data['back_btn']}}" class="btn btn-dark search w-100"><i class="ri-search-line align-bottom me-1"></i> Search</button>
                                         </div>
                                    </div>
                                </div>
                                <div class="card-body" id="data-list">




                                    
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->




            

    <div id="addStatus" class="modal fade zoomIn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 form_data" action="<?=base_url(route_to('lead-enquiry.update')) ?>" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>

                         <?= csrf_field() ?>
                        <input type="hidden" name="id" id="statusId" value="0">


                        <div class="col-md-12">
                            <label for="formstatus" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single" id="formstatus" name="followup_status" data-minimum-results-for-search="Infinity" required>
                                <option value="">Select </option>
                                <?php 
                                foreach (lead_status() as $key => $value) {                                
                                ?>
                                    <option value="<?=$key ?>"><?=$value ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback">Please select any on option.</div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Comment<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="5" name="message" required></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label"> Reminder Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date" >
                        </div>

                        <div class="col-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-label"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




                
    <div id="load-timeline" class="modal fade zoomIn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">TimeLine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="load-timeline-body">
                    
                    wait...

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div id="assignLead" class="modal fade zoomIn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Assign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 form_data" action="<?=base_url(route_to('lead-enquiry.assign')) ?>" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>

                        <?= csrf_field() ?>
                        <input type="hidden" name="id" id="statusId2" value="0">


                        <div class="col-md-12">
                            <label for="employee_id" class="form-label">Employee <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single" id="employee_id" name="employee_id" data-minimum-results-for-search="Infinity" required>
                                <option value="">Select </option>
                                <?php 
                                    $employees = $db->table("users")->where(["role"=>6,])->get()->getResult();
                                    foreach ($employees as $key => $value) {                                
                                ?>
                                    <option value="<?=$value->id ?>"><?=$value->name ?></option>
                                <?php } ?>                  
                            </select>
                        </div>


                        <div class="col-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-label"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

        
<?=view('backend/include/footer') ?>

<script>
   var data = '';
   var main_url = "<?=$data['route']?>/load_data";

   function get_url_data()
   {
       var status = $("#statuschange").val();
       var order_by = $("#order_by").val();
       var limit = $("#limit").val();
       var from_date = $("#from-date").val();
       var to_date = $("#to-date").val();
       var filter_search_value = $(".search-input").val();
       data = `status=${status}&from_date=${from_date}&to_date=${to_date}&order_by=${order_by}&limit=${limit}&filter_search_value=${filter_search_value}`;
   }
    get_url_data();
   url = main_url+'?'+data;
   load_table();
   $(document).on("change", "#statuschange, .order_by, .limit",(function(e) {
      get_url_data();
      url =main_url+"?"+data;
      load_table();
   }));
   $(document).on("click", ".search",(function(e) {
      get_url_data();
      url =main_url+"?"+data;
      load_table();
   }));
   $(document).on("click", ".pagination a",(function(e) {      
      event.preventDefault();
      get_url_data()
      url = $(this).attr("href")+'&'+data;
      load_table();
   }));

   function load_table()
   {
        data_loader("#data-list",1);
        var form = new FormData();
        var settings = {
          "url": url,
          "method": "GET",
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
            data_loader("#data-list",0);
            response = admin_response_data_check(response);
            $("#data-list").html(response.data.list);

        });
   }


   var transferId = 0;
   $(document).on("click", ".transfer-modal-open",(function(e) {      
      event.preventDefault();
      transferId = $(this).data("id");
      $("#transferModal").modal("show");
   }));
   $(document).on("click", ".transfer-now",(function(e) {      
      event.preventDefault();
      data_loader("#data-list",1);
        var form = new FormData();
        form.append("id", transferId);
        form.append("partner_id", $("#select-vendor").val());

        var settings = {
          "url": "<?=$data['route']?>/transfer_now",
          "method": "POSt",
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
            data_loader("#data-list",0);
            response = admin_response_data_check(response);
            $("#transferModal").modal("hide");
            // $("#data-list").html(response.data.list);

        });
   }));


   $(document).on("click", ".assign-lead",(function(e) {
        $("#statusId2").val($(this).data('id'));
        $("#assignLead").modal("show");
   }));

    $(document).on("click", ".add-status",(function(e) {
        $("#statusId").val($(this).data('id'));
        $("#addStatus").modal("show");
    }));


    $(document).on("click", ".load-timeline",(function(e) {
        loader("show");
        var form = new FormData();
        form.append('id',$(this).data('id'));


        var settings = {
          "url": "<?=base_url(route_to('lead-enquiry.time_line')) ?>",
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
            if(response.status==200)
            {
                var data = response.data;
                var html = `<table class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>Comment</th>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr> 
                    </thead><body>`;
                
                $(data).each(function(index, item){
                    html = html+`
                        <tr>
                            <td>${item.message}</td>
                            <td>${item.employee_name}</td>
                            <td>${item.add_date_time}</td>
                            <td>${item.followup_status}</td>
                        </tr>
                    `;
                });
                html = html+'</body></table>';


                $("#load-timeline-body").html(html);

                $("#load-timeline").modal("show");
            }
            else
            {
                error_message(response.message);
            }
        });
   }));
   
</script>
