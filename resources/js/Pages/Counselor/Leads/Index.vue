<template>
  <div class="min-h-screen bg-gray-50">
    <Head title="My Leads" />

    <!-- Counselor Sidebar -->
    <CounselorSidebar
      :isMobileMenuOpen="isMobileMenuOpen"
      @closeMobileMenu="closeMobileMenu"
    />

    <!-- Main Content Area -->
    <div class="lg:pl-64">
      <!-- Counselor Topbar -->
      <CounselorTopbar @toggleMobileMenu="toggleMobileMenu" />

      <!-- Page Content -->
      <main class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

          <!-- Page Header -->
          <div class="mb-8">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">My Leads</h1>
                <p class="mt-2 text-gray-600">Manage and track your assigned leads</p>
              </div>
              <div class="flex space-x-3">
                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-medium">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Today: {{ todayFollowUps }} follow-ups
                </span>
                <span v-if="overdueFollowUps > 0" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-lg font-medium">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3l-6.928-12c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  {{ overdueFollowUps }} overdue
                </span>
              </div>
            </div>
          </div>

          <!-- Statistics Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Leads -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Total Leads</p>
                  <p class="text-3xl font-bold text-gray-900 mt-2">{{ stats.total_leads }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Hot Leads -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 cursor-pointer hover:shadow-xl transition-shadow" @click="filterByCategory('Hot')">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Hot Leads</p>
                  <p class="text-3xl font-bold text-red-600 mt-2">{{ stats.hot_leads }}</p>
                  <p class="text-xs text-gray-500 mt-1">≤ 7 days</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Warm Leads -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 cursor-pointer hover:shadow-xl transition-shadow" @click="filterByCategory('Warm')">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Warm Leads</p>
                  <p class="text-3xl font-bold text-orange-600 mt-2">{{ stats.warm_leads }}</p>
                  <p class="text-xs text-gray-500 mt-1">8-20 days</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Cold Leads -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 cursor-pointer hover:shadow-xl transition-shadow" @click="filterByCategory('Cold')">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Cold Leads</p>
                  <p class="text-3xl font-bold text-blue-600 mt-2">{{ stats.cold_leads }}</p>
                  <p class="text-xs text-gray-500 mt-1">> 20 days</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Filters -->
          <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <!-- Search -->
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Leads</label>
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search by name, email, or mobile..."
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  @input="debounceSearch"
                />
              </div>

              <!-- Status Filter -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  v-model="statusFilter"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  @change="applyFilters"
                >
                  <option value="">All Status</option>
                  <option value="New">New</option>
                  <option value="Contacted">Contacted</option>
                  <option value="Interested">Interested</option>
                  <option value="Not Interested">Not Interested</option>
                  <option value="Enrolled">Enrolled</option>
                </select>
              </div>
            </div>

            <!-- Active Filters -->
            <div v-if="categoryFilter || statusFilter || searchQuery" class="mt-4 pt-4 border-t border-gray-200">
              <div class="flex items-center space-x-2">
                <span class="text-sm font-medium text-gray-700">Active Filters:</span>
                <span v-if="categoryFilter" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  {{ categoryFilter }}
                  <button @click="clearCategoryFilter" class="ml-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </span>
                <span v-if="statusFilter" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  {{ statusFilter }}
                  <button @click="statusFilter = ''; applyFilters()" class="ml-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </span>
                <button @click="clearAllFilters" class="text-sm text-blue-600 hover:text-blue-800 ml-2">
                  Clear All
                </button>
              </div>
            </div>
          </div>

          <!-- Leads Table -->
          <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div v-if="leads.data && leads.data.length > 0">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Follow-up</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="lead in leads.data" :key="lead.id" class="hover:bg-gray-50">
                      <!-- Category Badge -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          :class="{
                            'bg-red-100 text-red-800': lead.lead_category === 'Hot',
                            'bg-orange-100 text-orange-800': lead.lead_category === 'Warm',
                            'bg-blue-100 text-blue-800': lead.lead_category === 'Cold',
                            'bg-gray-100 text-gray-800': !lead.lead_category
                          }"
                          class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                        >
                          <span v-if="lead.lead_category === 'Hot'" class="mr-1">🔥</span>
                          <span v-if="lead.lead_category === 'Warm'" class="mr-1">☀️</span>
                          <span v-if="lead.lead_category === 'Cold'" class="mr-1">❄️</span>
                          {{ lead.lead_category || 'Uncategorized' }}
                        </span>
                      </td>

                      <!-- Student Name -->
                      <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ lead.student_name }}</div>
                        <div class="text-sm text-gray-500">Age: {{ lead.age || 'N/A' }}</div>
                      </td>

                      <!-- Contact -->
                      <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ lead.mobile_number }}</div>
                        <div class="text-sm text-gray-500">{{ lead.email || 'No email' }}</div>
                      </td>

                      <!-- Status -->
                      <td class="px-6 py-4">
                        <span
                          :class="{
                            'bg-blue-100 text-blue-800': lead.status === 'New',
                            'bg-yellow-100 text-yellow-800': lead.status === 'Contacted',
                            'bg-green-100 text-green-800': lead.status === 'Interested',
                            'bg-red-100 text-red-800': lead.status === 'Not Interested',
                            'bg-purple-100 text-purple-800': lead.status === 'Enrolled'
                          }"
                          class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                        >
                          {{ lead.status }}
                        </span>
                      </td>

                      <!-- Next Follow-up -->
                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span v-if="lead.next_follow_up_date" class="text-gray-900">
                          {{ formatDate(lead.next_follow_up_date) }}
                        </span>
                        <span v-else class="text-gray-400">Not scheduled</span>
                      </td>

                      <!-- Actions -->
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <Link
                          :href="`/counselor/leads/${lead.id}`"
                          class="text-blue-600 hover:text-blue-900 mr-3"
                        >
                          View Details
                        </Link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              <div v-if="leads.links && leads.links.length > 3" class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                  <div class="text-sm text-gray-700">
                    Showing {{ leads.from }} to {{ leads.to }} of {{ leads.total }} leads
                  </div>
                  <div class="flex space-x-2">
                    <Link
                      v-if="leads.prev_page_url"
                      :href="leads.prev_page_url"
                      class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                    >
                      Previous
                    </Link>
                    <Link
                      v-if="leads.next_page_url"
                      :href="leads.next_page_url"
                      class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                    >
                      Next
                    </Link>
                  </div>
                </div>
              </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">No leads found</h3>
              <p class="mt-1 text-sm text-gray-500">
                {{ searchQuery || categoryFilter || statusFilter ? 'Try adjusting your filters' : 'No leads assigned to you yet' }}
              </p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import CounselorSidebar from '../../../Components/Counselor/CounselorSidebar.vue'
import CounselorTopbar from '../../../Components/Counselor/CounselorTopbar.vue'

const props = defineProps({
  leads: Object,
  stats: Object,
  todayFollowUps: Number,
  overdueFollowUps: Number,
  filters: Object,
})

// State
const isMobileMenuOpen = ref(false)
const searchQuery = ref(props.filters.search || '')
const categoryFilter = ref(props.filters.category || '')
const statusFilter = ref(props.filters.status || '')
let searchTimeout = null

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
  if (categoryFilter.value) params.category = categoryFilter.value
  if (statusFilter.value) params.status = statusFilter.value

  router.get(route('counselor.leads.index'), params, {
    preserveState: true,
    replace: true,
  })
}

const filterByCategory = (category) => {
  categoryFilter.value = category
  applyFilters()
}

const clearCategoryFilter = () => {
  categoryFilter.value = ''
  applyFilters()
}

const clearAllFilters = () => {
  searchQuery.value = ''
  categoryFilter.value = ''
  statusFilter.value = ''
  router.get(route('counselor.leads.index'))
}

const formatDate = (dateString) => {
  if (!dateString) return 'N/A'

  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>
