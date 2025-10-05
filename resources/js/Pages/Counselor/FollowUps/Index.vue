<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Include Sidebar and Topbar -->
    <CounselorSidebar :isMobileMenuOpen="isMobileMenuOpen" @closeMobileMenu="closeMobileMenu" />
    <CounselorTopbar @toggleMobileMenu="toggleMobileMenu" />

    <div class="lg:pl-64">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Follow-ups Management</h1>
          <p class="text-gray-600">Manage and track all your scheduled follow-ups</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Total Follow-ups -->
          <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-600">Total Follow-ups</p>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ stats.total_follow_ups }}</p>
              </div>
              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Today's Follow-ups -->
          <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 cursor-pointer hover:shadow-xl transition-shadow" @click="filterByDate('today')">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-600">Today's Follow-ups</p>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ stats.today }}</p>
              </div>
              <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Overdue -->
          <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 cursor-pointer hover:shadow-xl transition-shadow" @click="filterByDate('overdue')">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-600">Overdue</p>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ stats.overdue }}</p>
              </div>
              <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Upcoming -->
          <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 cursor-pointer hover:shadow-xl transition-shadow" @click="filterByDate('upcoming')">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-600">Upcoming</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ stats.upcoming }}</p>
              </div>
              <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Filters and Actions -->
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg p-8 mb-8 border border-blue-100">
          <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <h3 class="text-xl font-bold text-gray-900">Filter Follow-ups</h3>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Filter by Status -->
            <div class="relative">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Status
                </span>
              </label>
              <div class="relative">
                <select
                  v-model="selectedStatus"
                  @change="applyFilters"
                  class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer hover:border-blue-300"
                >
                  <option value="">All Status</option>
                  <option value="Pending">🟡 Pending</option>
                  <option value="Completed">✅ Completed</option>
                  <option value="Missed">🔴 Missed</option>
                  <option value="Rescheduled">🔵 Rescheduled</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Filter by Time Period -->
            <div class="relative">
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  Time Period
                </span>
              </label>
              <div class="relative">
                <select
                  v-model="selectedFilter"
                  @change="applyFilters"
                  class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer hover:border-blue-300"
                >
                  <option value="">All Follow-ups</option>
                  <option value="today">📅 Today</option>
                  <option value="overdue">⚠️ Overdue</option>
                  <option value="upcoming">📈 Upcoming</option>
                  <option value="completed">✅ Completed</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Clear Filters Button -->
            <div class="flex items-end">
              <button
                v-if="selectedStatus || selectedFilter"
                @click="clearFilters"
                class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center space-x-2 group"
              >
                <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="font-semibold">Clear Filters</span>
              </button>
              <div
                v-else
                class="w-full px-6 py-3 bg-gray-100 text-gray-400 rounded-xl flex items-center justify-center space-x-2 cursor-not-allowed"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="font-semibold">No Active Filters</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Follow-ups Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Lead Info
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Follow-up Date
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Priority
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Contact Method
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Status
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Outcome
                  </th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr
                  v-for="followUp in followUps.data"
                  :key="followUp.id"
                  class="hover:bg-gray-50 transition-colors"
                >
                  <!-- Lead Info -->
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div>
                        <div class="text-sm font-medium text-gray-900">
                          {{ followUp.lead?.student_name || 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-500">
                          {{ followUp.lead?.mobile_number || 'N/A' }}
                        </div>
                      </div>
                    </div>
                  </td>

                  <!-- Follow-up Date -->
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                      {{ formatDate(followUp.follow_up_date) }}
                    </div>
                    <div v-if="followUp.follow_up_time" class="text-xs text-gray-500">
                      {{ followUp.follow_up_time }}
                    </div>
                  </td>

                  <!-- Priority -->
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      :class="{
                        'bg-red-100 text-red-800': followUp.priority === 'High',
                        'bg-orange-100 text-orange-800': followUp.priority === 'Medium',
                        'bg-blue-100 text-blue-800': followUp.priority === 'Low'
                      }"
                      class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                    >
                      {{ followUp.priority }}
                    </span>
                  </td>

                  <!-- Contact Method -->
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ followUp.contact_method }}</div>
                  </td>

                  <!-- Status -->
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      :class="{
                        'bg-green-100 text-green-800': followUp.status === 'Completed',
                        'bg-yellow-100 text-yellow-800': followUp.status === 'Pending',
                        'bg-red-100 text-red-800': followUp.status === 'Missed',
                        'bg-blue-100 text-blue-800': followUp.status === 'Rescheduled'
                      }"
                      class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                    >
                      {{ followUp.status }}
                    </span>
                  </td>

                  <!-- Outcome -->
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ followUp.outcome || '-' }}</div>
                  </td>

                  <!-- Actions -->
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex items-center space-x-2">
                      <a
                        :href="`/counselor/leads/${followUp.lead_id}`"
                        class="text-blue-600 hover:text-blue-900 font-medium"
                      >
                        View Lead
                      </a>
                      <span v-if="followUp.status === 'Pending'" class="text-gray-300">|</span>
                      <button
                        v-if="followUp.status === 'Pending'"
                        @click="openCompleteModal(followUp)"
                        class="text-green-600 hover:text-green-900 font-medium"
                      >
                        Complete
                      </button>
                      <span class="text-gray-300">|</span>
                      <button
                        @click="openDeleteModal(followUp)"
                        class="text-red-600 hover:text-red-900 font-medium"
                      >
                        Delete
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Empty State -->
          <div v-if="!followUps.data || followUps.data.length === 0" class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-gray-600 text-lg mb-2">No follow-ups found</p>
            <p class="text-gray-500">Follow-ups will appear here once scheduled</p>
          </div>

          <!-- Pagination -->
          <div v-if="followUps.data && followUps.data.length > 0" class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4">
            <div class="flex items-center justify-between">
              <div class="text-sm text-gray-700">
                Showing {{ followUps.from }} to {{ followUps.to }} of {{ followUps.total }} results
              </div>
              <div class="flex space-x-2">
                <a
                  v-for="link in followUps.links"
                  :key="link.label"
                  :href="link.url"
                  :class="{
                    'bg-blue-600 text-white': link.active,
                    'bg-white text-gray-700 hover:bg-gray-100': !link.active,
                    'opacity-50 cursor-not-allowed': !link.url
                  }"
                  class="px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-gray-300"
                  v-html="link.label"
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Complete Follow-up Modal -->
    <div v-if="showCompleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Complete Follow-up</h2>
            <button @click="showCompleteModal = false" class="text-gray-400 hover:text-gray-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <form @submit.prevent="submitCompleteFollowUp">
            <div class="space-y-4">
              <!-- Status -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select
                  v-model="completeForm.status"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="Completed">Completed</option>
                  <option value="Missed">Missed</option>
                  <option value="Rescheduled">Rescheduled</option>
                </select>
              </div>

              <!-- Outcome -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Outcome</label>
                <select
                  v-model="completeForm.outcome"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Select outcome</option>
                  <option value="Interested">Interested</option>
                  <option value="Not Interested">Not Interested</option>
                  <option value="Call Back Later">Call Back Later</option>
                  <option value="No Response">No Response</option>
                  <option value="Enrolled">Enrolled</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <!-- Notes -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                <textarea
                  v-model="completeForm.notes"
                  rows="4"
                  placeholder="Add any additional notes about this follow-up..."
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
              </div>

              <!-- Next Follow-up Date -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Next Follow-up Date</label>
                <input
                  v-model="completeForm.next_follow_up_date"
                  type="date"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
              <button
                type="button"
                @click="showCompleteModal = false"
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all shadow-md"
              >
                Save & Complete
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
          <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Delete Follow-up</h3>
          <p class="text-gray-600 text-center mb-6">
            Are you sure you want to delete this follow-up? This action cannot be undone.
          </p>
          <div class="flex space-x-3">
            <button
              @click="showDeleteModal = false"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Cancel
            </button>
            <button
              @click="deleteFollowUp"
              class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import CounselorSidebar from '@/Components/Counselor/CounselorSidebar.vue'
