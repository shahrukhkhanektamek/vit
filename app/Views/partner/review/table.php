<ul class="comments-list">

<?php foreach ($data_list as $key => $value) { ?>							
	<!-- Comment List -->
	<li>
		<div class="comment">
			<img class="avatar rounded-circle" alt="User Image" src="<?=image_check($value->image,'user.png') ?>">
			<div class="comment-body">
				<div class="meta-data">
					<span class="comment-author"><?=$value->name ?></span>
					<span class="comment-date">Reviewed <?=date("d M Y", strtotime($value->add_date_time)) ?></span>
					<div class="review-count rating">
						<?php
							$i = 1;
							while ($i<=5) {
								if($i<=$value->rating)
								 	echo '<i class="fas fa-star filled"></i>';
								else
									echo '<i class="fas fa-star"></i>';
								$i++;	
							}
						?>
					</div>
				</div>
				<p class="comment-content">
					<?=$value->comment ?>
				</p>
				
			</div>
		</div>
		
		
	</li>
	<!-- /Comment List -->	
<?php } ?>
	
</ul>

<?php if(!empty($data['startData'])){ ?>

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
<?php } ?>