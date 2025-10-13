<?php $user = $user = get_user();$user_role = get_role_by_id($user->role); ?>
<?=view("web/include/header"); ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
						<?=view("partner/nav"); ?>
						
						<div class="col-md-7 col-lg-8 col-xl-9">

							<div class="row">
								<div class="col-md-12">
									<div class="card dash-card">
										<div class="card-body">
											<div class="row">

												<div class="col-md-12">
													  <?php if($user->kyc_step==1){?>
										              <div class="alert alert-success show" role="alert"><strong>Success</strong> - Your Kyc Is Approved. You can change your kyc.
										              </div>
										              <?php }else if($user->kyc_step==0){ ?>										              
										              <div class="alert alert-info show" role="alert"><strong>Information</strong> - Update Your Kyc <a href="<?=base_url($user_role->nav).'/kyc' ?>" style="text-decoration: underline;">Click Here</a> 
										              </div>

										              <?php }else if($user->kyc_step==2){ ?>
										              <div class="alert alert-info show" role="alert"><strong>Information</strong> - Your Kyc Is Under Review
										              </div>
										              <?php }else if($user->kyc_step==3){ ?>
										              <div class="alert alert-danger show" role="alert"><strong>Warning</strong> - Your Kyc Rejected!
										              </div>
										              <?php } ?>
												</div>

												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar">
																<img src="<?=base_url() ?>assets/img/icon-03.png" class="img-fluid" alt="student">
														</div>
														<div class="dash-widget-info">
															<h6>Total Lead</h6>
															<h3><?=$db->table('partner_lead')->where(["partner_id"=>$user->id,])->countAllResults()?></h3>
														</div>
													</div>
												</div>
												
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar">
																<img src="<?=base_url() ?>assets/img/icon-03.png" class="img-fluid" alt="student">
														</div>
														<div class="dash-widget-info">
															<h6>Today Lead</h6>
															<h3>
																<?php 
																	$date = date("Y-m-d");
																	$year = date("Y", strtotime($date));
															        $month = date("m", strtotime($date));
															        $day = date("d", strtotime($date));
																	echo $db->table('partner_lead')
																	->where('YEAR(partner_lead.add_date_time)', $year)
														            ->where('MONTH(partner_lead.add_date_time)', $month)
														            ->where('DAY(partner_lead.add_date_time)', $day)
																	->where(["partner_id"=>$user->id,])->countAllResults();
																?>
															</h3>
														</div>
													</div>
												</div>
												
												
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<h4 class="mb-4">student Appoinment</h4>
									<div class="appointment-tab">
									
										<!-- Appointment Tab -->
										<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
											<li class="nav-item">
												<a class="nav-link active" href="#upcoming-appointments" data-bs-toggle="tab">Today Lead</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="#today-appointments" data-bs-toggle="tab">Today Appointment</a>
											</li> 
										</ul>
										<!-- /Appointment Tab -->
										
										<div class="tab-content">
										
											<!-- Upcoming Appointment Tab -->
											<div class="tab-pane show active" id="upcoming-appointments">
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive" id="data-list">
																	
														</div>
													</div>
												</div>
											</div>
											<!-- /Upcoming Appointment Tab -->
									   
											<!-- Today Appointment Tab -->
											<div class="tab-pane" id="today-appointments">
												<div class="card card-table mb-0">
													<div class="card-body">
														<div class="table-responsive" id="data-list2">
															<table class="table table-hover table-center mb-0">
																<thead>
																	<tr>
																		<th>Name</th>
																		<th>Phone</th>
																		<th>Email</th>
																		<th>State</th>
																		<th>Requirment</th>
																		<th>Date Time</th>
																		<th></th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>
																			<h2 class="table-avatar">
																				<a href="student-profile.php" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="<?=base_url() ?>assets/img/student/student-01.jpg" alt="User Image"></a>
																				<a href="student-profile.php">Richard Wilson <span>#PT0016</span></a>
																			</h2>
																		</td>
																		<td>General</td>
																		<td>General</td>
																		<td>General</td>
																		<td>General</td>
																		<td>11 Nov 2019 <span class="d-block text-info">10.00 AM</span></td>
																		<td class="text-end">
																			<div class="table-action">
																				<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																					<i class="far fa-eye"></i> View
																				</a>
																				
																				<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
																					<i class="fas fa-check"></i> Accept
																				</a>
																				<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
																					<i class="fas fa-times"></i> Cancel
																				</a>
																			</div>
																		</td>
																	</tr>
																	
																</tbody>
															</table>		
														</div>	
													</div>	
												</div>	
											</div>
											<!-- /Today Appointment Tab -->
											
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
   var data = '';
   var main_url = "<?=base_url(route_to('partner.lead.load_data'))?>";
   var main_url2 = "<?=base_url(route_to('partner.appointment.load_data'))?>";

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
    load_table_today_lead();
    load_table_appointment();


   $(document).on("click", ".pagination a",(function(e) {      
      event.preventDefault();
      get_url_data()
      url = $(this).attr("href")+'&'+data;
      load_table_today_lead();
   }));

   function load_table_today_lead()
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

<script>
$(document).on("click", ".scratch-lead",(function(e) {      
    event.preventDefault();
    var id = $(this).data('id');
    loader("show");
    var form = new FormData();
    form.append("id", id);
    
    var settings = {
      "url": "<?=base_url(route_to('partner.lead.scratch'))?>",
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
            $("#rowapname"+id).html(response.data.name)
            $("#rowapemail"+id).html(response.data.email)
            $("#rowapphone"+id).html(response.data.phone)                
        }
        

    });
}));
$(document).on("click", ".scratch-appointment",(function(e) {      
    event.preventDefault();
    var id = $(this).data('id');
    loader("show");
    var form = new FormData();
    form.append("id", id);
    
    var settings = {
      "url": "<?=base_url(route_to('partner.appointment.scratch'))?>",
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
            $("#rowapname"+id).html(response.data.name)
            $("#rowapemail"+id).html(response.data.email)
            $("#rowapphone"+id).html(response.data.phone)                
        }
        

    });
}));
</script>
   
<?=view("web/include/footer"); ?>

