<?=view("web/include/header"); ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Dashboard</h2>
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
								<div class="card-body pt-0">
								
									<!-- Tab Menu -->
									<nav class="user-tabs mb-4">
										<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
											<li class="nav-item">
												<a class="nav-link active" href="#pat_appointments" data-bs-toggle="tab">Appointments</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#pat_prescriptions" data-bs-toggle="tab">Enquiry</a>
											</li>
										</ul>
									</nav>
									<!-- /Tab Menu -->
									
									<!-- Tab Content -->
									<div class="tab-content pt-0">
										
										<!-- Appointment Tab -->
										<div id="pat_appointments" class="tab-pane fade show active">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive" id="data-list2">
														
													</div>
												</div>
											</div>
										</div>
										<!-- /Appointment Tab -->
										
										<!-- Prescription Tab -->
										<div class="tab-pane fade" id="pat_prescriptions">
											<div class="card card-table mb-0">
												<div class="card-body">
													<div class="table-responsive" id="data-list">
														
													</div>
												</div>
											</div>
										</div>
										<!-- /Prescription Tab -->
											
										
										  
									</div>
									<!-- Tab Content -->
									
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->


<script>
   var data = '';
   var main_url = "<?=base_url(route_to('user.lead.load_data'))?>";
   var main_url2 = "<?=base_url(route_to('user.appointment.load_data'))?>";

    function get_url_data()
    {
        var type = 1;
        var status = 1;
        var order_by = 'desc';
        var limit = 12;
        var filter_search_value = '';
        data = `type=${type}&status=${status}&order_by=${order_by}&limit=${limit}&filter_search_value=${filter_search_value}`;
    }
    get_url_data();
    url = main_url+'?'+data;
    url2 = main_url2+'?'+data;
    load_table_lead();
    load_table_appointment();


   $(document).on("click", ".pagination a",(function(e) {      
      event.preventDefault();
      get_url_data()
      url = $(this).attr("href")+'&'+data;
      load_table_lead();
   }));

   function load_table_lead()
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

   $(document).on("click", ".pagination2 a",(function(e) {      
      event.preventDefault();
      get_url_data()
      url2 = $(this).attr("href")+'&'+data;
      load_table_appointment();
   }));

   function load_table_appointment()
   {
        data_loader("#data-list2",1);
        var form = new FormData();
        var settings = {
          "url": url2,
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
            data_loader("#data-list2",0);
            response = admin_response_data_check(response);
            $("#data-list2").html(response.data.list);

        });
   }
</script>




<?=view("web/include/footer"); ?>