<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Reg.&nbsp;Date</th>
            <th data-ordering="false">Showroom&nbsp;Information</th>
            <th data-ordering="false">Dealer&nbsp;Contact</th>
            <th data-ordering="false">GST&nbsp;No</th>
            <th data-ordering="false">Available&nbsp;Brands</th>
            <th data-ordering="false">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) { ?>
            <tr>
                <td><?=date("d M, Y h:i A", strtotime($value->add_date_time)) ?></td>
                <td>
                    <?=$value->company_name?><br>
                    <small><i class="ri-map-pin-line"></i> <?=@$value->area?>, <?=@$value->city_name?></small>
                </td>
                
                <td>
                    <?=$value->name?><br>
                    <small class="d-block"><i class="ri-mail-open-line"></i> <?=$value->email?></small>
                    <small><i class="ri-phone-line"></i> <?=$value->phone?></small>
                </td>
                <td><?=$value->gst?></td></td>
                <td>
                    <?php
                    $brand_names = explode(",", $value->brand_names);
                    foreach ($brand_names as $key2 => $value2) { ?>
                        <span class="badge bg-primary-subtle text-primary"><?=$value2 ?></span>
                        
                    <?php } ?>
                </td>
                <td><?=status_get($value->status)?></td>
                <td>
                    <div class="btn-group">
                        <a href="<?=$data['route'].'/edit/'.encript($value->id)?>" class="btn btn-sm btn-outline-primary btn-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="ri-ball-pen-line"></i></a>

                    <a href="<?=$data['route'].'/block_unblock/'.encript($value->id)?>" data-value="<?=$value->status?>" class="btn btn-sm btn-outline-danger btn-icon waves-effect block-item-btn"  data-bs-placement="top" title="Disble"><i class="ri-settings-6-line"></i></a>

                    <a href="<?=$data['route'].'/delete/'.encript($value->id)?>" class="btn btn-sm btn-danger btn-icon waves-effect waves-light remove-item-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ri-delete-bin-4-line"></i></a>
                    </div>
                </td>
            </tr>
         <?php } ?>
            
    </tbody>
</table>

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
