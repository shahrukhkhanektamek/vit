<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th>Date </th>            
            <th>User Name</th>
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
                <td><?=@$value->only_date?></td>
                <td><?=@$value->name?></td>
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
