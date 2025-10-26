<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <Head title="Add Revenue" />

    <!-- Mobile Sidebar -->
    <div v-show="isMobileMenuOpen" class="relative z-50 lg:hidden">
      <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="closeMobileMenu"></div>
      <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl">
        <AdminSidebar :isMobileMenuOpen="true" @closeMobileMenu="closeMobileMenu" />
      </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
      <AdminSidebar />
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64">
      <!-- Top Bar -->
      <AdminTopbar @toggleMobileMenu="toggleMobileMenu" />

      <!-- Main Content Area -->
      <main class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">
          <!-- Header -->
          <div class="mb-8">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Add New Revenue</h1>
                <p class="mt-2 text-lg text-gray-600">Create a new revenue transaction record</p>
              </div>
              <Link :href="route('admin.revenues.index')" class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
              </Link>
            </div>
          </div>

          <!-- Form -->
          <form @submit.prevent="submit" class="space-y-6">

            <!-- Receipt Number & Date Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Transaction Details
                </h2>
              </div>
              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                      Receipt Number
                    </label>
                    <div class="relative">
                      <input
                        type="text"
                        :value="receiptNumber"
                        disabled
                        class="w-full px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl cursor-not-allowed text-gray-800 font-semibold"
                      >
                      <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <span class="px-3 py-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-bold rounded-lg shadow-md">AUTO-GENERATED</span>
                      </div>
                    </div>
                    <p class="mt-2 text-xs text-blue-600 flex items-center">
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                      </svg>
                      Generated automatically upon saving
                    </p>
                  </div>

                  <div>
                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">
                      Transaction Date <span class="text-red-500">*</span>
                    </label>
                    <input
                      id="date"
                      v-model="form.date"
                      type="date"
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 bg-white hover:border-gray-300 font-medium"
                      :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.date }"
                      required
                    >
                    <p v-if="form.errors.date" class="mt-2 text-sm text-red-600 flex items-center">
                      <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                      </svg>
                      {{ form.errors.date }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Counselor, Marketer & Lead Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  Counselor, Marketer & Lead Information
                </h2>
              </div>
              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                  <div>
                    <label for="counselor_id" class="block text-sm font-semibold text-gray-700 mb-2">
                      Counselor <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                      <select
                        id="counselor_id"
                        v-model="form.counselor_id"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none font-medium cursor-pointer"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.counselor_id }"
                        @change="filterLeadsByCounselor"
                        required
                      >
                        <option value="">Select Counselor</option>
                        <option v-for="counselor in counselors" :key="counselor.id" :value="counselor.id">
                          {{ counselor.name }}
                        </option>
                      </select>
                      <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                      </div>
                    </div>
                    <p v-if="form.errors.counselor_id" class="mt-2 text-sm text-red-600">{{ form.errors.counselor_id }}</p>
                  </div>

                  <div>
                    <label for="marketer_id" class="block text-sm font-semibold text-gray-700 mb-2">
                      Marketer <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <div class="relative">
                      <select
                        id="marketer_id"
                        v-model="form.marketer_id"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none font-medium cursor-pointer"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.marketer_id }"
                      >
                        <option value="">Select Marketer</option>
                        <option v-for="marketer in marketers" :key="marketer.id" :value="marketer.id">
                          {{ marketer.name }}
                        </option>
                      </select>
                      <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                      </div>
                    </div>
                    <p v-if="form.errors.marketer_id" class="mt-2 text-sm text-red-600">{{ form.errors.marketer_id }}</p>
                  </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                  <div>
                    <label for="lead_id" class="block text-sm font-semibold text-gray-700 mb-2">
                      Lead <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <div class="relative">
                      <select
                        id="lead_id"
                        v-model="form.lead_id"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none font-medium cursor-pointer disabled:bg-gray-50 disabled:cursor-not-allowed"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.lead_id }"
                        :disabled="!form.counselor_id"
                      >
                        <option value="">{{ form.counselor_id ? 'Select Lead' : 'Select Counselor First' }}</option>
                        <option v-for="lead in filteredLeads" :key="lead.id" :value="lead.id">
                          {{ lead.student_name }} - {{ lead.mobile_number }}
                        </option>
                      </select>
                      <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                      </div>
                    </div>
                    <p v-if="form.errors.lead_id" class="mt-2 text-sm text-red-600">{{ form.errors.lead_id }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Payment Details
                </h2>
              </div>
              <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="payment_type" class="block text-sm font-semibold text-gray-700 mb-2">
                      Payment Type <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                      <select
                        id="payment_type"
                        v-model="form.payment_type"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none font-medium cursor-pointer"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.payment_type }"
                        required
                      >
                        <option value="">Select Payment Type</option>
                        <option value="Registration Fee">Registration Fee</option>
                        <option value="Course Fee">Course Fee</option>
                        <option value="Installment">Installment</option>
                        <option value="Material Fee">Material Fee</option>
                        <option value="Exam Fee">Exam Fee</option>
                        <option value="Other">Other</option>
                      </select>
                      <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                      </div>
                    </div>
                    <p v-if="form.errors.payment_type" class="mt-2 text-sm text-red-600">{{ form.errors.payment_type }}</p>
                  </div>

                  <div>
                    <label for="payment_mode" class="block text-sm font-semibold text-gray-700 mb-2">
                      Payment Mode <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                      <select
                        id="payment_mode"
                        v-model="form.payment_mode"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none font-medium cursor-pointer"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.payment_mode }"
                        required
                      >
                        <option value="">Select Payment Mode</option>
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI</option>
                        <option value="Card">Card</option>
                        <option value="Net Banking">Net Banking</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Other">Other</option>
                      </select>
                      <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                      </div>
                    </div>
                    <p v-if="form.errors.payment_mode" class="mt-2 text-sm text-red-600">{{ form.errors.payment_mode }}</p>
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                      Amount (₹) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 font-semibold">₹</span>
                      </div>
                      <input
                        id="amount"
                        v-model="form.amount"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 bg-white hover:border-gray-300 font-semibold"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.amount }"
                        placeholder="0.00"
                        required
                      >
                    </div>
                    <p v-if="form.errors.amount" class="mt-2 text-sm text-red-600">{{ form.errors.amount }}</p>
                  </div>

                  <div>
                    <label for="discount_applied" class="block text-sm font-semibold text-gray-700 mb-2">
                      Discount Applied (₹) <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 font-semibold">₹</span>
                      </div>
                      <input
                        id="discount_applied"
                        v-model="form.discount_applied"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 bg-white hover:border-gray-300 font-semibold"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.discount_applied }"
                        placeholder="0.00"
                      >
                    </div>
                    <p v-if="form.errors.discount_applied" class="mt-2 text-sm text-red-600">{{ form.errors.discount_applied }}</p>
                  </div>
                </div>

                <div>
                  <label for="transaction_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Transaction ID <span class="text-gray-400 text-xs">(Optional - for digital payments)</span>
                  </label>
                  <input
                    id="transaction_id"
                    v-model="form.transaction_id"
                    type="text"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 bg-white hover:border-gray-300 font-medium"
                    :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.transaction_id }"
                    placeholder="Enter transaction ID (UPI Ref, Card Auth Code, etc.)"
                  >
                  <p v-if="form.errors.transaction_id" class="mt-2 text-sm text-red-600">{{ form.errors.transaction_id }}</p>
                </div>

                <!-- Net Amount Display -->
                <div v-if="form.amount > 0" class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-5 rounded-xl">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <div>
                        <p class="text-sm text-green-700 font-medium">
                          <span class="font-semibold">Gross Amount:</span> ₹{{ formatNumber(form.amount) }}
                        </p>
                        <p v-if="form.discount_applied > 0" class="text-sm text-red-600 font-medium mt-1">
                          <span class="font-semibold">Discount:</span> -₹{{ formatNumber(form.discount_applied) }}
                        </p>
                      </div>
                    </div>
                    <div class="text-right">
                      <p class="text-xs text-green-600 font-semibold mb-1">NET AMOUNT</p>
                      <p class="text-3xl font-bold text-green-700">₹{{ formatNumber(netAmount) }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Installment Details (if applicable) -->
            <div v-if="form.payment_type === 'Installment'" class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  Installment Details
                </h2>
              </div>
              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="installment_number" class="block text-sm font-semibold text-gray-700 mb-2">
                      Installment Number
                    </label>
                    <input
                      id="installment_number"
                      v-model="form.installment_number"
                      type="number"
                      min="1"
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all duration-200 bg-white hover:border-gray-300 font-semibold"
                      :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.installment_number }"
                      placeholder="e.g., 1"
                    >
                    <p v-if="form.errors.installment_number" class="mt-2 text-sm text-red-600">{{ form.errors.installment_number }}</p>
                  </div>

                  <div>
                    <label for="total_installments" class="block text-sm font-semibold text-gray-700 mb-2">
                      Total Installments
                    </label>
                    <input
                      id="total_installments"
                      v-model="form.total_installments"
                      type="number"
                      min="1"
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all duration-200 bg-white hover:border-gray-300 font-semibold"
                      :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.total_installments }"
                      placeholder="e.g., 12"
                    >
                    <p v-if="form.errors.total_installments" class="mt-2 text-sm text-red-600">{{ form.errors.total_installments }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Additional Information Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Additional Information
                </h2>
              </div>
              <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="course_type" class="block text-sm font-semibold text-gray-700 mb-2">
                      Course Type <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <input
                      id="course_type"
                      v-model="form.course_type"
                      type="text"
                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 bg-white hover:border-gray-300 font-medium"
                      :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.course_type }"
                      placeholder="e.g., GS Foundation, UPSC Prelims"
                    >
                    <p v-if="form.errors.course_type" class="mt-2 text-sm text-red-600">{{ form.errors.course_type }}</p>
                  </div>

                  <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                      Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                      <select
                        id="status"
                        v-model="form.status"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none font-semibold cursor-pointer"
                        :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.status }"
                        required
                      >
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                      </select>
                      <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                      </div>
                    </div>
                    <p v-if="form.errors.status" class="mt-2 text-sm text-red-600">{{ form.errors.status }}</p>
                  </div>
                </div>

                <div>
                  <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                    Notes <span class="text-gray-400 text-xs">(Optional)</span>
                  </label>
                  <textarea
                    id="notes"
                    v-model="form.notes"
                    rows="4"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 bg-white hover:border-gray-300 resize-none font-medium"
                    :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-100': form.errors.notes }"
                    placeholder="Add any additional notes, remarks, or special instructions here..."
                  ></textarea>
                  <p v-if="form.errors.notes" class="mt-2 text-sm text-red-600">{{ form.errors.notes }}</p>
                </div>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6">
              <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <div class="flex items-center text-sm text-gray-600">
                  <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                  </svg>
                  <span class="font-medium">Fields marked with <span class="text-red-500 font-bold">*</span> are required</span>
                </div>
                <div class="flex space-x-3">
                  <Link
                    :href="route('admin.revenues.index')"
                    class="px-6 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center space-x-2 shadow-sm"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Cancel</span>
                  </Link>
                  <button
                    type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl text-white font-bold hover:from-green-700 hover:to-emerald-700 transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105"
                    :disabled="form.processing"
                  >
                    <svg v-if="!form.processing" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg v-else class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>{{ form.processing ? 'Saving...' : 'Save Revenue' }}</span>
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue';
import AdminTopbar from '@/Components/Admin/AdminTopbar.vue';

const props = defineProps({
  counselors: Array,
  marketers: Array,
  leads: Array,
  receiptNumber: String,
});

const isMobileMenuOpen = ref(false);
const filteredLeads = ref([]);

const form = useForm({
  counselor_id: '',
  marketer_id: '',
  lead_id: '',
  date: new Date().toISOString().split('T')[0],
  amount: '',
  payment_mode: '',
  transaction_id: '',
  receipt_number: props.receiptNumber,
  course_type: '',
  payment_type: '',
  installment_number: '',
  total_installments: '',
  discount_applied: 0,
  notes: '',
  status: 'Confirmed',
});

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const filterLeadsByCounselor = () => {
  if (form.counselor_id) {
    filteredLeads.value = props.leads.filter(lead => lead.counselor_id == form.counselor_id);
  } else {
    filteredLeads.value = [];
  }
  form.lead_id = '';
};

const netAmount = computed(() => {
  return (parseFloat(form.amount) || 0) - (parseFloat(form.discount_applied) || 0);
});

const submit = () => {
  form.post(route('admin.revenues.store'), {
    preserveScroll: true,
  });
};

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(number || 0);
};
</script>
