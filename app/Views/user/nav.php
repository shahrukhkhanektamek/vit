<?php $user = $user = get_user();$user_role = get_role_by_id($user->role); ?>
<span class="panel-sidebar-open-btn">Menu</span>
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
	<i class="fa fa-times panel-sidebar-close-btn"></i>
	<div class="profile-sidebar">
		<div class="widget-profile pro-widget-content">
			<div class="profile-info-widget">
				<a href="#" class="booking-pro-img">
					<img src="<?=image_check($user->image,'user.png') ?>" alt="User Image">
				</a>
				<div class="profile-det-info">
					<h3><?=$user->name ?></h3>
					<div class="customer-details">
						<h5><i class="fas fa-calendar"></i> <?=date("d M Y", strtotime($user->add_date_time))?></h5>
						<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?=$user->country_name ?>, <?=$user->state_name ?></h5>
					</div>
				</div>
			</div>
		</div>
		<div class="dashboard-widget">
			<nav class="dashboard-menu">
				<ul>
					<li class="active">
						<a href="<?=base_url().$user_role->nav.'/' ?>dashboard">
							<i class="fas fa-columns"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().$user_role->nav.'/' ?>reviews">
							<i class="fas fa-star"></i>
							<span>Services</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().$user_role->nav.'/' ?>review">
							<i class="fas fa-star"></i>
							<span>Reviews</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url() ?>advocates">
							<i class="fas fa-user-tie"></i>
							<span>Lawyer</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url() ?>advisers">
							<i class="fas fa-user-tie"></i>
							<span>Adviser</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url() ?>ca">
							<i class="fas fa-user-tie"></i>
							<span>CA</span>
						</a>
					</li>

					<li>
						<a href="<?=base_url().'gemini/' ?>ask-ally">
							<i class="fas fa-robot"></i>
							<span>Ask Ally</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().'gemini/' ?>legal-research">
							<i class="fas fa-scale-balanced"></i>
							<span>Legal Research</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().'gemini/' ?>legal-drafting">
							<i class="fas fa-scale-balanced"></i>
							<span>Legal Drafting</span>
						</a>
					</li>
					
					<li>
						<a href="<?=base_url().'gemini/' ?>translator">
							<i class="fas fa-language"></i>
							<span>Translator</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().'gemini/' ?>complaint-writer">
							<i class="fas fa-pen-to-square"></i>
							<span>Complaint Writer</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().'gemini/' ?>document-generator">
							<i class="fas fa-file"></i>
							<span>Document Generator</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().'gemini/' ?>document-analyzer">
							<i class="fas fa-search"></i>
							<span>Document Analyzer</span>
						</a>
					</li>

					<li>
						<a href="<?=base_url().$user_role->nav.'/' ?>profile">
							<i class="fas fa-user-cog"></i>
							<span>Profile Settings</span>
						</a>
					</li>
					<li>
						<a href="<?=base_url().$user_role->nav.'/' ?>password">
							<i class="fas fa-lock"></i>
							<span>Change Password</span>
						</a>
					</li>
					<li>
						<a href="#" class="logout">
							<i class="fas fa-sign-out-alt"></i>
							<span>Logout</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>

	</div>
</div>