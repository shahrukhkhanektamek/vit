    <footer class="footer">
                <div class="container-fluid">
                    <div class="row justify-content-end">
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                <script>document.write(new Date().getFullYear())</script> © <?=env('APP_NAME')?>.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Account Disable Modal -->
    <div class="modal fade zoomIn" id="accountBlock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-4" id="accountBlockBodyDisable">
                    <lord-icon src="https://cdn.lordicon.com/urmrbzpi.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-2">
                        <h4 class="mb-1">Are you sure?</h4>
                        <p class="text-muted mb-4">Are you sure you want to disable this account? You will be able to revert this!</p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <a href="javascript:void(0);" class="btn btn-danger block-ok">Yes, disable it!</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body text-center p-3 pb-4" id="accountBlockBodyEnable">
                    <lord-icon src="https://cdn.lordicon.com/awmkozsb.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-2">
                        <h4 class="mb-1">Are you sure?</h4>
                        <p class="text-muted mb-4">Are you sure you want to enable this account? You will be able to revert this!</p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <a href="javascript:void(0);" class="btn btn-danger block-ok">Yes, enable it!</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

   

    <!-- Delete Confirm Modal -->
    <div class="modal fade zoomIn" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center p-3 pb-4">
                    <lord-icon src="https://cdn.lordicon.com/usownftb.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px"></lord-icon>
                    <div class="mt-2">
                        <h4 class="mb-1">Are you sure?</h4>
                        <p class="text-muted mb-4">Are you sure you want to delete this account? You won't be able to revert this!</p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <a href="javascript:void(0);" class="btn btn-danger delete-ok">Yes, delete it!</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <!-- transfer Modal -->
    <div class="modal fade zoomIn" id="transferModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body text-start p-3 pb-4">
                    <select class="select1" id="select-vendor">
                        <option>Select Vendor</option>
                    </select>
                    <div class="hstack gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <a href="javascript:void(0);" class="btn btn-danger transfer-now">Transfer Now</a>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?=base_url('public/')?>/assetsadmin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url('public/')?>/assetsadmin/libs/simplebar/simplebar.min.js"></script>
    <script src="<?=base_url('public/')?>/assetsadmin/libs/node-waves/waves.min.js"></script>
    <script src="<?=base_url('public/')?>/assetsadmin/libs/feather-icons/feather.min.js"></script>
    <script src="<?=base_url('public/')?>/assetsadmin/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?=base_url('public/')?>/assetsadmin/js/plugins.js"></script>

    <!-- calendar min js -->
    <script src="<?=base_url('public/')?>/assetsadmin/libs/fullcalendar/index.global.min.js"></script>
    <!-- Calendar init -->
    <script src="<?=base_url('public/')?>/assetsadmin/js/pages/calendar.init.js"></script>
    <!-- Modern colorpicker bundle -->
    <script src="<?=base_url('public/')?>/assetsadmin/libs/@simonwep/pickr/pickr.min.js"></script>
    <!-- init js -->
    <script src="<?=base_url('public/')?>/assetsadmin/js/pages/form-pickers.init.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->

    <!--datatable js-->
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
    <!-- <script src="<?=base_url('public/')?>/assetsadmin/js/pages/datatables.init.js"></script> -->

    <!--select2 cdn-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script> -->
    <!-- <script src="<?=base_url('public/')?>/assetsadmin/js/pages/select2.init.js"></script> -->
    <!-- <script src="<?=base_url('public/')?>/assetsadmin/js/pages/form-validation.init.js"></script> -->
    <!-- password-addon init -->
    <!-- <script src="<?=base_url('public/')?>/assetsadmin/js/pages/passowrd-create.init.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/intlTelInput.js"></script> -->

    <!-- profile-setting init js -->
    <!-- <script src="<?=base_url('public/')?>/assetsadmin/js/pages/profile-setting.init.js"></script> -->
    <!-- App js -->
    <script src="<?=base_url('public/')?>/assetsadmin/js/app.js"></script>






<script src="<?=base_url('public/')?>/toast/saber-toast.js"></script>
<script src="<?=base_url('public/')?>/toast/script.js"></script>
<script src="<?=base_url('public/')?>/assetsadmin/select2/js/select2.full.min.js"></script>

