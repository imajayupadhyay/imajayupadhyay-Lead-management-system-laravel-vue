<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <Head title="Manage Leads" />

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
                <h1 class="text-3xl font-bold text-gray-900">Manage Leads</h1>
                <p class="mt-2 text-lg text-gray-600">View, edit, and manage all student leads</p>
              </div>
              <div class="mt-4 sm:ml-4 sm:mt-0">
                <button
                  @click="openCreateModal"
                  class="btn btn-primary"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Add New Lead
                </button>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5 mb-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Total Leads</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.total_leads }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">New Leads</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.new_leads }}</dd>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Contacted</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.contacted_leads }}</dd>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Interested</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.interested_leads }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Enrolled</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.enrolled_leads }}</dd>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Filters and Search -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
              <!-- Search -->
              <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Leads</label>
                <div class="relative">
                  <input
                    id="search"
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search by name, email, or mobile..."
                    class="form-input pl-10"
                    @input="debounceSearch"
                  >
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Status Filter -->
              <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  id="status"
                  v-model="statusFilter"
                  class="form-input"
                  @change="applyFilters"
                >
                  <option value="">All Status</option>
                  <option v-for="status in filterOptions.statuses" :key="status" :value="status">
                    {{ status }}
                  </option>
                </select>
              </div>

              <!-- Qualification Filter -->
              <div>
                <label for="qualification" class="block text-sm font-medium text-gray-700 mb-2">Qualification</label>
                <select
                  id="qualification"
                  v-model="qualificationFilter"
                  class="form-input"
                  @change="applyFilters"
                >
                  <option value="">All Qualifications</option>
                  <option v-for="qualification in filterOptions.qualifications" :key="qualification" :value="qualification">
                    {{ qualification }}
                  </option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <!-- State Filter -->
              <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                <select
                  id="state"
                  v-model="stateFilter"
                  class="form-input"
                  @change="applyFilters"
                >
                  <option value="">All States</option>
                  <option v-for="state in filterOptions.states" :key="state" :value="state">
                    {{ state }}
                  </option>
                </select>
              </div>

              <!-- Counselor Filter -->
              <div>
                <label for="counselor" class="block text-sm font-medium text-gray-700 mb-2">Counselor</label>
                <select
                  id="counselor"
                  v-model="counselorFilter"
                  class="form-input"
                  @change="applyFilters"
                >
                  <option value="">All Counselors</option>
                  <option v-for="counselor in filterOptions.counselors" :key="counselor.id" :value="counselor.id">
                    {{ counselor.name }}
                  </option>
                </select>
              </div>

              <!-- Marketer Filter -->
              <div>
                <label for="marketer" class="block text-sm font-medium text-gray-700 mb-2">Marketer</label>
                <select
                  id="marketer"
                  v-model="marketerFilter"
                  class="form-input"
                  @change="applyFilters"
                >
                  <option value="">All Marketers</option>
                  <option v-for="marketer in filterOptions.marketers" :key="marketer.id" :value="marketer.id">
                    {{ marketer.name }}
                  </option>
                </select>
              </div>

              <!-- Date Range -->
              <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                <input
                  id="date_from"
                  v-model="dateFromFilter"
                  type="date"
                  class="form-input"
                  @change="applyFilters"
                >
              </div>
            </div>

            <!-- Clear Filters -->
            <div v-if="hasActiveFilters" class="mt-4 pt-4 border-t border-gray-200">
              <button
                @click="clearFilters"
                class="btn btn-outline btn-sm"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Clear Filters
              </button>
            </div>
          </div>

          <!-- Leads Table -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div v-if="leads.data.length > 0">
              <!-- Bulk Actions -->
              <div v-if="selectedLeads.length > 0" class="bg-blue-50 border-b border-blue-200 px-6 py-3">
                <div class="flex items-center justify-between">
                  <span class="text-sm font-medium text-blue-800">
                    {{ selectedLeads.length }} lead(s) selected
                  </span>
                  <div class="flex space-x-2">
                    <select
                      v-model="bulkStatus"
                      class="form-input text-sm py-1 px-2 border-blue-300"
                    >
                      <option value="">Update Status</option>
                      <option v-for="status in filterOptions.statuses" :key="status" :value="status">
                        {{ status }}
                      </option>
                    </select>
                    <button
                      @click="bulkAction('update_status')"
                      :disabled="!bulkStatus"
                      class="btn btn-sm btn-outline text-blue-600 border-blue-600 hover:bg-blue-50 disabled:opacity-50"
                    >
                      Update Status
                    </button>
                    <button
                      @click="bulkAction('delete')"
                      class="btn btn-sm btn-outline text-red-600 border-red-600 hover:bg-red-50"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>

              <!-- Table -->
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-4 text-left">
                        <input
                          type="checkbox"
                          :checked="selectedLeads.length === leads.data.length"
                          @change="toggleSelectAll"
                          class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Student Details
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Contact Info
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Academic Info
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Assignment
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Status
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Date
                      </th>
                      <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                      v-for="lead in leads.data"
                      :key="lead.id"
                      class="hover:bg-gray-50 transition-colors duration-200"
                    >
                      <td class="px-6 py-4">
                        <input
                          type="checkbox"
                          :value="lead.id"
                          v-model="selectedLeads"
                          class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                      </td>
                      <td class="px-6 py-4">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-12 w-12">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                              {{ getInitials(lead.student_name) }}
                            </div>
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-semibold text-gray-900">{{ lead.student_name }}</div>
                            <div class="text-sm text-gray-500">
                              ID: #{{ lead.id }} • 
                              <span v-if="lead.age">{{ lead.age }} years • </span>
                              {{ lead.gender || 'Not specified' }}
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ lead.email || 'No email' }}</div>
                        <div class="text-sm text-gray-500">{{ lead.mobile_number }}</div>
                        <div class="text-xs text-gray-400">{{ lead.state }}</div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ lead.qualification }}</div>
                        <div class="text-sm text-gray-500">{{ lead.college || 'No college specified' }}</div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                          <span v-if="lead.counselor">{{ lead.counselor.name }}</span>
                          <span v-else class="text-gray-400">No counselor</span>
                        </div>
                        <div class="text-sm text-gray-500">
                          <span v-if="lead.marketer">{{ lead.marketer.name }}</span>
                          <span v-else class="text-gray-400">No marketer</span>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <span
                          :class="[
                            'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                            getStatusClass(lead.status)
                          ]"
                        >
                          {{ lead.status }}
                        </span>
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-500">
                        {{ formatDate(lead.date) }}
                      </td>
                      <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                          <button
                            @click="showLead(lead)"
                            class="btn-icon btn-icon-blue"
                            title="View Details"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                          </button>
                          <button
                            @click="editLead(lead)"
                            class="btn-icon btn-icon-green"
                            title="Edit Lead"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                          </button>
                          <button
                            @click="confirmDelete(lead)"
                            class="btn-icon btn-icon-red"
                            title="Delete Lead"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-16">
              <div class="mx-auto h-24 w-24 text-gray-300">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-full w-full">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <h3 class="mt-4 text-lg font-medium text-gray-900">No leads found</h3>
              <p class="mt-2 text-gray-500 max-w-sm mx-auto">
                {{ hasActiveFilters ? 'No leads match your current filters. Try adjusting your search criteria.' : 'Get started by adding your first lead.' }}
              </p>
              <button
                v-if="!hasActiveFilters"
                @click="openCreateModal"
                class="btn btn-primary mt-4"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Lead
              </button>
            </div>

            <!-- Pagination -->
            <div v-if="leads.links && leads.links.length > 3" class="mt-8">
              <nav class="flex items-center justify-between bg-white px-6 py-4 rounded-2xl shadow-lg border border-gray-100">
                <div class="flex w-0 flex-1">
                  <Link
                    v-if="leads.prev_page_url"
                    :href="leads.prev_page_url"
                    class="btn btn-outline"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                  </Link>
                </div>
                <div class="text-sm text-gray-600 font-medium">
                  Showing {{ leads.from }} to {{ leads.to }} of {{ leads.total }} leads
                </div>
                <div class="flex justify-end w-0 flex-1">
                  <Link
                    v-if="leads.next_page_url"
                    :href="leads.next_page_url"
                    class="btn btn-outline"
                  >
                    Next
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </Link>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Create Lead Modal -->
    <CreateLeadModal
      :show="showCreateModal"
      :filterOptions="filterOptions"
      @close="closeCreateModal"
      @leadCreated="handleLeadCreated"
    />

    <!-- Edit Lead Modal -->
    <EditLeadModal
      :show="showEditModal"
      :lead="selectedLead"
      :filterOptions="filterOptions"
      @close="closeEditModal"
      @leadUpdated="handleLeadUpdated"
    />

    <!-- Show Lead Modal -->
    <ShowLeadModal
      :show="showShowModal"
      :lead="selectedLead"
      @close="closeShowModal"
      @editLead="handleEditFromShow"
      @deleteLead="handleDeleteFromShow"
    />

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>

        <div class="relative transform overflow-hidden rounded-2xl bg-white px-6 pb-6 pt-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-12 sm:w-12">
              <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-xl font-semibold leading-6 text-gray-900">Delete Lead</h3>
              <div class="mt-3">
                <p class="text-sm text-gray-600">
                  Are you sure you want to permanently delete the lead for <strong class="text-gray-900">{{ leadToDelete?.student_name }}</strong>? This action cannot be undone.
                </p>
              </div>
            </div>
          </div>
          <div class="mt-6 sm:flex sm:flex-row-reverse">
            <button
              @click="deleteLead"
              class="btn btn-danger sm:ml-3 sm:w-auto w-full"
            >
              Yes, Delete Lead
            </button>
            <button
              @click="showDeleteModal = false"
              class="btn btn-outline mt-3 sm:mt-0 sm:w-auto w-full"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminSidebar from '../../../Components/Admin/AdminSidebar.vue'
