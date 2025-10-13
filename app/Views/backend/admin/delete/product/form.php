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
                    <!--<div class="card-header">-->
                    <!--    <h4 class="card-title mb-0 flex-grow-1"><?=$data['title']?> Details</h4>-->
                    <!--</div>-->

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">
                                
                                <div class="col-md-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="">Select</option>
                                            <option value="1" <?php if(@$row->category==1) echo'selected' ?> >Bikes</option>
                                            <option value="2" <?php if(@$row->category==2) echo'selected' ?> >Scooters</option>
                                            <!--<option value="3">Electric Zone</option>-->
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                                    <select class="form-control" name="brand" id="brand">
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('client_logo')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(@$row->brand==$value->id) $selected = 'selected';
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Fuel Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="fuel_type" id="fuel_type">
                                        <option value="">Select</option>
                                            <option value="1" <?php if(@$row->fuel_type==1) echo'selected' ?> >Petrol</option>
                                            <option value="2" <?php if(@$row->fuel_type==2) echo'selected' ?> >Electric</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Body Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="body_type" id="body_type">
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('product_body_type')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(@$row->body_type==$value->id) $selected = 'selected';
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Top Speed <span class="text-danger">*</span></label>
                                    <select class="form-control" name="speed" id="speed">
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('product_top_speed')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(@$row->speed==$value->id) $selected = 'selected';
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">E-Vehicle Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="vehicle_type" id="vehicle_type">
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('product_vehicle_type')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(@$row->vehicle_type==$value->id) $selected = 'selected';
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">E-Two Wheelers Range <span class="text-danger">*</span></label>
                                    <select class="form-control" name="tworange" id="tworange">
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('product_two_wheelers_range')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(@$row->tworange==$value->id) $selected = 'selected';
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">E-Bikes Charging Time <span class="text-danger">*</span></label>
                                    <select class="form-control" name="biketime" id="biketime">
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('product_charging_time')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                if(@$row->biketime==$value->id) $selected = 'selected';
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">E-Features (Multiples) <span class="text-danger">*</span></label>
                                    <select class="form-control" name="feature[]" id="feature" multiple>
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('product_features')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                $rowFeatue = [];
                                                if(!empty($row))
                                                {
                                                    if(json_decode($row->feature))
                                                    {
                                                        if(in_array($value->id, json_decode($row->feature)))
                                                            $selected = 'selected';
                                                    }
                                                }
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">                                    
                                    <div class="row">                                    
                                        <div class="col-md-12">
                                            <label class="form-label">Price <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">₹</span>
                                                <input type="number" class="form-control" value="<?=@$row->price ?>" name="price" placeholder="i.e 1.68 - 1.73 Lakh" aria-label="Amount (to the nearest dollar)">
                                            </div>
                                        </div>

                                </div>
                                    </div>
                                
                                
                                
                                <div class="col-md-3">
                                    <label class="form-label">Booking Amount <span class="text-danger">*</span></label><br>
                                    <div class="input-step w-100">
                                        <button type="button" class="minus material-shadow">–</button>
                                        <input type="number" class="product-quantity w-100" value="<?=@$row->booking_price ?>" min="0" max="50000" name="booking_price" required>
                                        <button type="button" class="plus material-shadow">+</button>
                                    </div>
                                    <!--<input type="text" class="form-control" name="slug" placeholder="" value="<?=@$row->slug?>" >-->
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Model Year <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="model_year" placeholder="i.e 2024" value="<?=@$row->model_year?>" required>
                                </div>
                                
                                
                                
                                <div class="col-md-3">
                                    <label class="form-label" style="display: flex;justify-content: space-between;"><span>Brochure <span class="text-danger">*</span></span> 
                                        <?php if(!empty($row)){ ?>
                                            <span><a class="badge badge-gradient-secondary" href="<?=base_url('upload/'.$row->brochure) ?>" download="<?=$row->name ?>">Download</a></span>
                                        <?php } ?>
                                    </label>
                                    <input class="form-control upload-single-image" type="file" name="brochure" accept="application/pdf,application/vnd.ms-excel" >
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Mileage <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="mileage" id="mileage" placeholder="i.e 114 kmph" value="<?=@$row->mileage?>" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Displacement <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="displacement" id="displacement" placeholder="i.e 155 cc" value="<?=@$row->displacement?>" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Kilometres Per Litre <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="kilometres" id="kilometres" placeholder="i.e 56.87 kmpl" value="<?=@$row->kilometres?>" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Range <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="ranges" id="range" placeholder="i.e 323 km/charge" value="<?=@$row->ranges?>" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Per Hour <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="per_hour" id="per_hour" placeholder="i.e 155 km/Hr" value="<?=@$row->per_hour?>" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Charging Time <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="charging_time" id="charging_time" placeholder="i.e 7.9 Hr" value="<?=@$row->charging_time?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Front Break <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="front_break" id="front_break" placeholder="i.e Drum" value="<?=@$row->front_break?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Back Break <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="back_break" id="back_break" placeholder="i.e Drum" value="<?=@$row->back_break?>" required>
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label">Colour (Multiples) <span class="text-danger">*</span></label>
                                    <select class="form-control" name="color[]" id="color" multiple>
                                        <option value="">Select</option>
                                        <?php
                                            $cateList = $db->table('color')->get()->getResultObject();
                                            foreach ($cateList as $key => $value) {
                                                $selected = '';
                                                $rowFeatue = [];
                                                if(!empty($row))
                                                {
                                                    if(json_decode($row->color))
                                                    {
                                                        if(in_array($value->id, json_decode($row->color)))
                                                            $selected = 'selected';
                                                    }
                                                }
                                        ?>
                                            <option value="<?=$value->id ?>" <?= $selected?> ><?=$value->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                
                                
                                <div class="row gy-2 bg-light mx-0 py-3 mt-3" id="petrol-section">
                                <div class="col-12"><h6 class="mb-1 text-uppercase ps-2" style="letter-spacing:1.5px;border-left:3px solid #ED1C24;">Vechile Features:</h6></div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Max Power <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="max_power" id="max_power" placeholder="i.e 8.42 PS @ 6500 rpm" value="<?=@$row->max_power?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Max Torque <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="max_torque" id="max_torque" placeholder="i.e 10.2 Nm @ 5000 rpm" value="<?=@$row->max_torque?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fuel Capacity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="fuel_capacity" id="fuel_capacity" placeholder="i.e 5.3 L" value="<?=@$row->fuel_capacity?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Engine Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="engine_type" id="engine_type" placeholder="i.e 4- Stroke, 1-Cylinder, Air Cooled" value="<?=@$row->engine_type?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Clock <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="clock" id="clock" placeholder="i.e Yes" value="<?=@$row->clock?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">LED Tail Light <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="led_tail_light" id="led_tail_light" placeholder="i.e Yes" value="<?=@$row->led_tail_light?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Speedometer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="speedometer" id="speedometer" placeholder="i.e Digital" value="<?=@$row->speedometer?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Odometer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="odometer" id="odometer" placeholder="i.e Digital" value="<?=@$row->odometer?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tripmeter <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tripmeter" id="tripmeter" placeholder="i.e Digital" value="<?=@$row->tripmeter?>" >
                                </div>
                                </div>
                                
                                
                                <div class="row gy-2 bg-light mx-0 py-3 mt-3" id="electric-section">
                                <div class="col-12"><h6 class="mb-1 text-uppercase ps-2" style="letter-spacing:1.5px;border-left:3px solid #ED1C24;">E-Vechile Features:</h6></div>
                                <div class="col-md-3">
                                    <label class="form-label">Battery Capacity <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="battery_capacity" id="battery_capacity" placeholder="i.e 7.1 Kwh" value="<?=@$row->battery_capacity?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kerb Weight <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kerb_weight" id="kerb_weight" placeholder="i.e 197 kg" value="<?=@$row->kerb_weight?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Acceleration(0-100) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="acceleration" id="acceleration" placeholder="i.e 7.8s" value="<?=@$row->acceleration?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Battery Warranty <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="battery_warranty" id="battery_warranty" placeholder="i.e 5 Years or 1,00,000 Km" value="<?=@$row->battery_warranty?>" >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tyre Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tyre_type" id="tyre_type" placeholder="i.e Tubeless" value="<?=@$row->tyre_type?>" >
                                </div>
                                </div>


                            <div class="row g-3 mt-0">
                                <div class="col-md-6">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="i.e Yamaha MT 15 V2.0" value="<?=@$row->name?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="slug" placeholder="i.e yamaha-mt-15-v2" value="<?=@$row->slug?>" >
                                </div>

                                <div class="col-lg-12">
                                    <label class="form-label">Sort Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="sort_description" placeholder="i.e The XTEC version of India’s favourite commuter is available in two variants and four colour schemes. Check out images, specs, and user reviews at BikeKing." rows="3" required><?=@$row->sort_description?></textarea>
                                </div>
                            </div>
                            
                                <div class="col-lg-12">
                                    <label class="form-label">Bike Image (Upload Multiples) <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">


                                        <?php
                                             $file_data = array(
                                                 "position"=>1,
                                                 "columna_name"=>"images",
                                                 "multiple"=>true,
                                                 "accept"=>'image/*',
                                                 "col"=>"col-md-2",
                                                 "alt_text"=>"none",
                                                 "row"=>$row,
                                             );
                                        ?>
                                        <?=view('upload-multiple/index',compact('file_data','db'))?>
                                    

                                        
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                <div class="col-md-6">
<!-- Accordion Flush Example -->
<div class="accordion" id="accordionFlushExample">
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-1">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-1" aria-expanded="false" aria-controls="flush-collapse-1">
                Engine and Transmission
            </button>
        </h2>
        <div id="flush-collapse-1" class="accordion-collapse collapse" aria-labelledby="flush-heading-1"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>1,
                                 "columna_name"=>"engine",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
                Features
            </button>
        </h2>
        <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>2,
                                 "columna_name"=>"features",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading3">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse3" aria-expanded="false" aria-controls="flush-collapse3">
                Features and Safety
            </button>
        </h2>
        <div id="flush-collapse3" class="accordion-collapse collapse" aria-labelledby="flush-heading3"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>3,
                                 "columna_name"=>"features_safety",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-4">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-4" aria-expanded="false" aria-controls="flush-collapse-4">
                Mileage and Performance
            </button>
        </h2>
        <div id="flush-collapse-4" class="accordion-collapse collapse" aria-labelledby="flush-heading-4"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>4,
                                 "columna_name"=>"mileage_performance",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-5">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-5" aria-expanded="false" aria-controls="flush-collapse-5">
                Chassis and Suspension
            </button>
        </h2>
        <div id="flush-collapse-5" class="accordion-collapse collapse" aria-labelledby="flush-heading-5"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>5,
                                 "columna_name"=>"chassis_suspension",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-6">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-6" aria-expanded="false" aria-controls="flush-collapse-6">
                Dimensions and Capacity
            </button>
        </h2>
        <div id="flush-collapse-6" class="accordion-collapse collapse" aria-labelledby="flush-heading-6"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>6,
                                 "columna_name"=>"dimensions_capacity",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-7">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-7" aria-expanded="false" aria-controls="flush-collapse-7">
                Electricals
            </button>
        </h2>
        <div id="flush-collapse-7" class="accordion-collapse collapse" aria-labelledby="flush-heading-7"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>7,
                                 "columna_name"=>"electricals",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-8">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-8" aria-expanded="false" aria-controls="flush-collapse-8">
                Tyres and Brakes
            </button>
        </h2>
        <div id="flush-collapse-8" class="accordion-collapse collapse" aria-labelledby="flush-heading-8"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>8,
                                 "columna_name"=>"tyres_brakes",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-9">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-9" aria-expanded="false" aria-controls="flush-collapse-9">
                Performance
            </button>
        </h2>
        <div id="flush-collapse-9" class="accordion-collapse collapse" aria-labelledby="flush-heading-9"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>9,
                                 "columna_name"=>"performance",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-10">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-10" aria-expanded="false" aria-controls="flush-collapse-10">
                Motor & Battery
            </button>
        </h2>
        <div id="flush-collapse-10" class="accordion-collapse collapse" aria-labelledby="flush-heading-10"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>10,
                                 "columna_name"=>"motor_battery",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-11">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-11" aria-expanded="false" aria-controls="flush-collapse-11">
                Underpinnings
            </button>
        </h2>
        <div id="flush-collapse-11" class="accordion-collapse collapse" aria-labelledby="flush-heading-11"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>11,
                                 "columna_name"=>"underpinnings",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-12">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-12" aria-expanded="false" aria-controls="flush-collapse-12">
                What’s Included
            </button>
        </h2>
        <div id="flush-collapse-12" class="accordion-collapse collapse" aria-labelledby="flush-heading-12"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>12,
                                 "columna_name"=>"included",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="accordion-item material-shadow">
        <h2 class="accordion-header" id="flush-heading-13">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapse-13" aria-expanded="false" aria-controls="flush-collapse-13">
                App Features
            </button>
        </h2>
        <div id="flush-collapse-13" class="accordion-collapse collapse" aria-labelledby="flush-heading-13"
            data-bs-parent="#accordionFlushExample">
            <div class="accordion-body pb-1">
                <div class="row g-3">
                    <div class="col-md-12">
                        <?php
                            $file_data = array(
                                 "position"=>13,
                                 "columna_name"=>"app_features",
                                 "multiple"=>true,
                                 "alt_text"=>true,
                                 "row"=>@$row,
                            );
                            echo view('upload-multiple/feature',compact('file_data'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>        

                                </div>
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <?=view('backend/meta') ?>
                                        
                                <div class="col-md-6">
                                    <label class="form-label">Status: New Variant <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="is_new_variant" data-minimum-results-for-search="Infinity" required>
                                        <option value="0" <?php if(!empty(@$row) && @$row->is_new_variant==0) echo'selected' ?> >No</option>
                                        <option value="1" <?php if(!empty(@$row) && @$row->is_new_variant==1) echo'selected' ?> >Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status: Upcoming <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="is_upcoming" data-minimum-results-for-search="Infinity" required>
                                        <option value="0" <?php if(!empty(@$row) && @$row->is_upcoming==0) echo'selected' ?> >No</option>
                                        <option value="1" <?php if(!empty(@$row) && @$row->is_upcoming==1) echo'selected' ?> >Yes</option>
                                    </select>
                                </div>
                                
                                    </div>
                                </div>
                                
                                </div>
                               
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



<script>
    $(document).on("change", "#fuel_type", function(e) {
        changeFuelType();
    });
    function changeFuelType() 
    {
        $("#body_type, #mileage, #displacement, #kilometres, #vehicle_type, #tworange, #biketime, #feature, #range, #per_hour, #charging_time").parent().hide();
        $("#body_type, #mileage, #displacement, #kilometres, #vehicle_type, #tworange, #biketime, #feature, #range, #per_hour, #charging_time").attr("required", false);

        $("#electric-section").hide();
        $("#petrol-section").hide();

        var fuel_type = $("#fuel_type").val();
        if(fuel_type==1)
        {
            $("#body_type, #mileage, #displacement, #kilometres").parent().show();
            $("#body_type, #mileage, #displacement, #kilometres").attr("required", true);

            $("#petrol-section").show();
        }
        else if(fuel_type==2)
        {
            $("#vehicle_type, #tworange, #biketime, #feature, #range, #per_hour, #charging_time").parent().show();
            $("#vehicle_type, #tworange, #biketime, #feature, #range, #per_hour, #charging_time").attr("required", true);

            $("#electric-section").show();
        }
    }
    changeFuelType();

</script>



<?=view('backend/include/footer') ?>