import CounselorTopbar from '@/Components/Counselor/CounselorTopbar.vue'

const props = defineProps({
  followUps: {
    type: Object,
    required: true
  },
  stats: {
    type: Object,
    required: true
  },
  filters: {
    type: Object,
    default: () => ({})
  }
})

// Mobile menu state
const isMobileMenuOpen = ref(false)
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}
const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

// Filter states
const selectedStatus = ref(props.filters.status || '')
const selectedFilter = ref(props.filters.filter || '')

// Modal states
const showCompleteModal = ref(false)
const showDeleteModal = ref(false)
const selectedFollowUp = ref(null)

// Complete form
const completeForm = ref({
  status: 'Completed',
  outcome: '',
  notes: '',
  next_follow_up_date: ''
})

// Filter functions
const filterByDate = (filter) => {
  selectedFilter.value = filter
  applyFilters()
}

const applyFilters = () => {
  router.get('/counselor/follow-ups', {
    status: selectedStatus.value,
    filter: selectedFilter.value
  }, {
    preserveState: true,
    preserveScroll: true
  })
}

const clearFilters = () => {
  selectedStatus.value = ''
  selectedFilter.value = ''
  router.get('/counselor/follow-ups')
}

// Complete follow-up
const openCompleteModal = (followUp) => {
  selectedFollowUp.value = followUp
  completeForm.value = {
    status: 'Completed',
    outcome: '',
    notes: '',
    next_follow_up_date: ''
  }
  showCompleteModal.value = true
}

const submitCompleteFollowUp = () => {
  router.put(`/counselor/follow-ups/${selectedFollowUp.value.id}`, completeForm.value, {
    preserveScroll: true,
    onSuccess: () => {
      showCompleteModal.value = false
      selectedFollowUp.value = null
    }
  })
}

// Delete follow-up
const openDeleteModal = (followUp) => {
  selectedFollowUp.value = followUp
  showDeleteModal.value = true
}

const deleteFollowUp = () => {
  router.delete(`/counselor/follow-ups/${selectedFollowUp.value.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false
      selectedFollowUp.value = null
    }
  })
}

// Format date
const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
