<?=view("web/include/header"); ?>
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Leads</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Leads</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<?=view("partner/nav"); ?>
						
						<div class="col-md-7 col-lg-8 col-xl-9" id="data-list">
							
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->


<script>
   var data = '';
   var main_url = "<?=base_url(route_to('partner.appointment.load_data'))?>";

    function get_url_data()
    {
        var status = 1;
        var order_by = 'desc';
        var limit = 12;
        var filter_search_value = '';
        data = `status=${status}&order_by=${order_by}&limit=${limit}&filter_search_value=${filter_search_value}`;
    }
    get_url_data();
    url = main_url+'?'+data;
    load_table_data();


   $(document).on("click", ".pagination a",(function(e) {      
      event.preventDefault();
      get_url_data()
      url = $(this).attr("href")+'&'+data;
      load_table_data();
   }));

   function load_table_data()
   {
        data_loader("#data-list",1);
        var form = new FormData();
        var settings = {
          "url": url,
          "method": "GET",
          "timeout": 0,
          "processData": false,
          "headers": {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
           },
          "mimeType": "multipart/form-data",
          "contentType": false,
          "dataType": "json",
          "data": form
        };
        $.ajax(settings).always(function (response) {
            data_loader("#data-list",0);
            response = admin_response_data_check(response);
            $("#data-list").html(response.data.list);

        });
   }

 
</script>



<script>

$(document).on("click", ".scratch-appointment",(function(e) {      
    event.preventDefault();
    var id = $(this).data('id');
    loader("show");
    var form = new FormData();
    form.append("id", id);
    
    var settings = {
      "url": "<?=base_url(route_to('partner.appointment.scratch'))?>",
      "method": "POST",
      "timeout": 0,
      "processData": false,
      "headers": {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
       },
      "mimeType": "multipart/form-data",
      "contentType": false,
      "dataType": "json",
      "data": form
    };
    $.ajax(settings).always(function (response) {
        loader("hide");
        response = admin_response_data_check(response);
        if(response.status==200)
        {
            $("#rowapname"+id).html(response.data.name)
            $("#rowapemail"+id).html(response.data.email)
            $("#rowapphone"+id).html(response.data.phone)                
            $("#rowapbuttron"+id).remove()                
        }
        

    });
}));
</script>

<?=view("web/include/footer"); ?>