<script>
    

$(".ui-sortable").sortable();

$("select").select2();
$('.tags').select2({
  tags: true,
  tokenSeparators: ['||', '\n']
});
    
function copyDivText(divId) {
  // Div ko select karo
  var text = document.getElementById(divId).innerText;

  // Clipboard API se copy karo
  navigator.clipboard.writeText(text).then(function() {
    // alert("Copied: " + text);
  }).catch(function(err) {
    console.error("Failed to copy: ", err);
  });
}


$(document).on('click',".logout",function (e) {
  event.preventDefault();
  loader('show');
  $.ajax({
      url:"<?=base_url(route_to('auth.logout'))?>",
      type:"GET",
      dataType:"json",
      success:function(d)
      {
        admin_response_data_check(d)  
      },
      error: function(e) 
    {
      admin_response_data_check(e)
    } 
  });
});

$(".upload-single-image").on('change', function(){
  var files = [];
  var j=1;
  var upload_div = $(this).data("target");
  var name = $(this).data('name');
            console.log(upload_div);
  $( "."+upload_div ).empty();
    for (var i = 0; i < this.files.length; i++)
    {
        if (this.files && this.files[i]) 
        {
            var reader = new FileReader();
            reader.onload = function (e) {
            $('.'+upload_div).attr("src",e.target.result);
            j++;
        }
        reader.readAsDataURL(this.files[i]);
    }
  }      
});


var path = window.location.href;
$(".nav-link").each(function() {
    if (this.href === path) {
        $(this).addClass("active");
        $(this).parent().parent().parent().addClass("show");
        $(this).parent().parent().parent().parent().parent().parent().addClass("show");
        $(this).parent().parent().parent().parent().children('a').attr('aria-expanded',true);
        $(this).parent().parent().parent().parent().parent().parent().parent().children('a').attr('aria-expanded',true);
    }
});
</script>







<script type="text/javascript">
$(document).ready(function () {
  $(".minus").click(function () {
    var $input = $(this).parent().find(".product-quantity");
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });
  $(".plus").click(function () {
    var $input = $(this).parent().find(".product-quantity");
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });
});
</script>



<script>


    $(document).on("click", ".multiple-image-link .add-btn",(function(e) {    
        var html =  ``;
        var target = $(this).data("target");
        var alt = $(this).data('alt_text');
        var cname = $(this).data('cname');
        html= `
            <li>
                <div class="input-group mt-2">                    
                    <input type="text" class="form-control image_alt" name="title${cname}[]" placeholder="Feature Title" value="">
                    <input type="text" class="form-control image_alt" name="value${cname}[]" placeholder="Feature Output" value="">                 
                    <button class="btn btn-danger material-shadow-none remove-btn" type="button" ><i class="ri-subtract-line"></i></button>
                </div>
            </li>
        `;
        $("#"+target).append(html);            
    }));

    $(document).on("click", ".multiple-image-link .remove-btn",(function(e) {    
        $(this).closest('li').remove();        
    }));



    $('#select-vendor').select2({
      ajax: {
        url: "<?=base_url(route_to('search-vendor'))?>",
        method:"post",
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public'
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });
    $('#select-all-partner').select2({
      ajax: {
        url: "<?=base_url(route_to('search-partner'))?>",
        method:"post",
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public'
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });
    $('#select-all-user').select2({
      ajax: {
        url: "<?=base_url(route_to('search-user'))?>",
        method:"post",
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public'
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });
    $('#select-all-employee').select2({
      ajax: {
        url: "<?=base_url(route_to('search-employee'))?>",
        method:"post",
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public'
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });

    $('#country').select2({
      ajax: {
        url: "<?=base_url(route_to('search-country'))?>",
        method:"post",
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public'
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });
    $('#select-state').select2({
      ajax: {
        url: "<?=base_url(route_to('search-state'))?>",
        method:"post",
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public',
            id:$("#country").val()
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });

    $('#select-city').select2({
      ajax: {
        url: "<?=base_url(route_to('search-city'))?>",
        method:"post",
        "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public'
          }

          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });
</script>



</body>
</html>