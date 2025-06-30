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
        <label for="id_type" class="block text-sm/6 font-medium text-gray-900">ID Type</label>
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
        <label for="id_no" class="block text-sm/6 font-medium text-gray-900">
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
        <label for="tin" class="block text-sm/6 font-medium text-gray-900">
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
      <label for="name" class="block text-sm font-medium text-gray-900">Personal / Company Name<span class="text-red-500 ml-1">*</span></label>
      <input id="name" name="name" type="text" placeholder="ABC SDN. BHD." disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
    </div>

    <!-- Email -->
    <div>
      <label for="email" class="block text-sm font-medium text-gray-900">Email<span class="text-red-500 ml-1">*</span></label>
      <input id="email" name="email" type="email" placeholder="abc@example.com" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
    </div>

    <!-- Confirm Email -->
    <div>
      <label for="confirm_email" class="block text-sm font-medium text-gray-900">Confirm Email<span class="text-red-500 ml-1">*</span></label>
      <input id="confirm_email" name="confirm_email" type="email" placeholder="abc@example.com" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
    </div>

    <!-- Phone -->
    <div>
      <label for="phone" class="block text-sm font-medium text-gray-900">Phone<span class="text-red-500 ml-1">*</span></label>
      <input id="phone" name="phone" type="number" placeholder="60123456789" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
    </div>

    <!-- BRN Old -->
    <div>
      <label for="brn_old" class="block text-sm font-medium text-gray-900">Business Registration No. (Old)</label>
      <input id="brn_old" name="brn_old" type="text" placeholder="1234567-X" disabled class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
    </div>

    <!-- MSIC Code -->
    <div>
      <label for="msic_code" class="block text-sm font-medium text-gray-900">MSIC Code<span class="text-red-500 ml-1">*</span></label>
      <select id="msic_code" name="msic_code" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
        <option value="00000">00000 - NOT APPLICABLE</option>
        <!-- Other options trimmed for brevity -->
      </select>
    </div>

    <!-- SST No. -->
    <div>
      <label for="sst_no" class="block text-sm font-medium text-gray-900">SST No.</label>
      <input id="sst_no" name="sst_no" type="text" placeholder="M32-1234-858-93637" disabled class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
    </div>
  </div>

  <!-- Right Column -->
  <div class="space-y-4">
    <!-- Address Line 1 -->
    <div>
      <label for="address_line_1" class="block text-sm font-medium text-gray-900">Address Line 1<span class="text-red-500 ml-1">*</span></label>
      <input id="address_line_1" name="address_line_1" type="text" placeholder="123, Jalan A" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600">
    </div>

    <!-- Address Line 2 -->
    <div>
      <label for="address_line_2" class="block text-sm font-medium text-gray-900">Address Line 2</label>
      <input id="address_line_2" name="address_line_2" type="text" disabled class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
    </div>

    <!-- Address Line 3 -->
    <div>
      <label for="address_line_3" class="block text-sm font-medium text-gray-900">Address Line 3</label>
      <input id="address_line_3" name="address_line_3" type="text" disabled class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
    </div>

    <!-- Postcode -->
    <div>
      <label for="postcode" class="block text-sm font-medium text-gray-900">Postcode<span class="text-red-500 ml-1">*</span></label>
      <input id="postcode" name="postcode" type="number" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
    </div>

    <!-- City -->
    <div>
      <label for="city" class="block text-sm font-medium text-gray-900">City<span class="text-red-500 ml-1">*</span></label>
      <input id="city" name="city" type="text" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
    </div>

    <!-- State -->
    <div>
      <label for="state" class="block text-sm font-medium text-gray-900">State<span class="text-red-500 ml-1">*</span></label>
      <select id="state" name="state" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
        <option value="">--- Please Select ---</option>
        <option value="Selangor">Selangor</option>
        <!-- Other options trimmed for brevity -->
      </select>
    </div>

    <!-- Country -->
    <div>
      <label for="country" class="block text-sm font-medium text-gray-900">Country<span class="text-red-500 ml-1">*</span></label>
      <select id="country" name="country" disabled required class="mt-2 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300">
        <option value="Malaysia" selected>Malaysia</option>
      </select>
    </div>
  </div>
</div>

