<?php
// einvoice.php

// If an AJAX request is sent to verify the captcha, process it and return JSON.
if (isset($_GET['action']) && $_GET['action'] === 'verify') {
    header('Content-Type: application/json');
    
    // Check if the reCAPTCHA response exists.
    if (empty($_POST['g-recaptcha-response'])) {
        echo json_encode(['success' => false, 'error' => 'Captcha not completed']);
        exit;
    }
    
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = "6LeVaQUrAAAAAJOY8di188XEynmgqRK_VSCnxSY5"; // Replace with your actual secret key
    $remoteIp = $_SERVER['REMOTE_ADDR'];
    
    // Prepare and send POST request to Google.
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
    
    $resultJson = json_decode($result, true);
    
    if ($resultJson["success"]) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Captcha verification failed.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E-Invoice Request</title>
  <!-- Bootstrap CSS (from your NiceAdmin assets) -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <!-- Google reCAPTCHA script -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <!-- jQuery for AJAX -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!-- Simple Header (you can integrate with NiceAdmin header if needed) -->
  <div class="container mt-5 text-center">
    <h1>E-Invoice Request</h1>
    <!-- Button that triggers the modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#einvoiceModal">
      E-Invoice Request
    </button>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="einvoiceModal" tabindex="-1" aria-labelledby="einvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="einvoiceModalLabel">E-Invoice Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalContent">
          <!-- Captcha form -->
          <form id="captchaForm">
            <div class="g-recaptcha" data-sitekey="6LeVaQUrAAAAALa-hI5v-ZyAoZLUDMJeYBvBw_bZ"></div>
            <br>
            <button type="submit" class="btn btn-success">Verify Captcha</button>
          </form>
          <div id="errorMessage" class="mt-3 text-danger"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle JS (includes Popper) -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function(){
      // Handle the captcha form submission via AJAX.
      $("#captchaForm").submit(function(e){
        e.preventDefault(); // Prevent the default form submission
        $("#errorMessage").text(""); // Clear any previous errors
        
        $.ajax({
          url: '?action=verify',
          method: 'POST',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.success){
              // Replace the modal content with the embedded Google Form.
              $("#modalContent").html('<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSf3vjITSwppL6gx16lwVtOCOcmliNIS7aC-buV5_SQn0ogMiQ/viewform?embedded=true" width="100%" height="600" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>');
            } else {
              $("#errorMessage").text(response.error);
              grecaptcha.reset(); // Reset the reCAPTCHA widget if verification fails.
            }
          },
          error: function(){
            $("#errorMessage").text("An error occurred. Please try again.");
            grecaptcha.reset();
          }
        });
      });
    });
  </script>
</body>
</html>
