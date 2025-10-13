<?=view("web/include/header"); ?>
<?php
$contact_detail = json_decode($db->table('setting')->getWhere(["name"=>'main',])->getRow()->data);
$user = get_user();
?>
<style>
.table tbody tr:last-child {
    border: 1px solid rgba(0, 0, 0, 0.05);
}
</style>		
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Appointment Invoice</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Appointment Invoice</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<div class="row">
						<div class="col-lg-8 offset-lg-2">
							<div class="invoice-content" id="invoiceDiv">
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-logo">
												<img src="<?=base_url() ?>assets/img/logo-black.png" alt="logo">
											</div>
										</div>
										<div class="col-md-6">
											<p class="invoice-details">
												<strong>Order:</strong> #<?=$row->invoice_id ?> <br>
												<strong>Issued:</strong> <?=date("d M Y h:i A", strtotime($row->add_date_time)) ?>
											</p>
										</div>
									</div>
								</div>
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-info">
												<strong class="customer-text">Invoice From</strong>
												<h2 class="m-0 p-0" style="font-size: 20px;"><?=env('APP_NAME')?></h2>
												<p class="invoice-details invoice-details-two">
													<?=$contact_detail->address ?>
												</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="invoice-info invoice-info2">
												<strong class="customer-text">Invoice To</strong>
												<p class="invoice-details">
													<?=$user->name ?> <br>
													<?=$user->address ?><br>
													
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-12">
											<div class="invoice-info">
												<strong class="customer-text">Payment Status</strong>
												<p class="invoice-details invoice-details-two">
													<?php if($row->payment_status==1){ ?>
														<span class="badge badge-success">PAID</span>
													<?php }else{ ?>
														<span class="badge badge-danger">UNPAID</span>
													<?php } ?>
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Item -->
								<div class="invoice-item invoice-table-wrap">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<?php
												$detail = json_decode($row->detail);
												?>
												<table class="invoice-table table table-bordered">
													<thead>
														<tr>
															<th>Description</th>
															<th class="text-center">Quantity</th>
															<th class="text-end">Sub Total</th>
															<th class="text-center">Gst</th>
															<th class="text-end">Total</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($detail as $key => $value) { ?>
															<tr>
																<td><?=$value->p_name ?></td>
																<td class="text-center"><?=$value->qty ?></td>
																<td class="text-end"><?=price_formate($value->amount) ?></td>
																<td class="text-center"><?=price_formate($value->gst) ?></td>
																<td class="text-end"><?=price_formate($value->final_amount) ?></td>
															</tr>
														<?php } ?>
														
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-6 col-xl-4" style="margin: 0 0 0 auto;">
											<div class="table-responsive" style="border: 1px solid rgba(0, 0, 0, 0.05);margin: 10px 0 0 0;">
												<table class="invoice-table-two table">
													<tbody>
													<tr>
														<th>Subtotal:</th>
														<td><span><?=price_formate($row->amount) ?></span></td>
													</tr>
													<tr>
														<th>Gst:</th>
														<td><span><?=price_formate($value->gst) ?></span></td>
													</tr>
													<tr>
														<th>Total Amount:</th>
														<td><span><?=price_formate($value->final_amount) ?></span></td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->

								
								
							</div>
						</div>
					</div>
					<div class="row">
						<button class="btn btn-outline-info" style="margin: 0 auto;margin-bottom: 15px;width: fit-content;" onclick="printInvoice()">Print Invoice</button>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->

<script>
function printInvoice() {
    var invoice = document.getElementById("invoiceDiv").innerHTML;
    var printWindow = window.open('', '', 'height=700,width=900');
    printWindow.document.write('<html><head><title>Invoice</title>');
    // copy current styles too
    document.querySelectorAll("link[rel='stylesheet'], style").forEach(function(node) {
        printWindow.document.write(node.outerHTML);
    });
    printWindow.document.write('</head><body>');
    printWindow.document.write(invoice);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>

<?=view("web/include/footer"); ?>