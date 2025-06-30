<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Company Info Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <!-- Header Section with Logo and ID Inputs -->
  <div class="bg-white p-6 rounded shadow-md">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
      <!-- Logo Section -->
      <div class="order-1 sm:order-2 flex justify-center sm:justify-end sm:items-center">
        <img alt="Navbright Technology" src="/company/navbright-logo-big.png" class="h-auto w-auto max-w-full max-h-40 sm:max-h-60 mx-auto">
      </div>

      <!-- ID Form Section -->
      <div class="order-2 sm:order-1">
        <div class="mb-4">
          <h2 class="text-lg font-semibold text-gray-900">Generate
            <button type="button" class="ml-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">FAQ</button>
          </h2>
          <p class="text-sm text-gray-600">Request e-invoice</p>
        </div>

        <div class="space-y-4">
          <!-- ID Type -->
          <div>
            <label for="id_type" class="block text-sm font-medium text-gray-900">ID Type</label>
            <select id="id_type" name="id_type" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
              <option value="BRN" selected>BRN</option>
              <option value="NRIC">NRIC</option>
              <option value="PASSPORT">Passport No.</option>
              <option value="ARMY">Army No.</option>
            </select>
          </div>

          <!-- Business Registration No. -->
          <div>
            <label for="id_no" class="block text-sm font-medium text-gray-900">Business Registration No. (New)<span class="text-red-500 ml-1">*</span></label>
            <input id="id_no" name="id_no" type="text" placeholder="201901234567" required class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
          </div>

          <!-- Tax Identification No. -->
          <div>
            <label for="tin" class="block text-sm font-medium text-gray-900">Tax Identification No.<span class="text-red-500 ml-1">*</span></label>
            <div class="flex">
              <input id="tin" name="tin" type="text" required class="flex-grow rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
              <button type="button" class="rounded-r-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Validate</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Company Information Section -->
  <div class="bg-white p-6 mt-6 rounded shadow-md">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
      <!-- Column 1 -->
      <div class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-900">Personal / Company Name<span class="text-red-500 ml-1">*</span></label>
          <input id="name" name="name" type="text" placeholder="ABC SDN. BHD." disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-900">Email<span class="text-red-500 ml-1">*</span></label>
          <input id="email" name="email" type="email" placeholder="abc@example.com" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="confirm_email" class="block text-sm font-medium text-gray-900">Confirm Email<span class="text-red-500 ml-1">*</span></label>
          <input id="confirm_email" name="confirm_email" type="email" placeholder="abc@example.com" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-900">Phone<span class="text-red-500 ml-1">*</span></label>
          <input id="phone" name="phone" type="number" placeholder="60123456789" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="brn_old" class="block text-sm font-medium text-gray-900">Business Registration No. (Old)</label>
          <input id="brn_old" name="brn_old" type="text" placeholder="1234567-X" disabled class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="msic_code" class="block text-sm font-medium text-gray-900">MSIC Code<span class="text-red-500 ml-1">*</span></label>
          <select id="msic_code" name="msic_code" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
            <option value="00000">00000 - NOT APPLICABLE</option>
          </select>
        </div>
        <div>
          <label for="sst_no" class="block text-sm font-medium text-gray-900">SST No.</label>
          <input id="sst_no" name="sst_no" type="text" placeholder="M32-1234-858-93637" disabled class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
      </div>

      <!-- Column 2 -->
      <div class="space-y-4">
        <div>
          <label for="address_line_1" class="block text-sm font-medium text-gray-900">Address Line 1<span class="text-red-500 ml-1">*</span></label>
          <input id="address_line_1" name="address_line_1" type="text" placeholder="123, Jalan A" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="address_line_2" class="block text-sm font-medium text-gray-900">Address Line 2</label>
          <input id="address_line_2" name="address_line_2" type="text" disabled class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="address_line_3" class="block text-sm font-medium text-gray-900">Address Line 3</label>
          <input id="address_line_3" name="address_line_3" type="text" disabled class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="postcode" class="block text-sm font-medium text-gray-900">Postcode<span class="text-red-500 ml-1">*</span></label>
          <input id="postcode" name="postcode" type="number" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="city" class="block text-sm font-medium text-gray-900">City<span class="text-red-500 ml-1">*</span></label>
          <input id="city" name="city" type="text" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
        </div>
        <div>
          <label for="state" class="block text-sm font-medium text-gray-900">State<span class="text-red-500 ml-1">*</span></label>
          <select id="state" name="state" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
            <option value="">--- Please Select ---</option>
            <option value="Selangor">Selangor</option>
            <option value="Wilayah Persekutuan Kuala Lumpur">Wilayah Persekutuan Kuala Lumpur</option>
          </select>
        </div>
        <div>
          <label for="country" class="block text-sm font-medium text-gray-900">Country<span class="text-red-500 ml-1">*</span></label>
          <select id="country" name="country" disabled required class="w-full rounded-md border-gray-300 bg-gray-100 text-gray-500">
            <option value="Malaysia" selected>Malaysia</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
