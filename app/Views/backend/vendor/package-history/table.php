<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Date Time</th>
            <th data-ordering="false">Plan Name</th>
            <th data-ordering="false">Price</th>
            <th data-ordering="false">Package</th>
            <th data-ordering="false">Transaction Id.</th>
            <th data-ordering="false">Status</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) { ?>       
            <tr>
                <td>
                    <?=date("d M, Y", strtotime($value->add_date_time))?> <?=date("h:i A", strtotime($value->add_date_time))?>
                </td>
                <td><?=@$value->package_name?></td>
                <td><?=@$value->final_amount?></td>
                <td><?=@$value->validity?> Month<br>
                    <p class="m-0"><b>Start Date:</b> <?=date("d M, Y h:i A", strtotime($value->plan_start_date_time)) ?></p>
                    <p class="m-0"><b>Expiry Date:</b> <?=date("d M, Y h:i A", strtotime($value->plan_end_date_time)) ?></p>
                </td>
                <td><?=@$value->transaction_id?></td>
                <td>
                    <?php if($value->status==1){ ?>
                        <span class="badge btn btn-success">PAID</span>
                    <?php }else{ ?>
                        <span class="badge btn btn-danger">UNPAID</span>
                    <?php } ?>
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