import AdminTopbar from '../../../Components/Admin/AdminTopbar.vue'
import CreateLeadModal from '../../../Components/Admin/Modals/CreateLeadModal.vue'
import EditLeadModal from '../../../Components/Admin/Modals/EditLeadModal.vue'
import ShowLeadModal from '../../../Components/Admin/Modals/ShowLeadModal.vue'

const props = defineProps({
  leads: Object,
  stats: Object,
  filterOptions: Object,
  filters: Object,
})

// State
const searchQuery = ref(props.filters.search || '')
const statusFilter = ref(props.filters.status || '')
const qualificationFilter = ref(props.filters.qualification || '')
const stateFilter = ref(props.filters.state || '')
const counselorFilter = ref(props.filters.counselor_id || '')
const marketerFilter = ref(props.filters.marketer_id || '')
const dateFromFilter = ref(props.filters.date_from || '')
const selectedLeads = ref([])
const bulkStatus = ref('')
const isMobileMenuOpen = ref(false)

// Modal states
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showShowModal = ref(false)
const showDeleteModal = ref(false)
const selectedLead = ref(null)
const leadToDelete = ref(null)

// Search debounce
let searchTimeout = null

// Computed
const hasActiveFilters = computed(() => {
  return searchQuery.value || statusFilter.value || qualificationFilter.value || 
         stateFilter.value || counselorFilter.value || marketerFilter.value || dateFromFilter.value
})

