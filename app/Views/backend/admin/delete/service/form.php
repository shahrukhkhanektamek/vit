<?=view('backend/include/header') ?>

<div class="page-content table_page">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0"><?=$data['page_title']?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('/admin')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a ><?=$data['title']?></a></li>
                            <li class="breadcrumb-item active"><?=$data['page_title']?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <form class="row g-3 form_data" action="<?=$data['route'].'/update'?>" method="post" enctype="multipart/form-data" id="form_data_submit" novalidate>

             <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?=encript(@$row->id)?>">
            
            <!--end col-->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1"><?=$data['title']?> Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">
                                
                                <div class="col-md-6 hide">
                                    <label class="form-label">Select Service Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="service_type" >
                                        <option value="">Select</option>
                                        <option value="1" <?php if(@$row->service_type==1)echo'selected'; ?> >CA</option>
                                        <option value="2" <?php if(@$row->service_type==2)echo'selected'; ?> >Advocate</option>
                                        <option value="3" <?php if(@$row->service_type==3)echo'selected'; ?> >Adviser</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Select Category <span class="text-danger">*</span></label>
                                    <select class="form-control" name="category" id="main-menu">
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('service_category')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(@$row->category==$value->id) $selected = 'selected';
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                

                                <div class="col-md-6">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="" value="<?=@$row->name?>" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="slug" placeholder="" value="<?=@$row->slug?>" >
                                </div>

                                
                                <div class="col-lg-12">
                                    <label class="form-label">Sort Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="sort_description" rows="4" required><?=@$row->sort_description?></textarea>
                                </div>
                                
                                <div class="col-lg-12">
                                    <label class="form-label">Sort Description Detail Page <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="sort_description_detail_page" rows="4" required><?=@$row->sort_description_detail_page?></textarea>
                                    <script>CKEDITOR.replace( 'sort_description_detail_page' );</script>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1">Documents Are Required</h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">

                                <div class="col-lg-6">
                                    <label class="form-label"> Description</label>
                                    <textarea class="form-control" name="document_area_description" rows="4" required><?=@$row->document_area_description?></textarea>
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label">Image <span class="text-danger">*</span> <small>If you want to covert .webp file <a href="https://cloudconvert.com/jpg-to-webp" target="_blank">Click to open link</a></small></label>
                                    <div class="col-lg-12">
                                        <input class="form-control upload-single-image" type="file" name="document_area_image" data-target="document_area_image" accept="image/*" @if(empty($row))  @endif>
                                        <img class="upload-img-view img-thumbnail mt-2 mb-2 document_area_image" id="viewer" style="width:auto;height:120px;overflow:hidden;" src="<?=image_check(@$row->document_area_image)?>" alt="banner image"/>
                                    </div>
                                </div>

                                <div class="col-lg-12 required-info">
                                    <?php echo view('upload-multiple/required',compact('row','db','data')); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1">Overview </h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">

                                <div class="col-lg-6">
                                    <label class="form-label"> Overview</label>
                                    <textarea class="form-control" name="overview_description" rows="4" required><?=@$row->overview_description?></textarea>
                                    <script>CKEDITOR.replace( 'overview_description' );</script>
                                </div>

                                <div class="col-lg-6 form-group">
                                     <label class="form-label">Image *</label>
                                     <div class="images">
                                         <?php 
                                             $file_data = array(
                                                 "position"=>3,
                                                 "columna_name"=>"overview_images",
                                                 "multiple"=>true,
                                                 "accept"=>'image/*',
                                                 "col"=>"col-md-6",
                                                 "alt_text"=>"none",
                                                 "row"=>$row,
                                             );
                                             echo view('upload-multiple/index', compact('file_data'));
                                         ?>
                                     </div>
                                 </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1">Faq's</h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">

                                <div class="col-lg-6">
                                    <label class="form-label"> Description</label>
                                    <textarea class="form-control" name="faq_description" rows="4" required><?=@$row->faq_description?></textarea>
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label">Image <span class="text-danger">*</span> <small>If you want to covert .webp file <a href="https://cloudconvert.com/jpg-to-webp" target="_blank">Click to open link</a></small></label>
                                    <div class="col-lg-12">
                                        <input class="form-control upload-single-image" type="file" name="faq_image" data-target="faq_image" accept="image/*" @if(empty($row))  @endif>
                                        <img class="upload-img-view img-thumbnail mt-2 mb-2 faq_image" id="viewer" style="width:auto;height:120px;overflow:hidden;" src="<?=image_check(@$row->faq_image)?>" alt="banner image"/>
                                    </div>
                                </div>

                                <div class="col-lg-12 faq-info">
                                    <?php echo view('upload-multiple/faq',compact('row','db','data')); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1"><?=$data['title']?> Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">


                                <div class="col-lg-12">
                                    <label class="form-label">Service Description* <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="full_description" rows="4" required><?=@$row->full_description?></textarea>
                                    <script>CKEDITOR.replace( 'full_description' );</script>
                                </div>


                                

                                <div class="col-lg-12">
                                    <label class="form-label">Extra Description<span class="text-danger">(Optional)</span></label>
                                    <textarea class="form-control" name="extra" rows="4" required><?=@$row->extra?></textarea>
                                    <script>CKEDITOR.replace( 'extra' );</script>
                                </div>


                                


                                <div class="col-lg-12">
                                    <label class="form-label">Image <span class="text-danger">*</span> <small>If you want to covert .webp file <a href="https://cloudconvert.com/jpg-to-webp" target="_blank">Click to open link</a></small></label>
                                    <div class="col-lg-12">
                                        <input class="form-control upload-single-image" type="file" name="image" data-target="image" accept="image/*" @if(empty($row))  @endif>
                                        <img class="upload-img-view img-thumbnail mt-2 mb-2 image" id="viewer" style="width:auto;height:120px;overflow:hidden;" src="<?=image_check(@$row->image)?>" alt="banner image"/>
                                    </div>
                                </div>


                                <?=view('backend/meta') ?>

                               
                                <div class="col-md-12">
                                    <label for="planStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" id="planStatus" name="status" data-minimum-results-for-search="Infinity" required>
                                        <option value="1" <?php if(!empty(@$row) && @$row->status==1) echo'selected' ?> >Active</option>
                                        <option value="0" <?php if(!empty(@$row) && @$row->status==0) echo'selected' ?> >Disable</option>
                                    </select>
                                    <div class="invalid-feedback">Please select any on option.</div>
                                </div>
                                <div class="col-12">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-success btn-label"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </form>
        <!--end row-->
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->


