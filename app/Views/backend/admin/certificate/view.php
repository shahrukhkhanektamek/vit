<?=view('backend/include/header') ?>

<div class="page-content table_page">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0"><?=$data['page_title']?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('/admin')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a ><?=$data['title']?></a></li>
                            <li class="breadcrumb-item active"><?=$data['page_title']?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        
            
            <!--end col-->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1"><?=$data['title']?> Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row g-3">
                                
                                <img id="certificateImg" style="width:50%;margin:0 auto;" src="<?=$data['img_base64']?>" />

                            </div>
                            <div class="row justify-content-around">
                                <button class="btn btn-success" style="width: fit-content;" onclick="downloadPDF()">Download Certificate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

         
        <!--end row-->
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->


<?=view('backend/include/footer') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
async function downloadPDF() {
  const { jsPDF } = window.jspdf; // import jsPDF
  const img = document.getElementById("certificateImg");
  const imageData = img.src;

  // Create new PDF (A4 size)
  const pdf = new jsPDF({
    orientation: "portrait",
    unit: "mm",
    format: "a4"
  });

  // Image dimensions
  const pageWidth = pdf.internal.pageSize.getWidth();
  const pageHeight = pdf.internal.pageSize.getHeight();

  // Add image full-page (maintains aspect ratio)
  pdf.addImage(imageData, "JPEG", 0, 0, pageWidth, pageHeight);

  // Save PDF
  pdf.save("certificate.pdf");
}
</script>