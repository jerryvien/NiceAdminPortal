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
                <div class="container">
                    <div class="row">
                        <!-- Tailwind CSS via CDN -->
                            <script src="https://cdn.tailwindcss.com"></script>

                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">

                        <!-- Logo Section -->
                        <div class="order-1 sm:order-2 flex justify-center sm:justify-end sm:items-center">
                            <img
                            alt="Navbright Technology"
                            src="logo.png"
                            class="h-auto w-auto max-w-full max-h-40 sm:max-h-60 mx-auto"
                            />
                        </div>

                        <!-- Form Section -->
                        <div class="order-2 sm:order-1">
                            <div class="mb-4">
                            <h2 class="text-base/7 font-semibold text-gray-900">
                                Generate
                                <button
                                type="button"
                                class="ml-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                FAQ
                                </button>
                            </h2>
                            <p class="text-sm/6 text-gray-600">Request e-invoice</p>
                            </div>

                            <div class="space-y-4">

                            <!-- ID Type -->
                            <div>
                                <label for="id_type" class="block text-sm font-bold text-left text-gray-900">ID Type</label>
                                <div class="mt-2 relative">
                                <select
                                    id="id_type"
                                    name="id_type"
                                    class="w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-gray-900 outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600 text-base sm:text-sm/6"
                                >
                                    <option value="BRN" selected>BRN</option>
                                    <option value="NRIC">NRIC</option>
                                    <option value="PASSPORT">Passport No.</option>
                                    <option value="ARMY">Army No.</option>
                                </select>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="absolute right-2 top-2.5 pointer-events-none size-5 text-gray-500 sm:size-4"
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                    aria-hidden="true"
                                >
                                    <path
                                    fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd"
                                    />
                                </svg>
                                </div>
                            </div>

                            <!-- Business Registration No. -->
                            <div>
                                <label for="id_no" class="block text-sm font-bold text-left text-gray-900">
                                Business Registration No. (New)
                                <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="mt-2 relative">
                                <input
                                    id="id_no"
                                    name="id_no"
                                    type="text"
                                    required
                                    placeholder="201901234567"
                                    class="block w-full rounded-md bg-white px-3 py-1.5 pr-10 text-base text-gray-900 placeholder:text-gray-400 sm:text-sm/6 outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600"
                                />
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="absolute right-3 top-2.5 size-5 text-gray-400 sm:size-4"
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                    aria-hidden="true"
                                >
                                    <path
                                    fill-rule="evenodd"
                                    d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0Zm-6 3.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM7.293 5.293a1 1 0 1 1 .99 1.667c-.459.134-1.033.566-1.033 1.29v.25a.75.75 0 1 0 1.5 0v-.115a2.5 2.5 0 1 0-2.518-4.153.75.75 0 1 0 1.061 1.06Z"
                                    clip-rule="evenodd"
                                    />
                                </svg>
                                </div>
                            </div>

                            <!-- Tax Identification No. -->
                            <div>
                                <label for="tin" class="block text-sm font-bold text-left text-gray-900">
                                Tax Identification No.
                                <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="mt-2 flex">
                                <input
                                    id="tin"
                                    name="tin"
                                    type="text"
                                    required
                                    class="block w-full rounded-l-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 sm:text-sm/6 outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600"
                                />
                                <button
                                    type="button"
                                    class="rounded-r-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Validate
                                </button>
                                </div>
                            </div>

                            </div>
                        </div>

                        </div>


                        <!-- Cleaned & Formatted HTML Form Layout using Tailwind CSS -->
                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                            <label for="name" class="block text-sm font-bold text-left text-gray-900">Personal / Company Name<span class="text-red-500 ml-1">*</span></label>
                            <input id="name" name="name" type="text" placeholder="ABC SDN. BHD." required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>

                            <!-- Email -->
                            <div>
                            <label for="email" class="block text-sm font-bold text-left text-gray-900">Email<span class="text-red-500 ml-1">*</span></label>
                            <input id="email" name="email" type="email" placeholder="abc@example.com" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>

                            <!-- Confirm Email -->
                            <div>
                            <label for="confirm_email" class="block text-sm font-bold text-left text-gray-900">Confirm Email<span class="text-red-500 ml-1">*</span></label>
                            <input id="confirm_email" name="confirm_email" type="email" placeholder="abc@example.com" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>

                            <!-- Phone -->
                            <div>
                            <label for="phone" class="block text-sm font-bold text-left text-gray-900">Phone<span class="text-red-500 ml-1">*</span></label>
                            <input id="phone" name="phone" type="number" placeholder="60123456789" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>

                            <!-- BRN Old -->
                            <div>
                            <label for="brn_old" class="block text-sm font-bold text-left text-gray-900">Business Registration No. (Old)</label>
                            <input id="brn_old" name="brn_old" type="text" placeholder="1234567-X" class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>

                            <!-- MSIC Code -->
                            <div>
                            <label for="msic_code" class="block text-sm font-bold text-left text-gray-900">MSIC Code<span class="text-red-500 ml-1">*</span></label>
                            <select id="msic_code" name="msic_code" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                                <option value="00000">00000 - NOT APPLICABLE</option>
                                <!-- Other options trimmed for brevity -->
                            </select>
                            </div>

                            <!-- SST No. -->
                            <div>
                            <label for="sst_no" class="block text-sm font-bold text-left text-gray-900">SST No.</label>
                            <input id="sst_no" name="sst_no" type="text" placeholder="M32-1234-858-93637" class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Address Line 1 -->
                            <div>
                            <label for="address_line_1" class="block text-sm font-bold text-left text-gray-900">Address Line 1<span class="text-red-500 ml-1">*</span></label>
                            <input id="address_line_1" name="address_line_1" type="text" placeholder="123, Jalan A" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>

                            <!-- Address Line 2 -->
                            <div>
                            <label for="address_line_2" class="block text-sm font-bold text-left text-gray-900">Address Line 2</label>
                            <input id="address_line_2" name="address_line_2" type="text" class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
                            </div>

                            <!-- Address Line 3 -->
                            <div>
                            <label for="address_line_3" class="block text-sm font-bold text-left text-gray-900">Address Line 3</label>
                            <input id="address_line_3" name="address_line_3" type="text" class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
                            </div>

                            <!-- Postcode -->
                            <div>
                            <label for="postcode" class="block text-sm font-bold text-left text-gray-900">Postcode<span class="text-red-500 ml-1">*</span></label>
                            <input id="postcode" name="postcode" type="number" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
                            </div>

                            <!-- City -->
                            <div>
                            <label for="city" class="block text-sm font-bold text-left text-gray-900">City<span class="text-red-500 ml-1">*</span></label>
                            <input id="city" name="city" type="text" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
                            </div>

                            <!-- State -->
                            <div>
                            <label for="state" class="block text-sm font-bold text-left text-gray-900">State<span class="text-red-500 ml-1">*</span></label>
                            <select id="state" name="state" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
                                <option value="">--- Please Select ---</option>
                                <option value="Selangor">Selangor</option>
                                <!-- Other options trimmed for brevity -->
                            </select>
                            </div>

                            <!-- Country -->
                            <div>
                            <label for="country" class="block text-sm font-bold text-left text-gray-900">Country<span class="text-red-500 ml-1">*</span></label>
                            <select id="country" name="country" required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
                                <option value="Malaysia" selected>Malaysia</option>
                            </select>
                            </div>
                        </div>
                        </div>

                        <!-- Invoice Section -->
                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                        <!-- Invoice No. -->
                        <div>
                            <label for="invoice_no" class="block text-sm font-bold text-left text-gray-900">Invoice No.<span class="text-red-500 ml-1">*</span></label>
                            <div class="mt-2 grid grid-cols-1">
                            <input id="invoice_no" name="invoice_no" type="text" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base placeholder:text-gray-400 sm:text-sm text-gray-900 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
                            </div>
                        </div>

                        <!-- Invoice Amount -->
                        <div>
                            <label for="invoice_amount" class="block text-sm font-bold text-left text-gray-900">Invoice Amount<span class="text-red-500 ml-1">*</span></label>
                            <div class="mt-2">
                            <div class="flex items-center rounded-md bg-white outline outline-1 outline-gray-300 focus-within:outline-2 focus-within:outline-indigo-600">
                                <div class="text-base pl-3 pr-3 text-gray-500 select-none sm:text-sm">MYR</div>
                                <input id="invoice_amount" name="invoice_amount" type="number" placeholder="0.00" min="0.00" step="0.01" required class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm">
                            </div>
                            </div>
                        </div>

                        <!-- Terms Toggle -->
                        <div class="flex items-center">
                            <button
                            class="group relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 transition-colors duration-200 ease-in-out focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                            id="terms_toggle"
                            role="switch"
                            type="button"
                            aria-checked="false"
                            >
                            <span aria-hidden="true" class="pointer-events-none inline-block size-4 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out translate-x-0"></span>
                            </button>
                            <span class="ml-3 text-sm font-medium text-gray-900">
                            I agree to the <span class="cursor-pointer text-blue-600 underline">Terms of Service</span> and <span class="cursor-pointer text-blue-600 underline">Privacy Policy</span>
                            </span>
                        </div>
                    </div>
                         <!-- Submit and Reset Buttons -->
                        <div class="mt-4 pb-4">
                            <button
                            type="submit"
                            class="rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 bg-indigo-600 hover:bg-indigo-500"
                            >
                            Submit
                            </button>
                            <button
                            type="button"
                            class="ml-2 rounded-md bg-gray-500 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-500"
                            >
                            Reset
                            </button>
                        </div>
                    </div>
                </div>
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

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('terms_toggle');
    const toggleCircle = toggleBtn.querySelector('span');

    toggleBtn.addEventListener('click', function () {
      const isChecked = toggleBtn.getAttribute('aria-checked') === 'true';
      toggleBtn.setAttribute('aria-checked', String(!isChecked));

      // Toggle background color
      toggleBtn.classList.toggle('bg-indigo-600', !isChecked);
      toggleBtn.classList.toggle('bg-gray-200', isChecked);

      // Toggle position of the circle
      toggleCircle.classList.toggle('translate-x-5', !isChecked);
      toggleCircle.classList.toggle('translate-x-0', isChecked);
    });
  });
</script>

</body>

</html>