// Methods
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

const debounceSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    applyFilters()
  }, 500)
}

const applyFilters = () => {
  const params = {}
  
  if (searchQuery.value) params.search = searchQuery.value
  if (statusFilter.value) params.status = statusFilter.value
  if (qualificationFilter.value) params.qualification = qualificationFilter.value
  if (stateFilter.value) params.state = stateFilter.value
  if (counselorFilter.value) params.counselor_id = counselorFilter.value
  if (marketerFilter.value) params.marketer_id = marketerFilter.value
  if (dateFromFilter.value) params.date_from = dateFromFilter.value

  router.get(route('admin.leads.index'), params, {
    preserveState: true,
    replace: true,
  })
}

const clearFilters = () => {
  searchQuery.value = ''
  statusFilter.value = ''
  qualificationFilter.value = ''
  stateFilter.value = ''
  counselorFilter.value = ''
  marketerFilter.value = ''
  dateFromFilter.value = ''
  router.get(route('admin.leads.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

const getInitials = (name) => {
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const getStatusClass = (status) => {
  const statusClasses = {
    'New': 'bg-blue-100 text-blue-800',
    'Contacted': 'bg-yellow-100 text-yellow-800',
    'Interested': 'bg-purple-100 text-purple-800',
    'Not Interested': 'bg-red-100 text-red-800',
    'Enrolled': 'bg-green-100 text-green-800',
  }
  return statusClasses[status] || 'bg-gray-100 text-gray-800'
}

// Modal handlers
const openCreateModal = () => {
  showCreateModal.value = true
}

const closeCreateModal = () => {
  showCreateModal.value = false
}

const handleLeadCreated = () => {
  closeCreateModal()
  router.reload()
}

const editLead = (lead) => {
  selectedLead.value = lead
  showEditModal.value = true
}

const closeEditModal = () => {
  showEditModal.value = false
  selectedLead.value = null
}

const handleLeadUpdated = () => {
  closeEditModal()
  router.reload()
}

const showLead = (lead) => {
  selectedLead.value = lead
  showShowModal.value = true
}

const closeShowModal = () => {
  showShowModal.value = false
  selectedLead.value = null
}

const handleEditFromShow = (lead) => {
  closeShowModal()
  editLead(lead)
}

const handleDeleteFromShow = (lead) => {
  closeShowModal()
  confirmDelete(lead)
}

const confirmDelete = (lead) => {
  leadToDelete.value = lead
  showDeleteModal.value = true
}

const deleteLead = () => {
  if (leadToDelete.value) {
    router.delete(route('admin.leads.destroy', leadToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        leadToDelete.value = null
      }
    })
  }
}

// Bulk actions
const toggleSelectAll = (event) => {
  if (event.target.checked) {
    selectedLeads.value = props.leads.data.map(lead => lead.id)
  } else {
    selectedLeads.value = []
  }
}

const bulkAction = (action) => {
  if (selectedLeads.value.length === 0) return

  const data = {
    action: action,
    lead_ids: selectedLeads.value
  }

  if (action === 'update_status' && bulkStatus.value) {
    data.status = bulkStatus.value
  }

  router.post(route('admin.leads.bulk-action'), data, {
    onSuccess: () => {
      selectedLeads.value = []
      bulkStatus.value = ''
    }
  })
}
</script>

<style scoped>
@import '/resources/css/users.css';
</style>