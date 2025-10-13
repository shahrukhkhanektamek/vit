
<div class="container-fluid" style="min-height: 320px;">
   <div class="profile-foreground position-relative mx-n4 mt-n15">
      <div class="profile-wid-bg"></div>
   </div>
   <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
      <div class="row g-4">
         <div class="col-auto">
            <div class="avatar-lg">
               <img src="<?=image_check($row->image,'user.png')?>" alt="user-img" class="img-thumbnail rounded-circle" />
            </div>
         </div>
         <!--end col-->
         <div class="col">
            <div class="p-2">
               <h3 class="text-white mb-1"><?=$row->name?></h3>
               <p class="text-white text-opacity-75 m-0">Phone: <?=$row->email?></p>
               <p class="text-white text-opacity-75 m-0">Email: <?=$row->phone?></p>
               <p class="text-white text-opacity-75 m-0">Country: <?=@$row->country_name?></p>
               <p class="text-white text-opacity-75 m-0">State: <?=@$row->state_name?></p>
               <p class="text-white text-opacity-75 m-0">City: <?=@$row->city?></p>
               <p class="text-white text-opacity-75 m-0">Partner Type: <?=@$row->role_name?></p>
               
            </div>
         </div>
         <!--end col-->
      </div>
      <!--end row-->
   </div>
   <!--end row-->
</div>