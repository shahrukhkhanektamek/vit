<?php 
$login_user = get_user();
echo view('backend/include/header');

$totalSubscription = 0;
foreach (my_plans($login_user->id) as $key => $value) {
    $plan_status = plan_status($login_user->id,$value->id);
    if($plan_status['status']) $totalSubscription++;    
}

?>
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="dashboard_style h-100">
                                <div class="row">

                                    
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card card-animate bg-primary">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-white-50 mb-0" style="color: white !important;">Active Subscription</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary text-white mb-2"><span class="counter-value" data-target="<?=$totalSubscription?>"></span></h4>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-white bg-opacity-25 rounded fs-2">
                                                                <i class="ri-message-2-line text-warning"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card card-animate bg-primary">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-white-50 mb-0" style="color: white !important;">Leads Enquiry</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary text-white mb-2"><span class="counter-value" data-target="<?=$db->table('vendor_enquiry_lead')->where(["vendor_id"=>session('user')['id'],])->countAllResults()?>"></span></h4>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-white bg-opacity-25 rounded fs-2">
                                                                <i class="ri-message-2-line text-warning"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-3 col-md-6">
                                            <div class="card card-animate bg-primary">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-medium text-muted text-white-50 mb-0" style="color: white !important;">Booking Enquiry</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                                        <div>
                                                            <h4 class="fs-22 fw-semibold ff-secondary text-white mb-2"><span class="counter-value" data-target="<?=$db->table('vendor_enquiry_booking')->where(["vendor_id"=>session('user')['id'],])->countAllResults()?>"></span></h4>
                                                        </div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-white bg-opacity-25 rounded fs-2">
                                                                <i class="ri-bookmark-2-line text-warning"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- end card body -->
                                            </div><!-- end card -->
                                        </div><!-- end col -->



                                        <?php
                                        foreach(my_plans($login_user->id) as $key=>$value){

                                            $today = date("Y-m-d H:i:s");
                                            $plan_status = plan_status($login_user->id,$value->id);
                                        ?>
                                                    <div class="col-xl-3 col-md-6">
                                                        <div class="card card-animate <?php if($plan_status['status']) echo'bg-success'; else echo'bg-danger'; ?>">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <p class="fw-medium text-uppercase text-white-50 mb-0">
                                                                            <?php if(!$plan_status['status']){ ?>
                                                                                Expired
                                                                            <?php } ?>

                                                                            <?php if($plan_status['status']){ ?>
                                                                                Active
                                                                            <?php } ?>
                                                                        Plan</p>

                                                                        <p class="fw-medium text-uppercase text-white fw-bold mb-0"><?=$value->package_name ?></p>                                                                       

                                                                        <?php if($plan_status['is_unlimited']){ ?>
                                                                            <h2 class="mt-2 ff-secondary fw-semibold text-white"> Unlimited</h2>
                                                                        <?php } ?>

                                                                        <p class="mb-0 text-white"><span class="badge bg-light text-primary mb-1"><i class="ri-calendar-2-line align-middle"></i> <?=$value->validity?>
                                                                         Month </span> Validity
                                                                        <br>Expire Date: <?=date("Y M, d",strtotime($value->plan_end_date_time))?>
                                                                        </p>
                                                                    </div>
                                                                    <div>
                                                                        <div class="avatar-sm flex-shrink-0">
                                                                            <span class="avatar-title 
                                                                            <?php if($plan_status['status']) echo'bg-success-subtle'; else echo'bg-danger-subtle'; ?> rounded-circle fs-2 material-shadow">
                                                                                <i class="<?php if($plan_status['status']) echo'ri-check-line text-success'; else echo'ri-close-line text-danger'; ?>"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- end card body -->
                                                        </div> <!-- end card-->
                                                    </div> <!-- end col-->
                                        <?php } ?>




                                        
                                    


                                </div> <!-- end row-->
                            </div> <!-- end .h-100-->
                        </div> <!-- end col -->
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
<?=view('backend/include/footer') ?>