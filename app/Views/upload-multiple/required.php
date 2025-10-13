<?php
$row = $row;

$dataList = json_decode($row->document_area);
if(empty($dataList)) $dataList = [1];

?>

<?php foreach ($dataList as $key2 => $value2) { ?>

	<div class="row form-row required-cont">
		<div class="col-12 col-md-10 col-lg-11">
			<div class="row form-row">
				
				<div class="col-12">
					<div class="form-group">
						<label>Required</label>
						<input type="text" class="form-control" name="document_area[]" value="<?=@$value2 ?>">
					</div> 
				</div>
				
			</div>
		</div>

		<?php if($key2>0){ ?>
			<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="ri-delete-bin-6-line"></i></a></div>
		<?php }else{ ?>
			<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-success add-required"><i class="ri-add-fill"></i></a></div>
		<?php } ?>
	</div>

<?php }	?>