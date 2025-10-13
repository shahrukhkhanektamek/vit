<?php
$row = $file_data['row'];
$row =(array) $row;
?>
<ul class="multiple-image-link ui-sortable" id="multiple-image-link<?=$file_data['position'] ?>" style="list-style: none;margin: 0;padding: 0;margin-top: -1rem;" >
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
					if(!empty($value_image->title) || $key_image==0)
					{
						$image_path = @$value_image->title;
						$image_alt = @$value_image->value;
		?>
		  	<li>
	            <div class="input-group mt-2">
	                
	                <input type="text" class="form-control image_path" name="title<?=$file_data['columna_name'] ?>[]" placeholder="Feature Title" value="<?=$image_path ?>" >
	                <input type="text" class="form-control image_alt" name="value<?=$file_data['columna_name'] ?>[]" placeholder="Feature Output" value="<?=$image_alt ?>" >	              	

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