<?=view('backend/include/footer') ?>

<script>
$(".required-info").on('click','.trash', function () {
    $(this).closest('.required-cont').remove();
    return false;
});

$(".add-required").on('click', function () {

    let ttm = Date.now();
    
    var requiredcontent = '<div class="row form-row required-cont">' +
        '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
                
                '<div class="col-12 ">' +
                    '<div class="form-group">' +
                        '<label>Required</label>' +
                        '<input type="text" class="form-control" name="document_area[]">' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>' +
        '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="ri-delete-bin-6-line"></i></a></div>' +
    '</div>';
    
    $(".required-info").append(requiredcontent);
    $("#select"+ttm).select2();
    return false;
});
</script>


<script>
$(".faq-info").on('click','.trash', function () {
    $(this).closest('.faq-cont').remove();
    return false;
});

$(".add-faq").on('click', function () {

    let ttm = Date.now();
    
    var faqcontent = '<div class="row form-row faq-cont">' +
        '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
                
                '<div class="col-6 ">' +
                    '<div class="form-group">' +
                        '<label>QSN.</label>' +
                        '<input type="text" class="form-control" name="faqqsn[]">' +
                    '</div>' +
                '</div>' +

                '<div class="col-6 ">' +
                    '<div class="form-group">' +
                        '<label>ANS.</label>' +
                        '<input type="text" class="form-control" name="faqans[]">' +
                    '</div>' +
                '</div>' +


            '</div>' +
        '</div>' +
        '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="ri-delete-bin-6-line"></i></a></div>' +
    '</div>';
    
    $(".faq-info").append(faqcontent);
    $("#select"+ttm).select2();
    return false;
});
</script>


