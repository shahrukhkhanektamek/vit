<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Name</th>
            <th data-ordering="false">Price</th>
            <th data-ordering="false">Discount(%) </th>
            <th data-ordering="false">Final Price</th>
            <th data-ordering="false">Validity</th>
            <th data-ordering="false">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) { ?>
            <tr>
                <td><?=$value->name?></td>
                <td><?=price_formate($value->price)?></td>
                <td><?=$value->discount?></td>
                <td><?=price_formate($value->final_price)?></td>
                <td><?=$value->validation?> Months</td>
                <!-- <td><img class="img-thumbnail" src="<?=image_check($value->image)?>" style="width: auto;height: 45px;"></td> -->
                <td><?=status_get($value->status)?></td>
                <td>
                    <a href="<?=$data['route'].'/edit/'.encript($value->id)?>" class="btn btn-sm btn-outline-primary btn-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="ri-ball-pen-line"></i></a>

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
