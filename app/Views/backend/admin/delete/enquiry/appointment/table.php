<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Date Time</th>
            <th data-ordering="false">Name</th>
            <th data-ordering="false">Email</th>
            <th data-ordering="false">Mobile Number</th>
            <th data-ordering="false">State</th>
            <th data-ordering="false">Partner Detail</th>
            <th data-ordering="false">Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) { ?>       
            <tr>
                <td>
                    <?=date("d M, Y", strtotime($value->add_date_time))?> <?=date("h:i A", strtotime($value->add_date_time))?>
                </td>
                <td><?=$value->name?></td>
                <td><?=$value->email?></td>
                <td><?=$value->phone?></td>
                <td><?=$value->state_name?></td>
                <td>
                    
                    <b>Partner Name: </b><?=$value->partner_name ?><br>
                    <b>Partner Phone: </b><?=$value->partner_phone ?><br>
                    <b>Partner Email: </b><?=$value->partner_email ?><br>
                    <?php if($value->is_view==1){ ?>
                        <span class="badge btn btn-success">Scratched</span>
                    <?php }else{ ?>
                        <span class="badge btn btn-danger">Not Scratch</span>
                    <?php } ?>

                </td>
                <td>
                    <!-- <a href="<?=$data['route'].'/view/'.encript($value->id)?>" class="btn btn-sm btn-outline-primary btn-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="ri-eye-line"></i></a> -->

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
