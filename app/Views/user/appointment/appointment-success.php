<?=view("web/include/header"); ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Appointment booked Successfully</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Appointment booked Successfully</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row justify-content-center">
                        <div class="col-lg-6">
                        
                            <!-- Success Card -->
                            <div class="card success-card">
                                <div class="card-body">
                                    <div class="success-cont">
                                        <i class="fas fa-check"></i>
                                        <h3>Appointment booked Successfully!</h3>
                                        <p>Appointment booked with <strong><?=$row->partner_name ?></strong><br> on <strong><?=date("d M Y h:i A", strtotime($row->appointment_date_time)) ?></strong></p>
                                        <a href="<?=base_url('user/appointment/invoice/'.encript($row->id)) ?>" class="btn btn-primary view-inv-btn">View Invoice</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Success Card -->
                            
                        </div>
                    </div>

				</div>

			</div>		
			<!-- /Page Content -->



<?=view("web/include/footer"); ?>