<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <Head title="My Revenues - Counselor" />

    <!-- Counselor Sidebar -->
    <CounselorSidebar
      :isMobileMenuOpen="isMobileMenuOpen"
      @closeMobileMenu="closeMobileMenu"
    />

    <!-- Main Content -->
    <div class="lg:pl-64">
      <!-- Counselor Topbar -->
      <CounselorTopbar @toggleMobileMenu="toggleMobileMenu" />

      <!-- Main Content Area -->
      <main class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
          <!-- Header -->
          <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">My Revenues</h1>
                <p class="mt-2 text-lg text-gray-600">Track your revenue performance and transactions</p>
              </div>
              <div class="flex space-x-3">
                <button
                  @click="exportRevenues"
                  class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-indigo-200 text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200 shadow-sm"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Export CSV
                </button>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4 flex-1">
                    <dt class="text-sm font-medium text-gray-500">Total Revenue</dt>
                    <dd class="text-2xl font-bold text-gray-900">₹{{ formatNumber(stats.total_revenue) }}</dd>
                    <span v-if="hasActiveFilters" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                      </svg>
                      Filtered
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4 flex-1">
                    <dt class="text-sm font-medium text-gray-500">Net Revenue</dt>
                    <dd class="text-2xl font-bold text-gray-900">₹{{ formatNumber(stats.net_revenue) }}</dd>
                    <span v-if="hasActiveFilters" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                      </svg>
                      Filtered
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4 flex-1">
                    <dt class="text-sm font-medium text-gray-500">Total Transactions</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.total_transactions }}</dd>
                    <span v-if="hasActiveFilters" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                      </svg>
                      Filtered
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4 flex-1">
                    <dt class="text-sm font-medium text-gray-500">This Month</dt>
                    <dd class="text-2xl font-bold text-gray-900">₹{{ formatNumber(stats.this_month_revenue) }}</dd>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Filters and Search -->
          <div class="bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-3xl border border-gray-200 overflow-hidden mb-8">
            <!-- Filter Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                  </div>
                  <h2 class="text-xl font-bold text-white">Filters & Search</h2>
                </div>
                <div v-if="hasActiveFilters" class="flex items-center space-x-2">
                  <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium text-white">
                    {{ activeFiltersCount }} active
                  </span>
                  <button
                    @click="clearFilters"
                    class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl text-sm font-medium text-white transition-all duration-200 flex items-center space-x-2"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Clear All</span>
                  </button>
                </div>
              </div>
            </div>

            <!-- Filter Content -->
            <div class="p-6">
              <!-- First Row: Search, Marketer -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Search -->
                <div class="lg:col-span-2">
                  <label for="search" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                  </label>
                  <div class="relative group">
                    <input
                      id="search"
                      v-model="searchQuery"
                      type="text"
                      placeholder="Search by receipt, transaction ID, lead name..."
                      class="w-full pl-11 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 bg-white hover:border-gray-300"
                      @input="debounceSearch"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                      </svg>
                    </div>
                    <div v-if="searchQuery" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                      <button @click="searchQuery = ''; applyFilters()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Marketer Filter -->
                <div>
                  <label for="marketer" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Marketer
                  </label>
                  <div class="relative">
                    <select
                      id="marketer"
                      v-model="marketerFilter"
                      class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none cursor-pointer"
                      @change="applyFilters"
                    >
                      <option value="">All Marketers</option>
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
                </div>
              </div>

              <!-- Second Row: Status, Payment Mode, Date From, Date To -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Status Filter -->
                <div>
                  <label for="status" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status
                  </label>
                  <div class="relative">
                    <select
                      id="status"
                      v-model="statusFilter"
                      class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none cursor-pointer"
                      @change="applyFilters"
                    >
                      <option value="">All Status</option>
                      <option value="Pending">Pending</option>
                      <option value="Confirmed">Confirmed</option>
                      <option value="Cancelled">Cancelled</option>
                      <option value="Refunded">Refunded</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                    </div>
                  </div>
                </div>

                <!-- Payment Mode Filter -->
                <div>
                  <label for="payment_mode" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Payment Mode
                  </label>
                  <div class="relative">
                    <select
                      id="payment_mode"
                      v-model="paymentModeFilter"
                      class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none cursor-pointer"
                      @change="applyFilters"
                    >
                      <option value="">All Modes</option>
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
                </div>

                <!-- Date From -->
                <div>
                  <label for="date_from" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Date From
                  </label>
                  <input
                    id="date_from"
                    v-model="dateFromFilter"
                    type="date"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 bg-white hover:border-gray-300 cursor-pointer"
                    @change="applyFilters"
                  >
                </div>

                <!-- Date To -->
                <div>
                  <label for="date_to" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Date To
                  </label>
                  <input
                    id="date_to"
                    v-model="dateToFilter"
                    type="date"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 bg-white hover:border-gray-300 cursor-pointer"
                    @change="applyFilters"
                  >
                </div>
              </div>
            </div>
          </div>

          <!-- Revenue Table -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                  <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Date
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Marketer
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Lead
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Payment Type
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Amount
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Mode
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-if="!revenues.data || revenues.data.length === 0">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                      </svg>
                      <p class="mt-4 text-lg font-medium">No revenue records found</p>
                      <p class="mt-1">Try adjusting your filters</p>
                    </td>
                  </tr>
                  <tr v-for="revenue in revenues.data" :key="revenue.id" class="hover:bg-blue-50 transition-colors cursor-pointer">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-semibold text-gray-900">{{ formatDate(revenue.date) }}</div>
                      <div class="text-xs text-gray-500">{{ revenue.receipt_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div v-if="revenue.marketer" class="text-sm font-medium text-gray-900">{{ revenue.marketer.name }}</div>
                      <div v-else class="text-sm text-gray-400 italic">No Marketer</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div v-if="revenue.lead" class="text-sm font-medium text-gray-900">{{ revenue.lead.student_name }}</div>
                      <div v-else class="text-sm text-gray-400 italic">No Lead</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ revenue.payment_type }}</div>
                      <div v-if="revenue.installment_number" class="text-xs text-gray-500">
                        {{ revenue.installment_number }}/{{ revenue.total_installments }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-bold text-green-600">₹{{ formatNumber(revenue.amount) }}</div>
                      <div v-if="revenue.discount_applied > 0" class="text-xs text-red-500">-₹{{ formatNumber(revenue.discount_applied) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" :class="getPaymentModeClass(revenue.payment_mode)">
                        {{ revenue.payment_mode }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" :class="getStatusClass(revenue.status)">
                        {{ revenue.status }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div v-if="revenues.data && revenues.data.length > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
              <div class="flex-1 flex justify-between sm:hidden">
                <button
                  v-if="revenues.prev_page_url"
                  @click="changePage(revenues.prev_page_url)"
                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                >
                  Previous
                </button>
                <button
                  v-if="revenues.next_page_url"
                  @click="changePage(revenues.next_page_url)"
                  class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                >
                  Next
                </button>
              </div>
              <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ revenues.from }}</span>
                    to
                    <span class="font-medium">{{ revenues.to }}</span>
                    of
                    <span class="font-medium">{{ revenues.total }}</span>
                    results
                  </p>
                </div>
                <div>
                  <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <button
                      v-if="revenues.prev_page_url"
                      @click="changePage(revenues.prev_page_url)"
                      class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                      <span class="sr-only">Previous</span>
                      <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                      </svg>
                    </button>
                    <button
                      v-if="revenues.next_page_url"
                      @click="changePage(revenues.next_page_url)"
                      class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                      <span class="sr-only">Next</span>
                      <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                      </svg>
                    </button>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import CounselorSidebar from '@/Components/Counselor/CounselorSidebar.vue';
import CounselorTopbar from '@/Components/Counselor/CounselorTopbar.vue';

const props = defineProps({
  revenues: {
    type: Object,
    default: () => ({
      data: [],
      links: [],
      total: 0,
      from: 0,
      to: 0,
      per_page: 20
    })
  },
  stats: {
    type: Object,
    default: () => ({
      total_revenue: 0,
      total_discount: 0,
      net_revenue: 0,
      total_transactions: 0,
      pending_count: 0,
      pending_amount: 0,
      this_month_revenue: 0
    })
  },
  marketers: {
    type: Array,
    default: () => []
  },
  filters: {
    type: Object,
    default: () => ({})
  },
});

const isMobileMenuOpen = ref(false);
const searchQuery = ref(props.filters.search || '');
const marketerFilter = ref(props.filters.marketer_id || '');
const statusFilter = ref(props.filters.status || '');
const paymentModeFilter = ref(props.filters.payment_mode || '');
const dateFromFilter = ref(props.filters.date_from || '');
const dateToFilter = ref(props.filters.date_to || '');

let searchTimeout = null;

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const hasActiveFilters = computed(() => {
  return searchQuery.value || marketerFilter.value || statusFilter.value ||
         paymentModeFilter.value || dateFromFilter.value || dateToFilter.value;
});

const activeFiltersCount = computed(() => {
  let count = 0;
  if (searchQuery.value) count++;
  if (marketerFilter.value) count++;
  if (statusFilter.value) count++;
  if (paymentModeFilter.value) count++;
  if (dateFromFilter.value) count++;
  if (dateToFilter.value) count++;
  return count;
});

const debounceSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    applyFilters();
  }, 500);
};

