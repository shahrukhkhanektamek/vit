<table id="buttons-datatables1" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <th data-ordering="false">Date Time</th>
            <th data-ordering="false">Name</th>
            <th data-ordering="false">Email</th>
            <th data-ordering="false">Mobile Number</th>
            <th data-ordering="false">Bike ID.</th>
            <th data-ordering="false">Bike Name</th>
            <th data-ordering="false">Booking Amount</th>
            <th data-ordering="false">Action</th>
        </tr>
    </thead>
    <tbody>


        <?php foreach($data_list as $key=> $value) { ?>       
            <tr>
                <td>
                    <?=date("d M, Y", strtotime($value->add_date_time))?> <?=date("h:i A", strtotime($value->add_date_time))?>
                </td>
                <td id="rowname<?=encript($value->id) ?>"><?=$value->name?></td>
                <td id="rowemail<?=encript($value->id) ?>"><?=$value->email?></td>
                <td id="rowphone<?=encript($value->id) ?>"><?=$value->phone?></td>
                <td><?=$value->bike_id?></td>
                <td>
                    <?=$value->bike_name?><br>
                    Bike Color: <?=$value->color_name?>                    
                </td>
                <td><?=price_formate($value->amount)?></td>
                <td>
                    <a class="btn btn-sm btn-outline-primary waves-effect scratch-lead" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to enable email and contact details" data-id="<?=encript($value->id) ?>"><i class="ri-eye-line"></i> Scratch Lead</a>

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
