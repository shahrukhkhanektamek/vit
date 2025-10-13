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
                                    <div>
                                        <a href="<?=$data['route'].'/add'?>" class="btn btn-primary add-new">Add New <?=$data['title']?></a>
                                    </div>
                                </div>
                                <div class="card-header">
                                    <div class="row mt-2">
                                        <div class="col-md-2">
                                            <select class="form-control status" id="statuschange">
                                               <option value="1">Active</option>
                                               <option value="0">Inactive</option>
                                            </select>
                                         </div>
                                         <div class="col-md-2">
                                            <select class="form-control order_by" id="order_by">
                                               <option value="desc">DESC</option>
                                               <option value="asc">ASC</option>
                                            </select>
                                         </div>
                                         <div class="col-md-2">
                                            <select class="form-control limit" id="limit">
                                               <option value="12">12</option>
                                               <option value="24">24</option>
                                               <option value="36">36</option>
                                               <option value="100">100</option>
                                            </select>
                                         </div>                                             
                                         <div class="col-md-3">
                                            <div class="navbar-item navbar-form">
                                                  <div class="form-group">
                                                     <input type="text" class="form-control search-input" placeholder="Enter keyword">
                                                  </div>
                                            </div>
                                         </div>
                                         <div class="col-md-3">
                                            <button href="<?=$data['route']?>" class="btn btn-dark search w-100"><i class="ri-search-line align-bottom me-1"></i> Search</button>
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



        
<?=view('backend/include/footer') ?>

<script>
   var data = '';
   var main_url = "<?=$data['route']?>/load_data";

   function get_url_data()
   {
       var status = $("#statuschange").val();
       var order_by = $("#order_by").val();
       var limit = $("#limit").val();
       var filter_search_value = $(".search-input").val();
       data = `status=${status}&order_by=${order_by}&limit=${limit}&filter_search_value=${filter_search_value}`;
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
</script>
