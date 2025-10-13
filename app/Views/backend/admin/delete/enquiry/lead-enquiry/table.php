<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Date Time</th>
            <th data-ordering="false">User Details</th>
            <th data-ordering="false">Service&nbsp;Details</th>
            <th data-ordering="false">Partner Detail</th>
            <th data-ordering="false">Employee Detail</th>
            <th data-ordering="false">Status</th>
            <!--<th data-ordering="false">URL</th>-->
            <th data-ordering="false">Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) { ?>       
            <tr>
                <td>
                    <?=date("d M, Y", strtotime($value->add_date_time))?><br>
                    <small><?=date("h:i A", strtotime($value->add_date_time))?></small>
                </td>
                <td>
                    <b>Name: </b><?=$value->name?><br>
                    <b>Email: </b><?=$value->email?><br>
                    <b>Phone: </b><?=$value->phone?><br>
                    <b>State: </b><?=$value->state_name?><br>
                </td>
                <td>
                    <b>Service Name: </b><?=$value->service_name?><br>
                </td>
                <td>
                    <b>Lead For: </b><span class="badge btn btn-info"><?=$value->service_type_name ?></span><br>
                    <?php if(!empty($value->partner_name)){ ?>
                        <b>Partner Name: </b><?=$value->partner_name?><br>
                        <b>Partner Phone: </b><?=$value->partner_phone?><br>
                        <b>Partner Email: </b><?=$value->partner_email?><br>
                        <?php if($value->is_view){ ?>
                            <span class="badge btn btn-success">Scratch</span>
                        <?php }else{?>
                            <span class="badge btn btn-danger">Not Scratch</span>
                        <?php } ?>
                    <?php }else{?>
                        <span class="badge btn btn-danger">Not Transfer Yet</span>                    
                    <?php } ?>
                </td>
                <td>
                    <?php if(!empty($value->employee_name)){ ?>
                        <b>Employee Name: </b><?=$value->employee_name?><br>
                        <b>Employee Phone: </b><?=$value->employee_phone?><br>
                        <b>Employee Email: </b><?=$value->employee_email?><br>
                    <?php }else{?>
                        <span class="badge btn btn-danger">Not Assign Yet</span>                    
                    <?php } ?>
                </td>
                <td><?=lead_status($value->followup_status) ?></td>
                <td>
                    <a data-id="<?=encript($value->id) ?>" class="w-xs mt-1 btn btn-sm btn-outline-primary btn-icon waves-effect transfer-modal-open" data-bs-toggle="tooltip" data-bs-placement="top" title="Share to Showroom"><i class="ri-share-forward-line"></i> &nbsp;Transfer</a>

                    <a data-id="<?=encript(@$value->id)?>" class="w-xs mt-1 btn btn-sm btn-outline-primary btn-icon waves-effect assign-lead" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Comment"><i class="ri-share-forward-fill"></i> &nbsp;Assign</a>

                    <a data-id="<?=encript(@$value->id)?>" class="w-xs mt-1 btn btn-sm btn-outline-primary btn-icon waves-effect add-status" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Comment"><i class="ri-add-fill"></i> &nbsp;Comment</a>

                    <a data-id="<?=encript(@$value->id)?>" class="w-xs mt-1 btn btn-sm btn-outline-primary btn-icon waves-effect load-timeline" data-bs-toggle="tooltip" data-bs-placement="top" title="TimeLine"><i class="ri-time-line"></i> &nbsp;TimeLine</a>

                    <!-- <a href="<?=$data['route'].'/delete/'.encript($value->id)?>" class="btn btn-sm btn-danger btn-icon waves-effect waves-light remove-item-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ri-delete-bin-4-line"></i></a> -->
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
