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
      <form method="get" action="<?=base_url('result') ?>" class="space-y-5">

        <div>
          <label class="block text-gray-600 mb-1">Your Roll Number :</label>
          <input type="text" id="rollNo" placeholder="Roll Number" name="roll_no" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
          <label class="block text-gray-600 mb-1">Student Name :</label>
          <input type="text" id="schoolNo" placeholder="Student Name" name="name" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
          <label class="block text-gray-600 mb-1">Date of Birth :</label>
          <input type="date" id="dob" name="date_of_birth" required class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex justify-center gap-4 mt-6">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            Submit
          </button>
          <button type="reset" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded shadow">
            Reset
          </button>
        </div>

      </form>
    </div>
  </main>



</body>
</html>
