

        <?php foreach($data_list as $key=> $value) { ?>


            <div class="col-lg-4">
                <div class="card pricing-box ribbon-box right">
                    <div class="card-body p-4 m-2">
                        <div class="ribbon-two ribbon-two-danger"><span><?=$value->discount ?>% OFF</span></div>
                        <div>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-semibold"><?=$value->name ?></h5>
                                    <p class="text-muted mb-0"><?=$value->sub_name ?></p>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                        <i class="ri-medal-line fs-20"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <h2> <?=price_formate($value->final_price) ?><span class="fs-13 text-muted">/Month</span></h2>
                            </div>
                        </div>
                        <hr class="my-4 text-muted">
                        <div>
                            <?=$value->full_description ?>
                            <div class="mt-4">
                                <a href="<?=base_url('payment/create-transaction?p_id='.encript($value->id).'&type=1&user_id='.encript(session()->get('user')['id'])) ?>" class="btn btn-success w-100 waves-effect waves-light get_package1" data-id="<?=encript($value->id) ?>">Get started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



         <?php } ?>
            


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
