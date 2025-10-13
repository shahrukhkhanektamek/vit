<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Bank Name</th>
            <th>Bank Holder Name</th>
            <th>Bank Account No. </th>
            <th>IFSC Code </th>
            <th>PanCard </th>
            <th>Phone </th>
            <th>Amount </th>
            <th>TDS </th>
            <th>Final Amount </th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) {
         ?>       
            <tr>
                <td><?=@$value->name?></td>
                <td><?=$value->bank_name ?></td>
                <td><?=$value->bank_holder_name ?></td>
                <td><?=$value->account_number ?></td>
                <td><?=$value->ifsc ?></td>
                <td><?=$value->pan ?></td>
                <td><?=@$value->phone?></td>
                
                <td><?=price_formate(@$value->amount)?></td>
                <td><?=price_formate(@$value->tds_amount)?></td>
                <td><?=price_formate(@$value->final_amount)?></td>
                            
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
