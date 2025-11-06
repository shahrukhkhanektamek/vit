<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Examination Results 2025</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .result-header img {
    margin: 0 auto;
}
    .result-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
      padding: 30px;
    }
    .result-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .result-header h3 {
      font-weight: 700;
      color: #2c3e50;
    }
    .table th {
      background: #133188;
      color: #fff;
    }
    .badge-pass {
      background: #27ae60;
      font-size: 14px;
    }
    .badge-fail {
      background: #e74c3c;
      font-size: 14px;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Header -->
  <header class="bg-cyan-600 text-white py-4 shadow">
    <h1 class="text-center text-xl font-bold">Examination Results 2025</h1>
  </header>

  <!-- Form Section (Visible First) -->
  <main id="formSection" class="container mx-auto flex justify-center mt-10">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-2xl p-8">
      <div class="result-header">
        <img src="assets/logo.jpeg" 
             alt="Logo" class="mb-2">
       <!--  <h3>Gujarat Public Service Commission</h3>
        <p class="text-muted">Final Result for Recruitment Examination</p> -->
      </div>
    
    </div>
  </main>


  <div class="col-12 text-center mt-4">
      <?php
      foreach ($certificates as $key => $value) {
      ?>
          <img id="certificateImg" style="width:50%;margin:0 auto;" src="<?=$value?>" />
      <?php } ?>
  </div>

  <div class="col-12 text-center">
      <?php
      foreach ($results as $key => $value) {
      ?>
          <img id="certificateImg" style="width:50%;margin:0 auto;" src="<?=$value?>" />
      <?php } ?>
  </div>

  <div class="col-12 text-center mt-2 mb-5">
      <button class="btn btn-success" style="width: fit-content;" onclick="downloadPDF()">Download Certificate</button>
  </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
async function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const pdf = new jsPDF({
    orientation: "portrait",
    unit: "mm",
    format: "a4"
  });

  // ✅ Collect all certificate/result images
  const allImages = document.querySelectorAll("#certificateImg");

  const pageWidth = pdf.internal.pageSize.getWidth();
  const pageHeight = pdf.internal.pageSize.getHeight();

  // ✅ Loop through all images and add each one to a new page
  for (let i = 0; i < allImages.length; i++) {
    const img = allImages[i];
    const imageData = img.src;

    if (i > 0) pdf.addPage(); // Add new page for every next image

    // Calculate image aspect ratio
    const tempImg = new Image();
    tempImg.src = imageData;
    await new Promise(resolve => {
      tempImg.onload = () => {
        const imgWidth = tempImg.width;
        const imgHeight = tempImg.height;
        const ratio = Math.min(pageWidth / imgWidth, pageHeight / imgHeight);
        const x = (pageWidth - imgWidth * ratio) / 2;
        const y = (pageHeight - imgHeight * ratio) / 2;

        pdf.addImage(imageData, "JPEG", x, y, imgWidth * ratio, imgHeight * ratio);
        resolve();
      };
    });
  }

  // ✅ Download all pages in one PDF
  pdf.save("<?=$row->name.'-'.$row->user_id?>-Documents.pdf");
}
</script>

</body>
</html>
