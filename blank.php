<div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">

  <!-- Logo Section -->
  <div class="order-1 sm:order-2 flex justify-center sm:justify-end sm:items-center">
    <img
      alt="Navbright Technology"
      src="/company/navbright-logo-big.png"
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
