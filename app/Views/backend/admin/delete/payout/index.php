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

                    

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1"><?=$data['page_title']?></h5>

                                    <div class="col-sm-auto">
                                            <div class="d-flex flex-wrap align-items-start gap-2">
                                                <button type="button" class="btn btn-danger payout-modal-open">Payout All</button>
                                                <!-- <button type="button" class="btn btn-info">Copy</button> -->
                                                <button type="button" class="btn btn-success" id="excel-export">Excel</button>
                                            </div>
                                        </div>

                                </div>
                                <div class="card-header">
                                    <div class="row mt-2">
                                        <div class="col-md-1">
                                            <select class="form-control limit" id="limit">
                                               <option value="12">12</option>
                                               <option value="24">24</option>
                                               <option value="36">36</option>
                                               <option value="100">100</option>
                                            </select>
                                        </div>   
                                        <div class="col-xl-9">
                                            <select class="form-control kyc" id="select-all-partner" >
                                                <option value="">Select User</option>
                                            </select>
                                        </div>
                                        

                                        <div class="col-sm-2">
                                            <div>
                                                <select class="form-control" id="statuschange">
                                                    <!-- <option value="0">Income</option> -->
                                                    <option value="2" selected>Unpaid</option>
                                                    <option value="1">Paid</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mt-1">
                                            <input type="date" class="form-control" id="from_date">
                                        </div>
                                        <div class="col-sm-4 mt-1">
                                            <input type="date" class="form-control" id="to_date">
                                        </div>
                                   
                                               
                                        

                                        <div class="col-sm-4 hide">
                                            <div class="">
                                                <input type="number" class="form-control" id="amount" value="0">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-1">
                                            <div>
                                                <button type="button" class="btn btn-primary w-100" id="filter-btn"><i class="ri-equalizer-fill me-2 align-bottom"></i>Filters
                                                </button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                            
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


            <div class="modal fade zoomIn" id="PayoutPinModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" id="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mt-2 text-center">
                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                    <h4>Enter Payout PIN</h4>
                                    <input type="number" class="form-control" id="payout-pin">
                                </div>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                <button type="button" class="btn w-sm btn-danger "
                                    id="payout-confirm">Payout Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            




        
<?=view('backend/include/footer') ?>

<script>
   var data = '';
   var main_url = "<?=$data['route']?>/load_data";

   function get_url_data()
   {
       var user_id = $("#select-all-partner").val();
       var status = $("#statuschange").val();
       var order_by = $("#order_by").val();
       var limit = $("#limit").val();
       var from_date = $("#from_date").val();
       var to_date = $("#to_date").val();
       var filter_search_value = $(".search-input").val();
       data = `user_id=${user_id}&status=${status}&from_date=${from_date}&to_date=${to_date}&order_by=${order_by}&limit=${limit}&filter_search_value=${filter_search_value}`;
   }
    get_url_data();
   url = main_url+'?'+data;
   load_table();
   $(document).on("change", "#statuschange, .order_by, .limit",(function(e) {
      get_url_data();
      url =main_url+"?"+data;
      load_table();
   }));
   $(document).on("click", "#filter-btn",(function(e) {
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



    $(document).on("click", ".payout-modal-open",(function(e) {
      $("#PayoutPinModal").modal('show');
   }));
    $(document).on("click", "#payout-confirm",(function(e) {
        var payout_pin = $("#payout-pin").val();

        get_url_data();

        loader('show');
        var form = new FormData();
        form.append("pin",payout_pin);
        var settings = {
          "url": "<?=$data['route']?>/payout_submit"+'?'+data,
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
            loader('hide');
            response = admin_response_data_check(response);
            if(response.status==200)
            {
                $("#PayoutPinModal").modal('hide');
                success_message(response.message)
            }
            else
            {
                error_message(response.message)                
            }
        });

   }));




    $(document).on("click", "#excel-export",(function(e) {
      excel_export();
   }));
   function excel_export()
   {
        get_url_data();
        loader("show");
        var form = new FormData();
        var settings = {
          "url": "<?=$data['route']?>/excel_export?"+data,
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
            loader("hide");
            response = admin_response_data_check(response);
            if(response.status==200)
            {
                window.location.href=response.url;
            }
            // $("#data-list").html(response.data.list);

        });
   }



</script>