const applyFilters = () => {
  router.get(route('counselor.revenues.index'), {
    search: searchQuery.value,
    marketer_id: marketerFilter.value,
    status: statusFilter.value,
    payment_mode: paymentModeFilter.value,
    date_from: dateFromFilter.value,
    date_to: dateToFilter.value,
  }, {
    preserveState: true,
    preserveScroll: true,
  });
};

const clearFilters = () => {
  searchQuery.value = '';
  marketerFilter.value = '';
  statusFilter.value = '';
  paymentModeFilter.value = '';
  dateFromFilter.value = '';
  dateToFilter.value = '';
  router.get(route('counselor.revenues.index'));
};

const changePage = (url) => {
  router.get(url, {
    search: searchQuery.value,
    marketer_id: marketerFilter.value,
    status: statusFilter.value,
    payment_mode: paymentModeFilter.value,
    date_from: dateFromFilter.value,
    date_to: dateToFilter.value,
  }, {
    preserveState: true,
    preserveScroll: true,
  });
};

const exportRevenues = () => {
  window.location.href = route('counselor.revenues.export', {
    search: searchQuery.value,
    marketer_id: marketerFilter.value,
    status: statusFilter.value,
    payment_mode: paymentModeFilter.value,
    date_from: dateFromFilter.value,
    date_to: dateToFilter.value,
  });
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-IN', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(number || 0);
};

const getStatusClass = (status) => {
  const classes = {
    'Pending': 'bg-yellow-100 text-yellow-800',
    'Confirmed': 'bg-green-100 text-green-800',
    'Cancelled': 'bg-red-100 text-red-800',
    'Refunded': 'bg-gray-100 text-gray-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const getPaymentModeClass = (mode) => {
  const classes = {
    'Cash': 'bg-green-100 text-green-800',
    'UPI': 'bg-purple-100 text-purple-800',
    'Card': 'bg-blue-100 text-blue-800',
    'Net Banking': 'bg-indigo-100 text-indigo-800',
    'Cheque': 'bg-orange-100 text-orange-800',
    'Other': 'bg-gray-100 text-gray-800',
  };
  return classes[mode] || 'bg-gray-100 text-gray-800';
};
</script>
