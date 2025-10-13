<?=view("web/include/header"); ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Change Password</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Change Password</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<?=view("partner/nav"); ?>
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-6">
										
											<!-- Change Password Form -->
											<form class="form_data" action="<?=($data['route'].'/update'); ?>" method="post" id="PasswordForm" novalidate >
												<div class="form-group">
													<label>Old Password</label>
													<input type="password" class="form-control" required name="old_password">
													<i class="fa fa-eye password_show_hide"></i>
												</div>
												<div class="form-group">
													<label>New Password</label>
													<input type="password" class="form-control" required name="npassword">
													<i class="fa fa-eye password_show_hide"></i>
												</div>
												<div class="form-group">
													<label>Confirm Password</label>
													<input type="password" class="form-control" required name="cpassword">
													<i class="fa fa-eye password_show_hide"></i>
												</div>
												<div class="submit-section">
													<button type="submit" class="btn btn-primary">Save Changes</button>
												</div>
											</form>
											<!-- /Change Password Form -->
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->

<?=view("web/include/footer"); ?>