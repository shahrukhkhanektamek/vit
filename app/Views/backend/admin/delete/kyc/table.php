<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Kyc Date</th>
            <th data-ordering="false">Image</th>
            <th data-ordering="false">Name</th>
            <th data-ordering="false">Number</th>
            <th data-ordering="false">Email</th>
            <th data-ordering="false">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) {

        ?>
            <tr>
                <td><?=date("d M, Y h:i A", strtotime($value->add_date_time)) ?></td>
                <td><?=$value->image?></td>
                <td><?=$value->name?></td>
                <td><?=$value->phone?></td>
                <td><?=$value->email?></td>
                <td>
                    <?php if($value->kyc_step==1){ ?>
                        <span class="badge bg-success">KYC Complete</span>
                    <?php }else if($value->kyc_step==2){ ?>                    
                        <span class="badge bg-info">KYC Under Review</span>
                    <?php }else if($value->kyc_step==3){ ?>
                        <span class="badge bg-warning">KYC Rejected</span>
                    <?php }else if($value->kyc_step==0){ ?>
                        <span class="badge bg-info">KYC Not Update</span>
                    <?php } ?>
                </td>
                <td>
                    <a href="<?=$data['route'].'/view/'.encript($value->id)?>" class="btn btn-sm btn-outline-primary btn-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="ri-eye-fill"></i></a>
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
