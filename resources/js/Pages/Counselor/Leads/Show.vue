<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Include Sidebar and Topbar -->
    <CounselorSidebar :isMobileMenuOpen="isMobileMenuOpen" @closeMobileMenu="closeMobileMenu" />
    <CounselorTopbar @toggleMobileMenu="toggleMobileMenu" />

    <div class="lg:pl-64">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <div class="mb-6">
          <a
            href="/counselor/leads"
            class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Leads
          </a>
        </div>

        <!-- Lead Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
              <div class="flex items-center space-x-3 mb-2">
                <h1 class="text-3xl font-bold text-gray-900">{{ lead.student_name }}</h1>
                <span
                  :class="{
                    'bg-red-100 text-red-800': lead.lead_category === 'Hot',
                    'bg-orange-100 text-orange-800': lead.lead_category === 'Warm',
                    'bg-blue-100 text-blue-800': lead.lead_category === 'Cold'
                  }"
                  class="px-3 py-1 rounded-full text-xs font-semibold"
                >
                  <span v-if="lead.lead_category === 'Hot'">🔥</span>
                  <span v-if="lead.lead_category === 'Warm'">☀️</span>
                  <span v-if="lead.lead_category === 'Cold'">❄️</span>
                  {{ lead.lead_category }} Lead
                </span>
              </div>
              <p class="text-gray-600">Lead ID: #{{ lead.id }}</p>
            </div>
            <div class="mt-4 md:mt-0">
              <select
                v-model="selectedStatus"
                @change="updateLeadStatus"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="New">New</option>
                <option value="Contacted">Contacted</option>
                <option value="Interested">Interested</option>
                <option value="Not Interested">Not Interested</option>
                <option value="Enrolled">Enrolled</option>
              </select>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Lead Details -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Contact Information -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Contact Information
              </h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <p class="text-sm font-medium text-gray-600">Email</p>
                  <p class="text-gray-900 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ lead.email }}
                  </p>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-600">Mobile Number</p>
                  <p class="text-gray-900 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ lead.mobile_number }}
                  </p>
                </div>
                <div v-if="lead.father_name">
                  <p class="text-sm font-medium text-gray-600">Father's Name</p>
                  <p class="text-gray-900 mt-1">{{ lead.father_name }}</p>
                </div>
                <div v-if="lead.father_contact">
                  <p class="text-sm font-medium text-gray-600">Father's Contact</p>
                  <p class="text-gray-900 mt-1">{{ lead.father_contact }}</p>
                </div>
                <div v-if="lead.address">
                  <p class="text-sm font-medium text-gray-600">Address</p>
                  <p class="text-gray-900 mt-1">{{ lead.address }}</p>
                </div>
                <div v-if="lead.location">
                  <p class="text-sm font-medium text-gray-600">Location</p>
                  <p class="text-gray-900 mt-1">{{ lead.location }}</p>
                </div>
              </div>
            </div>

            <!-- Course Information -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Course Information
              </h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div v-if="lead.course_interested">
                  <p class="text-sm font-medium text-gray-600">Course Interested</p>
                  <p class="text-gray-900 mt-1">{{ lead.course_interested }}</p>
                </div>
                <div v-if="lead.session">
                  <p class="text-sm font-medium text-gray-600">Session</p>
                  <p class="text-gray-900 mt-1">{{ lead.session }}</p>
                </div>
                <div v-if="lead.qualification">
                  <p class="text-sm font-medium text-gray-600">Qualification</p>
                  <p class="text-gray-900 mt-1">{{ lead.qualification }}</p>
                </div>
              </div>
            </div>

            <!-- Follow-up History -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                  <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  Follow-up History
                </h2>
                <button
                  @click="showAddFollowUpModal = true"
                  class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md"
                >
                  + Add Follow-up
                </button>
              </div>

              <!-- Follow-up Timeline -->
              <div v-if="lead.follow_ups && lead.follow_ups.length > 0" class="space-y-4">
                <div
                  v-for="followUp in lead.follow_ups"
                  :key="followUp.id"
                  class="border-l-4 pl-4 py-3"
                  :class="{
                    'border-green-500 bg-green-50': followUp.status === 'Completed',
                    'border-yellow-500 bg-yellow-50': followUp.status === 'Pending',
                    'border-red-500 bg-red-50': followUp.status === 'Missed',
                    'border-blue-500 bg-blue-50': followUp.status === 'Rescheduled'
                  }"
                >
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <div class="flex items-center space-x-2 mb-2">
                        <span
                          :class="{
                            'bg-green-100 text-green-800': followUp.status === 'Completed',
                            'bg-yellow-100 text-yellow-800': followUp.status === 'Pending',
                            'bg-red-100 text-red-800': followUp.status === 'Missed',
                            'bg-blue-100 text-blue-800': followUp.status === 'Rescheduled'
                          }"
                          class="px-2 py-1 rounded-full text-xs font-semibold"
                        >
                          {{ followUp.status }}
                        </span>
                        <span
                          :class="{
                            'bg-red-100 text-red-800': followUp.priority === 'High',
                            'bg-orange-100 text-orange-800': followUp.priority === 'Medium',
                            'bg-blue-100 text-blue-800': followUp.priority === 'Low'
                          }"
                          class="px-2 py-1 rounded-full text-xs font-semibold"
                        >
                          {{ followUp.priority }} Priority
                        </span>
                        <span class="text-xs text-gray-500">{{ followUp.contact_method }}</span>
                      </div>
                      <p class="text-sm font-medium text-gray-900 mb-1">
                        {{ formatDate(followUp.follow_up_date) }}
                        <span v-if="followUp.follow_up_time" class="text-gray-500">at {{ followUp.follow_up_time }}</span>
                      </p>
                      <p class="text-sm text-gray-700 mb-2">{{ followUp.notes }}</p>
                      <div v-if="followUp.outcome" class="text-sm">
                        <span class="font-medium text-gray-600">Outcome:</span>
                        <span class="text-gray-900 ml-1">{{ followUp.outcome }}</span>
                      </div>
                      <div v-if="followUp.next_follow_up_date" class="text-sm mt-1">
                        <span class="font-medium text-gray-600">Next Follow-up:</span>
                        <span class="text-gray-900 ml-1">{{ formatDate(followUp.next_follow_up_date) }}</span>
                      </div>
                    </div>
                    <div v-if="followUp.status === 'Pending'" class="ml-4">
                      <button
                        @click="openCompleteFollowUpModal(followUp)"
                        class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors"
                      >
                        Mark Complete
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- No Follow-ups State -->
              <div v-else class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-600">No follow-ups recorded yet</p>
                <button
                  @click="showAddFollowUpModal = true"
                  class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                  Add First Follow-up
                </button>
              </div>
            </div>
          </div>

          <!-- Sidebar - Quick Stats -->
          <div class="lg:col-span-1 space-y-6">
            <!-- Lead Status Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Lead Status</h3>
              <div class="space-y-3">
                <div>
                  <p class="text-sm font-medium text-gray-600">Current Status</p>
                  <p
                    :class="{
                      'text-green-600': lead.status === 'Enrolled',
                      'text-blue-600': lead.status === 'Interested',
                      'text-yellow-600': lead.status === 'Contacted',
                      'text-gray-600': lead.status === 'New',
                      'text-red-600': lead.status === 'Not Interested'
                    }"
                    class="text-lg font-semibold mt-1"
                  >
                    {{ lead.status }}
                  </p>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-600">Lead Category</p>
                  <p class="text-lg font-semibold mt-1">{{ lead.lead_category || 'Not Categorized' }}</p>
                </div>
                <div v-if="lead.next_follow_up_date">
                  <p class="text-sm font-medium text-gray-600">Next Follow-up</p>
                  <p class="text-lg font-semibold text-blue-600 mt-1">{{ formatDate(lead.next_follow_up_date) }}</p>
                </div>
                <div v-if="lead.last_follow_up_date">
                  <p class="text-sm font-medium text-gray-600">Last Follow-up</p>
                  <p class="text-gray-900 mt-1">{{ formatDate(lead.last_follow_up_date) }}</p>
                </div>
              </div>
            </div>

            <!-- Follow-up Stats Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Follow-up Stats</h3>
              <div class="space-y-3">
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-gray-600">Total Follow-ups</p>
                  <p class="text-lg font-semibold text-gray-900">{{ lead.follow_up_count || 0 }}</p>
                </div>
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-gray-600">Completed</p>
                  <p class="text-lg font-semibold text-green-600">{{ completedFollowUps }}</p>
                </div>
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium text-gray-600">Pending</p>
                  <p class="text-lg font-semibold text-yellow-600">{{ pendingFollowUps }}</p>
                </div>
              </div>
            </div>

            <!-- Assignment Info Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Assignment Info</h3>
              <div class="space-y-3">
                <div v-if="lead.counselor">
                  <p class="text-sm font-medium text-gray-600">Counselor</p>
                  <p class="text-gray-900 mt-1">{{ lead.counselor.name }}</p>
                </div>
                <div v-if="lead.marketer">
                  <p class="text-sm font-medium text-gray-600">Marketer</p>
                  <p class="text-gray-900 mt-1">{{ lead.marketer.name }}</p>
                </div>
                <div v-if="lead.faculty">
                  <p class="text-sm font-medium text-gray-600">Faculty</p>
                  <p class="text-gray-900 mt-1">{{ lead.faculty.name }}</p>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-600">Created On</p>
                  <p class="text-gray-900 mt-1">{{ formatDate(lead.created_at) }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Follow-up Modal (placeholder - will be created next) -->
    <div v-if="showAddFollowUpModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Add Follow-up</h2>
            <button @click="showAddFollowUpModal = false" class="text-gray-400 hover:text-gray-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <form @submit.prevent="submitFollowUp">
            <div class="space-y-4">
              <!-- Follow-up Date -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Follow-up Date *</label>
                <input
                  v-model="followUpForm.follow_up_date"
                  type="date"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Follow-up Time -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Follow-up Time</label>
                <input
                  v-model="followUpForm.follow_up_time"
                  type="time"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>

              <!-- Priority -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                <select
                  v-model="followUpForm.priority"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="High">High</option>
                  <option value="Medium">Medium</option>
                  <option value="Low">Low</option>
                </select>
              </div>

              <!-- Contact Method -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Method *</label>
                <select
                  v-model="followUpForm.contact_method"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="Phone">Phone</option>
                  <option value="Email">Email</option>
                  <option value="WhatsApp">WhatsApp</option>
                  <option value="In-Person">In-Person</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <!-- Notes -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes *</label>
                <textarea
                  v-model="followUpForm.notes"
                  required
                  rows="4"
                  placeholder="Enter follow-up notes..."
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
              </div>

              <!-- Next Follow-up Date -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Next Follow-up Date (Optional)</label>
                <input
                  v-model="followUpForm.next_follow_up_date"
                  type="date"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
              <button
                type="button"
                @click="showAddFollowUpModal = false"
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md"
              >
                Add Follow-up
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Complete Follow-up Modal -->
    <div v-if="showCompleteFollowUpModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Complete Follow-up</h2>
            <button @click="showCompleteFollowUpModal = false" class="text-gray-400 hover:text-gray-600">
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
                @click="showCompleteFollowUpModal = false"
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
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import CounselorSidebar from '@/Components/Counselor/CounselorSidebar.vue'
import CounselorTopbar from '@/Components/Counselor/CounselorTopbar.vue'

const props = defineProps({
  lead: {
    type: Object,
    required: true
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

// Lead status
const selectedStatus = ref(props.lead.status)

// Modal states
const showAddFollowUpModal = ref(false)
const showCompleteFollowUpModal = ref(false)
const selectedFollowUp = ref(null)

// Follow-up form
const followUpForm = ref({
  follow_up_date: '',
  follow_up_time: '',
  priority: 'Medium',
  contact_method: 'Phone',
  notes: '',
  next_follow_up_date: ''
})

// Complete follow-up form
const completeForm = ref({
  status: 'Completed',
  outcome: '',
  notes: '',
  next_follow_up_date: ''
})

// Computed properties
const completedFollowUps = computed(() => {
  if (!props.lead.follow_ups) return 0
  return props.lead.follow_ups.filter(fu => fu.status === 'Completed').length
})

const pendingFollowUps = computed(() => {
  if (!props.lead.follow_ups) return 0
  return props.lead.follow_ups.filter(fu => fu.status === 'Pending').length
})

// Update lead status
const updateLeadStatus = () => {
  router.post(`/counselor/leads/${props.lead.id}/update-status`, {
    status: selectedStatus.value
  }, {
    preserveScroll: true,
    onSuccess: () => {
      console.log('Lead status updated successfully')
    }
  })
}

// Submit follow-up
const submitFollowUp = () => {
  router.post('/counselor/follow-ups', {
    lead_id: props.lead.id,
    ...followUpForm.value
  }, {
    preserveScroll: true,
    onSuccess: () => {
      showAddFollowUpModal.value = false
      followUpForm.value = {
        follow_up_date: '',
        follow_up_time: '',
        priority: 'Medium',
        contact_method: 'Phone',
        notes: '',
        next_follow_up_date: ''
      }
    }
  })
}

// Open complete follow-up modal
const openCompleteFollowUpModal = (followUp) => {
  selectedFollowUp.value = followUp
  completeForm.value = {
    status: 'Completed',
    outcome: '',
    notes: '',
    next_follow_up_date: ''
  }
  showCompleteFollowUpModal.value = true
}

// Submit complete follow-up
const submitCompleteFollowUp = () => {
  router.put(`/counselor/follow-ups/${selectedFollowUp.value.id}`, completeForm.value, {
    preserveScroll: true,
    onSuccess: () => {
      showCompleteFollowUpModal.value = false
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
