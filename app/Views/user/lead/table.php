<div class="appointments">

<?php foreach ($data_list as $key => $value) { ?>							
	<!-- Appointment List -->
	<div class="appointment-list">
		<div class="profile-info-widget">
			
			<div class="profile-det-info">
				<h3><a href="student-profile.html"><?=$value->service_name ?></a></h3>
				<p><?=$value->message ?></p>
				<div class="customer-details">
					<h5><i class="far fa-clock"></i> <?=date("d m Y h:i A", strtotime($value->add_date_time)) ?></h5>
					<h5><i class="fas fa-map-marker-alt"></i> <?=$value->state_name ?></h5>
					<h5><i class="fas fa-user"></i> <a href="#"><span id="rowemail<?=encript($value->id) ?>"><?=$value->name ?></span></a></h5>
					<h5><i class="fas fa-envelope"></i> <a href="#"><span id="rowemail<?=encript($value->id) ?>"><?=$value->email ?></span></a></h5>
					<h5 class="mb-2"><i class="fas fa-phone"></i> <span id="rowphone<?=encript($value->id) ?>"><?=$value->phone ?></span></h5>
				</div>
			</div>
		</div>
		<div class="appointment-action">

			<!-- <a href="javascript:void(0);" class="btn btn-sm bg-success-light"><i class="fas fa-check"></i> Accept</a> -->
			<!-- <a href="javascript:void(0);" class="btn btn-sm bg-danger-light"><i class="fas fa-times"></i> Cancel</a> -->
		</div>
	</div>
	<!-- /Appointment List -->	
<?php } ?>
	
</div>

<div class="pagination">
        <div class="pagination-result">
        Showing
        <span class="start-data">  <?=$data['startData'] ?></span>
        <span>to</span>
        <span class="end-data"><?=$data['endData'] ?></span>
        <span class="total-data"><?=$data['totalData'] ?> Results</span>
    </div>
    <?=$data['pager']?>
</div>