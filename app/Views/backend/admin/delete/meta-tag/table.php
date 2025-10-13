<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Page URL</th>
            <th data-ordering="false">Page Name</th>
            <th data-ordering="false">Meta Author</th>
            <th data-ordering="false">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value){ ?>
            <tr>
                <td><?=$value->slug?></td>
                <td><?=$value->page_name?></td>
                <td><?=$value->meta_author?></td>
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
