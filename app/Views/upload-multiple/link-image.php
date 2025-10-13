<?php
$row = $file_data['row'];
(array) $row;
?>
<ul class="multiple-image-link ui-sortable" id="multiple-image-link<?=$file_data['position'] ?>">
	<?php	
		$images_array = array();
		$images = @$row[$file_data['columna_name']];
		if(!empty($images))
		{
			$images_array = json_decode($images);
			if(empty($images_array)) $images_array = [''];
		}
		else $images_array = [''];
		if(!empty($images_array))
		{
				foreach ($images_array as $key_image => $value_image)
				{
					if(!empty($value_image->path) || $key_image==0)
					{
						$image_path = @$value_image->path;
						$image_alt = @$value_image->alt;
		?>
		  	<li>
	            <div class="input-group price_input mt-2">
	                <span class="cost_sign fw-bold" style="top:5px;color:#99999998;z-index:99;"><i class="ri-image-add-line fs-4"></i></span>
	                <input type="text" class="form-control" name="image_string<?=$file_data['columna_name'] ?>[]" placeholder="e.g https://ik.imgkit.net/ikmedia/" value="<?=$image_path ?>" aria-describedby="button-addon" >
	                <?php if($file_data['alt_text']){ ?>
	                	<input type="text" class="form-control image_alt" name="image_alt_text<?=$file_data['columna_name'] ?>[]" placeholder="e.g Image Alt" value="<?=$image_alt ?>" >
	              	<?php } ?>

	                <?php if($key_image==0 && $file_data['multiple']){ ?>
	                	<button class="btn btn-dark material-shadow-none add-btn" type="button" data-cname="<?=$file_data['columna_name'] ?>" data-target="multiple-image-link<?=$file_data['position'] ?>" data-alt_text="<?=$file_data['alt_text'] ?>"><i class="ri-add-line"></i></button>
	              	<?php }else if($file_data['multiple']){ ?>
	                	<button class="btn btn-danger material-shadow-none remove-btn" type="button" ><i class="ri-subtract-line"></i></button>
	                <?php } ?>
	            </div>
	        </li>
		<?php 
					}
				}
		}
?>
</ul>