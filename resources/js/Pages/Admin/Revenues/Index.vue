<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <Head title="Revenue Management" />

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
        <div class="mx-auto max-w-7xl">
          <!-- Header Section -->
          <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Revenue Management</h1>
                <p class="mt-2 text-lg text-gray-600">Track and manage all revenue transactions</p>
              </div>
              <div class="mt-4 flex flex-wrap gap-3 sm:ml-4 sm:mt-0">
                <button
                  @click="exportRevenues"
                  class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-emerald-500 text-emerald-700 font-semibold rounded-xl hover:bg-emerald-50 hover:border-emerald-600 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Export CSV
                </button>
                <Link
                  :href="route('admin.revenues.create')"
                  class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Add Revenue
                </Link>
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
                    <dt class="text-sm font-medium text-gray-500">Pending</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.pending_count }}</dd>
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
          </div>

          <!-- Filters and Search -->
          <div class="bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-3xl border border-gray-200 overflow-hidden mb-8">
            <!-- Filter Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
              <!-- First Row: Search, Counselor, Marketer -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
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

                <!-- Counselor Filter -->
                <div>
                  <label for="counselor" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Counselor
                  </label>
                  <div class="relative">
                    <select
                      id="counselor"
                      v-model="counselorFilter"
                      class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white hover:border-gray-300 appearance-none cursor-pointer"
                      @change="applyFilters"
                    >
                      <option value="">All Counselors</option>
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
                      Counselor
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
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-if="!revenues.data || revenues.data.length === 0">
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                      </svg>
                      <p class="mt-4 text-lg font-medium">No revenue records found</p>
                      <p class="mt-1">Try adjusting your filters or add a new revenue record</p>
                    </td>
                  </tr>
                  <tr
                    v-for="revenue in revenues.data"
                    :key="revenue.id"
                    class="hover:bg-blue-50 transition-all duration-200 cursor-pointer group"
                    @click="openShowModal(revenue)"
                  >
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-semibold text-gray-900">{{ formatDate(revenue.date) }}</div>
                      <div class="text-xs text-gray-500">{{ revenue.receipt_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-medium text-gray-900">{{ revenue.counselor?.name }}</div>
                      <div class="text-xs text-gray-500">{{ revenue.counselor?.email }}</div>
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
                      <div v-if="revenue.discount_applied > 0" class="text-xs text-red-600">
                        -₹{{ formatNumber(revenue.discount_applied) }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-md">
                        {{ revenue.payment_mode }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="getStatusClass(revenue.status)" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                        {{ revenue.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap" @click.stop>
                      <div class="flex justify-center items-center space-x-2">
                        <button
                          @click="openShowModal(revenue)"
                          class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-all duration-200"
                          title="View Details"
                        >
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                        </button>
                        <Link
                          v-if="revenue.status === 'Pending' || revenue.status === 'Confirmed'"
                          :href="route('admin.revenues.edit', revenue.id)"
                          class="p-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition-all duration-200"
                          title="Edit"
                        >
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                          </svg>
                        </Link>
                        <button
                          @click="deleteRevenue(revenue)"
                          class="p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-all duration-200"
                          title="Delete"
                        >
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div v-if="revenues.data && revenues.data.length > 0 && revenues.total > revenues.per_page" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
              <div class="flex flex-col sm:flex-row items-center justify-between">
                <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                  Showing <span class="font-medium">{{ revenues.from || 0 }}</span> to <span class="font-medium">{{ revenues.to || 0 }}</span> of <span class="font-medium">{{ revenues.total || 0 }}</span> results
                </div>
                <div class="flex space-x-2">
                  <template v-for="(link, index) in revenues.links" :key="index">
                    <Link
                      v-if="link.url"
                      :href="link.url"
                      v-html="link.label"
                      :class="[
                        'px-3 py-2 text-sm rounded-lg transition-colors',
                        link.active
                          ? 'bg-blue-600 text-white font-semibold'
                          : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300'
                      ]"
                    />
                    <span
                      v-else
                      v-html="link.label"
                      class="px-3 py-2 text-sm rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed"
                    />
                  </template>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Show Revenue Modal -->
    <ShowRevenueModal
      :show="showModal"
      :revenue="selectedRevenue"
      @close="closeShowModal"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue';
import AdminTopbar from '@/Components/Admin/AdminTopbar.vue';
import ShowRevenueModal from '@/Components/Admin/Modals/ShowRevenueModal.vue';

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
      today_revenue: 0,
      this_month_revenue: 0
    })
  },
  counselors: {
    type: Array,
    default: () => []
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
const counselorFilter = ref(props.filters.counselor_id || '');
const marketerFilter = ref(props.filters.marketer_id || '');
const statusFilter = ref(props.filters.status || '');
const paymentModeFilter = ref(props.filters.payment_mode || '');
const dateFromFilter = ref(props.filters.date_from || '');
const dateToFilter = ref(props.filters.date_to || '');

// Modal state
const showModal = ref(false);
const selectedRevenue = ref({});

let searchTimeout = null;

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const hasActiveFilters = computed(() => {
  return searchQuery.value || counselorFilter.value || marketerFilter.value || statusFilter.value ||
         paymentModeFilter.value || dateFromFilter.value || dateToFilter.value;
});

const activeFiltersCount = computed(() => {
  let count = 0;
  if (searchQuery.value) count++;
  if (counselorFilter.value) count++;
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
  router.get(route('admin.revenues.index'), {
    search: searchQuery.value,
    counselor_id: counselorFilter.value,
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
  counselorFilter.value = '';
  marketerFilter.value = '';
  statusFilter.value = '';
  paymentModeFilter.value = '';
  dateFromFilter.value = '';
  dateToFilter.value = '';
  router.get(route('admin.revenues.index'));
};

const deleteRevenue = (revenue, event) => {
  if (event) event.stopPropagation();
  if (confirm(`Are you sure you want to delete revenue record ${revenue.receipt_number}?`)) {
    router.delete(route('admin.revenues.destroy', revenue.id));
  }
};

const exportRevenues = () => {
  const params = new URLSearchParams({
    counselor_id: counselorFilter.value,
    date_from: dateFromFilter.value,
    date_to: dateToFilter.value,
  });
  window.location.href = route('admin.revenues.export') + '?' + params.toString();
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-IN', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-IN').format(number || 0);
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

const openShowModal = (revenue) => {
  selectedRevenue.value = revenue;
  showModal.value = true;
};

const closeShowModal = () => {
  showModal.value = false;
  setTimeout(() => {
    selectedRevenue.value = {};
  }, 300);
};
</script>
