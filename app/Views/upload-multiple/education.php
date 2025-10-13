<?php
$row = $file_data['row'];
(array) $row;

?>

	<?php foreach ($partner_education as $key2 => $value2) { ?>

		  		<div class="row form-row education-cont">
					<div class="col-12 col-md-10 col-lg-11">
						<div class="row form-row">
							<div class="col-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label>Degree</label>
									<select class="select" name="education[]" id="select12<?=$key2 ?>">
										<?php
										$list = $db->table("education")->where(["status"=>1,])->get()->getResultObject();
										foreach ($list as $key => $value) {
										$selected = '';
										if(!empty($partner_educations))
										{
											if($value2->ed_id==$value->id) $selected = 'selected';
										}
										?>
											<option value="<?=$value->id ?>" <?=$selected ?> ><?=$value->name ?></option>
										<?php } ?>
									</select>

								</div> 
							</div>
							<div class="col-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label>College/Institute</label>
									<input type="text" class="form-control" name="collage[]" value="<?=@$value2->collage ?>">
								</div> 
							</div>
							<div class="col-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label>Year of Completion</label>
									<input type="text" class="form-control" name="year_complete[]" value="<?=@$value2->year_complete ?>">
								</div> 
							</div>
						</div>
					</div>

					<?php if($key2>0){ ?>
						<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>
					<?php } ?>
				</div>

<script>$("#select12<?=$key2 ?>").select2();</script>
		<?php }	?>