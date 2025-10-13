<?php
    $slug = @$row->slug;
    $meta_data = $db->table('meta_tags')->where('slug',$slug)->get()->getRow();
?>

<div class="col-md-6">
    <label class="form-label">Meta Author <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="meta_author" placeholder="" value="<?=@$meta_data->meta_author?>" >
</div>

<div class="col-md-6">
    <label class="form-label">Meta Keywords <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="meta_keywords" placeholder="" value="<?=@$meta_data->meta_keywords?>" >
</div>

<div class="col-lg-12">
    <label class="form-label">Meta Description <span class="text-danger">*</span></label>
    <textarea class="form-control" name="meta_description" rows="2" ><?=@$meta_data->meta_description?></textarea>
</div>