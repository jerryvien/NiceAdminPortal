<?php
session_start();

// Process the reCAPTCHA form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    if (empty($recaptchaResponse)) {
        $error = "Please complete the reCAPTCHA challenge.";
    } else {
        $secretKey = "6LeVaQUrAAAAAJOY8di188XEynmgqRK_VSCnxSY5"; // Replace with your secret key
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $data = [
            'secret'   => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $remoteIp
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $resultJson = json_decode($result);
        if ($resultJson->success) {
            $_SESSION['captcha_verified'] = true;
        } else {
            $error = "Captcha verification failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E-Invoice Request</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <!-- Google reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <!-- (Header content from NiceAdmin template) -->
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">NiceAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- (Other header items omitted for brevity) -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <!-- (Sidebar content from NiceAdmin template) -->
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="einvoiceform.php">
          <i class="bi bi-grid"></i>
          <span>Einvoice QR</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="loyverse_sales.php">
          <i class="bi bi-grid"></i>
          <span>Data</span>
        </a>
      </li>
      <!-- (Other menu items) -->
    </ul>
  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>E-Invoice Request</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">E-Invoice Request</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="container mt-4 text-center">
        <!-- The E-invoice Request Button -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#captchaModal">
          E-Invoice Request
        </button>

        <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>e-Invoice Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding: 40px;
    }
    .logo {
      max-height: 100px;
      float: right;
    }
    .form-section {
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row">
  <!-- Left Column: Form -->
  <div class="col-md-8">
        <h4>Generate <span class="badge bg-primary">FAQ</span></h4>

        <form class="row g-3 form-section">
            <!-- Row 1: ID Type -->
            <div class="col-12">
                <label class="form-label">ID Type</label>
                <select class="form-select">
                <option selected>BRN</option>
                <option>NRIC</option>
                <option>ARMY ID</option>
                <option>PASSPORT</option>
                </select>
            </div>

            <!-- Row 2: Business Registration No. -->
            <div class="col-12">
                <label class="form-label">Business Registration No. (New) *</label>
                <input type="text" class="form-control" placeholder="201901234567">
            </div>

            <!-- Row 3: Tax ID + Button -->
            <div class="col-12">
                <label class="form-label">Tax Identification No. *</label>
                <div class="input-group">
                <input type="text" class="form-control">
                <button class="btn btn-primary" type="button">Validate</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Right Column: Logo -->
    <div class="col-md-4 d-flex align-items-start justify-content-end">
        <img src="your-logo.png" alt="Navbright Logo" class="img-fluid" style="max-height: 80px;">
    </div>
    </div>

      <!-- Row 2 -->
      <div class="col-md-4">
        <label class="form-label">Personal / Company Name *</label>
        <input type="text" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Address Line 1 *</label>
        <input type="text" class="form-control" placeholder="123, Jalan A">
      </div>

      <!-- Row 3 -->
      <div class="col-md-4">
        <label class="form-label">Email *</label>
        <input type="email" class="form-control" placeholder="abc@example.com">
      </div>
      <div class="col-md-4">
        <label class="form-label">Address Line 2</label>
        <input type="text" class="form-control">
      </div>

      <div class="col-md-4">
        <label class="form-label">Confirm Email *</label>
        <input type="email" class="form-control" placeholder="abc@example.com">
      </div>
      <div class="col-md-4">
        <label class="form-label">Address Line 3</label>
        <input type="text" class="form-control">
      </div>

      <!-- Row 4 -->
      <div class="col-md-4">
        <label class="form-label">Phone *</label>
        <input type="text" class="form-control" placeholder="60123456789">
      </div>
      <div class="col-md-2">
        <label class="form-label">Postcode *</label>
        <input type="text" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">City *</label>
        <input type="text" class="form-control">
      </div>
      <div class="col-md-2">
        <label class="form-label">State *</label>
        <select class="form-select">
          <option selected>--- Please Select ---</option>
          <option>Selangor</option>
        </select>
      </div>

      <!-- Row 5 -->
      <div class="col-md-4">
        <label class="form-label">Business Registration No. (Old)</label>
        <input type="text" class="form-control" placeholder="1234567-X">
      </div>
      <div class="col-md-4">
        <label class="form-label">Malaysia Standard Industrial Classification (MSIC) Code *</label>
        <select class="form-select">
          <option>00000 - NOT APPLICABLE</option>
          <option>12345 - IT Services</option>
        </select>
      </div>

      <!-- Row 6 -->
      <div class="col-md-4">
        <label class="form-label">SST No.</label>
        <input type="text" class="form-control" placeholder="M32-1234-858-93637">
      </div>
      <div class="col-md-4">
        <label class="form-label">Country *</label>
        <select class="form-select">
          <option selected>Malaysia</option>
        </select>
      </div>

      <!-- Row 7 -->
      <div class="col-md-4">
        <label class="form-label">Invoice No. *</label>
        <input type="text" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Invoice Amount *</label>
        <div class="input-group">
          <span class="input-group-text">MYR</span>
          <input type="number" class="form-control" value="0.00">
        </div>
      </div>

      <!-- Agreement -->
      <div class="col-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="agreement">
          <label class="form-check-label" for="agreement">
            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>
        </div>
      </div>

      <!-- Buttons -->
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form>
  </div>

</body>
</html>


      </div>
    </section>
  </main><!-- End #main -->

  <!-- Modal for reCAPTCHA and Google Form -->
  <div class="modal fade" id="captchaModal" tabindex="-1" aria-labelledby="captchaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="captchaModalLabel">E-Invoice Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php if (isset($_SESSION['captcha_verified'])): ?>
          <!-- Embedded Google Form shown after successful captcha verification -->
          <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSf3vjITSwppL6gx16lwVtOCOcmliNIS7aC-buV5_SQn0ogMiQ/viewform?embedded=true" width="100%" height="600" frameborder="0" marginheight="0"
            marginwidth="0">Loading…</iframe>
          <?php else: ?>
          <!-- Display error message if captcha failed -->
          <?php if (isset($error)) { echo "<div class='alert alert-danger'>{$error}</div>"; } ?>
          <!-- reCAPTCHA form -->
          <form action="" method="post">
            <div class="g-recaptcha" data-sitekey="6LeVaQUrAAAAALa-hI5v-ZyAoZLUDMJeYBvBw_bZ"></div>
            <br/>
            <button type="submit" name="submit" class="btn btn-success">Verify Captcha</button>
          </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>
