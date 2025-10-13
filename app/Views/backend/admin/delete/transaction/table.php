<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Date Time</th>
            <th data-ordering="false">User Name</th>
            <th data-ordering="false">User Email</th>
            <th data-ordering="false">User Phone</th>
            <th data-ordering="false">Amount</th>
            <th data-ordering="false">Transaction Id.</th>
            <th data-ordering="false">Payment Status</th>
            <!--<th data-ordering="false">Action</th>-->
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) {
            $user = $db->table("users")->where(["id"=>$value->user_id,])->get()->getFirstRow();
            $p_id = json_decode($value->detail)[0]->p_id;
            $product = $db->table("product")->where(["id"=>$p_id,])->get()->getFirstRow();
         ?>       
            <tr>
                <td>
                    <?=date("d M, Y", strtotime($value->add_date_time))?><br>
                    <small><?=date("h:i A", strtotime($value->add_date_time))?></small>
                </td>
                <td><?=@$user->name?></td>
                <td><?=@$user->email?></td>
                <td><?=@$user->phone?></td>
                
                <td><?=price_formate(@$value->final_amount)?></td>
                <td>                    
                    <?=@$value->transaction_id?>
                </td>
                <td>
                    <?php if($value->status==1){ ?>
                        <span class="badge btn btn-success">PAID</span>
                    <?php }else{?>
                        <span class="badge btn btn-danger">UNPAID</span>
                    <?php } ?>
                    <span class="badge btn btn-dark text-uppercase"><?=$value->payment_type_text ?></span>
                    <span class="badge btn btn-info text-uppercase"><?=$value->payment_by ?></span>
                </td>
                <!--<td>-->
                <!--    <a href="<?//=$data['route'].'/view/'.encript($value->id)?>" class="btn btn-sm btn-outline-primary btn-icon waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i class="ri-eye-line"></i></a>-->

                <!--    <a href="<?//=$data['route'].'/delete/'.encript($value->id)?>" class="btn btn-sm btn-danger btn-icon waves-effect waves-light remove-item-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="ri-delete-bin-4-line"></i></a>-->
                <!--</td>-->
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
