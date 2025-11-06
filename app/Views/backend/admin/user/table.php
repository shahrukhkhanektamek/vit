<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Registered Date</th>
            <th data-ordering="false">Image</th>
            <th data-ordering="false">Roll NO.</th>
            <th data-ordering="false">Reg No.</th>
            <th data-ordering="false">User Name</th>
            <th data-ordering="false">Phone Number</th>
            <th data-ordering="false">Email Address</th>
            <th data-ordering="false">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) { ?>
            <tr>
                <td><?=date("d M, Y h:i A", strtotime($value->add_date_time)) ?></td>
                <td><img class="img-thumbnail" src="<?=image_check($value->image)?>" style="width: auto;height: 100px;"></td>
                <td><?=env('APP_SORT').$value->user_id?></td>
                <td><?=$value->reg_no?></td>
                <td><?=$value->name?></td>
                <td><?=$value->phone?></td>
                <td><?=$value->email?></td>
                <td><?=status_get($value->status)?></td>
                <td>
                    <a href="<?=$data['route'].'/edit/'.encript($value->id)?>" class="btn btn-sm btn-outline-primary btn-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="ri-ball-pen-line"></i></a>

                    <a href="<?=$data['route'].'/view/'.encript($value->id)?>" class="btn btn-sm btn-outline-primary btn-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="ri-eye-fill"></i></a>

                    <a href="<?=$data['route'].'/block_unblock/'.encript($value->id)?>" data-value="<?=$value->status?>" class="btn btn-sm btn-outline-danger btn-icon waves-effect block-item-btn"  data-bs-placement="top" title="Disble"><i class="ri-settings-6-line"></i></a>

                    <a href="<?=$data['route'].'/delete/'.encript($value->id)?>" class="btn btn-sm btn-danger btn-icon waves-effect waves-light remove-item-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ri-delete-bin-4-line"></i></a>
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
