<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Request e-Invoice</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900">

  <div class="max-w-6xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6 items-start">
      
      <!-- Right Logo (on small screen it appears first using order) -->
      <div class="order-1 sm:order-2 flex justify-center sm:justify-end sm:items-center">
        <img
          alt="Navbright Technology"
          src="/company/navbright-logo-big.png"
          class="h-auto w-auto max-h-40 sm:max-h-60 mx-auto"
        />
      </div>

      <!-- Left Form -->
      <div class="order-2 sm:order-1 space-y-6">
        <div>
          <h2 class="text-lg font-semibold text-gray-900 flex items-center">
            Generate
            <button
              type="button"
              class="ml-3 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
              FAQ
            </button>
          </h2>
          <p class="text-sm text-gray-600">Request e-invoice</p>
        </div>

        <!-- ID Type -->
        <div>
          <label for="id_type" class="block text-sm font-medium text-gray-900">ID Type</label>
          <select
            id="id_type"
            name="id_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          >
            <option value="BRN" selected>BRN</option>
            <option value="NRIC">NRIC</option>
            <option value="PASSPORT">Passport No.</option>
            <option value="ARMY">Army No.</option>
          </select>
        </div>

        <!-- Business Registration No. -->
        <div>
          <label for="id_no" class="block text-sm font-medium text-gray-900">
            Business Registration No. (New) <span class="text-red-500">*</span>
          </label>
          <div class="mt-1 relative">
            <input
              id="id_no"
              name="id_no"
              type="text"
              placeholder="201901234567"
              required
              class="block w-full rounded-md border-gray-300 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
            <!-- Optional Icon (info) -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM7.002 11V7h2v4h-2zm.998-6a1.5 1.5 0 1 1 0 3A1.5 1.5 0 0 1 8 5z"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- Tax Identification No. + Button -->
        <div>
          <label for="tin" class="block text-sm font-medium text-gray-900">
            Tax Identification No. <span class="text-red-500">*</span>
          </label>
          <div class="mt-1 flex rounded-md shadow-sm">
            <input
              type="text"
              name="tin"
              id="tin"
              required
              class="flex-1 rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            />
            <button
              type="button"
              class="inline-flex items-center rounded-r-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
              Validate
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
