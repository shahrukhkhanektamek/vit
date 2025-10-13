<div class="table-responsive">
	<table class="table table-hover table-center mb-0">
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>TDS</th>
				<th>Final Amount</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			
<?php foreach ($data_list as $key => $value) { ?>	
			<tr>
				<td><?=$value->only_date ?></td>
				<td><?=price_formate($value->amount) ?></td>
				<td><?=price_formate($value->tds_amount) ?></td>
				<td><?=price_formate($value->final_amount) ?></td>
				<td>
					<?php if($value->payment==1){ ?>
						<span class="badge badge-pill bg-success-light">Paid</span>
					<?php }else{ ?>
						<span class="badge badge-pill bg-danger-light">Unpaid</span>
					<?php } ?>
				</td>
			</tr>
<?php } ?>

			

		</tbody>
	</table>
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