<?php $user = $user = get_user();$user_role = get_role_by_id($user->role); ?>
<?=view("web/include/header"); ?>

<style>
.fa-wallet {
    font-size: 40px;
    color: #d7d7d7;
}
</style>
			
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

												

												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar">
															<i class="fa fa-wallet"></i>
														</div>
														<div class="dash-widget-info">
															<h6>Total Eearning</h6>
															<h3><?=price_formate($data['totalEarning'])?></h3>
														</div>
													</div>
												</div>

												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar">
															<i class="fa fa-wallet"></i>	
														</div>
														<div class="dash-widget-info">
															<h6>Total TDS</h6>
															<h3><?=price_formate($data['totalTds'])?></h3>
														</div>
													</div>
												</div>
												
											
												<div class="col-md-12 col-lg-4">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar">
															<i class="fa fa-wallet"></i>	
														</div>
														<div class="dash-widget-info">
															<h6>Total Final Earning</h6>
															<h3><?=price_formate($data['finalEarning'])?></h3>
														</div>
													</div>
												</div>
											
												<div class="col-md-12 col-lg-4 mt-3" style="margin: 0 0 0 auto;">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar">
															<i class="fa fa-wallet"></i>	
														</div>
														<div class="dash-widget-info">
															<h6>Total Unpaid Payout</h6>
															<h3><?=price_formate($data['unPaid'])?></h3>
														</div>
													</div>
												</div>
												
											
												<div class="col-md-12 col-lg-4 mt-3" style="margin: 0 auto 0 0;">
													<div class="dash-widget dct-border-rht">
														<div class="circle-bar">
															<i class="fa fa-wallet"></i>	
														</div>
														<div class="dash-widget-info">
															<h6>Total Paid Payout</h6>
															<h3><?=price_formate($data['paid'])?></h3>
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
									<div class="appointment-tab">

										
									
										<!-- Appointment Tab -->
										<div class="nav-tabs">
											<div class="row mt-2">
		                                        <div class="col-md-1">
		                                            <select class="form-control limit" id="limit">
		                                               <option value="12">12</option>
		                                               <option value="24">24</option>
		                                               <option value="36">36</option>
		                                               <option value="100">100</option>
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
		                                        <div class="col-xl-3">
		                                            <input type="date" id="from_date" class="form-control">
		                                        </div>
		                                        <div class="col-xl-3">
		                                            <input type="date" id="to_date" class="form-control">
		                                        </div>
		                                   
		                                               
		                                        
		                                        

		                                        
		                                        <div class="col-sm-3">
		                                            <div>
		                                                <button type="button" class="btn btn-primary w-100" id="filter-btn"><i class="ri-equalizer-fill me-2 align-bottom"></i>Filters
		                                                </button>
		                                            </div>
		                                        </div>
		                                        <!--end col-->
		                                            
		                                    </div>
										</div>
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
   var main_url = "<?=base_url(route_to('partner.earning.load_data'))?>";

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
    load_lead();


   $(document).on("click", ".pagination a",(function(e) {      
      event.preventDefault();
      get_url_data()
      url = $(this).attr("href")+'&'+data;
      load_lead();
   }));
   $(document).on("click", "#filter-btn",(function(e) {
      get_url_data();
      url =main_url+"?"+data;
      load_lead();
   }));

   function load_lead()
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
   
<?=view("web/include/footer"); ?>

