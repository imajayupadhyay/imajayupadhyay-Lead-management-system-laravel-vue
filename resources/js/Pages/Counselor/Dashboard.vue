<template>
  <Head title="Dashboard - Counselor" />
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
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
          <!-- Welcome Message - Compact -->
          <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ user.name }}! 👋</h1>
            <p class="text-gray-600 mt-2">Here's what's happening with your leads today</p>
          </div>

          <!-- Lead Statistics Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Leads -->
            <a href="/counselor/leads" class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Total Leads</p>
                  <p class="text-3xl font-bold text-blue-600 mt-2">{{ stats.total_leads }}</p>
                  <p class="text-xs text-gray-500 mt-1">All assigned leads</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
              </div>
            </a>

            <!-- Hot Leads -->
            <a href="/counselor/leads?category=Hot" class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Hot Leads 🔥</p>
                  <p class="text-3xl font-bold text-red-600 mt-2">{{ stats.hot_leads }}</p>
                  <p class="text-xs text-gray-500 mt-1">≤ 7 days</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                </div>
              </div>
            </a>

            <!-- Warm Leads -->
            <a href="/counselor/leads?category=Warm" class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Warm Leads ☀️</p>
                  <p class="text-3xl font-bold text-orange-600 mt-2">{{ stats.warm_leads }}</p>
                  <p class="text-xs text-gray-500 mt-1">8-20 days</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                  </svg>
                </div>
              </div>
            </a>

            <!-- Cold Leads -->
            <a href="/counselor/leads?category=Cold" class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-400 hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-600">Cold Leads ❄️</p>
                  <p class="text-3xl font-bold text-blue-400 mt-2">{{ stats.cold_leads }}</p>
                  <p class="text-xs text-gray-500 mt-1">> 20 days</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </div>
              </div>
            </a>
          </div>

          <!-- Follow-up Statistics Cards -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Today's Follow-ups -->
            <a href="/counselor/follow-ups?filter=today" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-purple-100 text-sm font-medium">Today's Follow-ups</p>
                  <p class="text-4xl font-bold mt-2">{{ followUpStats.today_follow_ups }}</p>
                  <p class="text-purple-200 text-sm mt-2">Scheduled for today</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
            </a>

            <!-- Overdue Follow-ups -->
            <a href="/counselor/follow-ups?filter=overdue" class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-red-100 text-sm font-medium">Overdue Follow-ups</p>
                  <p class="text-4xl font-bold mt-2">{{ followUpStats.overdue_follow_ups }}</p>
                  <p class="text-red-200 text-sm mt-2">Needs attention!</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
            </a>

            <!-- Upcoming Follow-ups -->
            <a href="/counselor/follow-ups?filter=upcoming" class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-green-100 text-sm font-medium">Upcoming Follow-ups</p>
                  <p class="text-4xl font-bold mt-2">{{ followUpStats.upcoming_follow_ups }}</p>
                  <p class="text-green-200 text-sm mt-2">Next few days</p>
                </div>
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                  </svg>
                </div>
              </div>
            </a>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Today's Follow-ups List -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                  <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  Today's Follow-ups
                </h3>
                <a href="/counselor/follow-ups?filter=today" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                  View All →
                </a>
              </div>

              <div v-if="todayFollowUps && todayFollowUps.length > 0" class="space-y-3">
                <div
                  v-for="followUp in todayFollowUps"
                  :key="followUp.id"
                  class="p-4 bg-purple-50 border border-purple-100 rounded-lg hover:shadow-md transition-shadow"
                >
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <h4 class="font-semibold text-gray-900">{{ followUp.lead?.student_name || 'N/A' }}</h4>
                      <p class="text-sm text-gray-600 mt-1">{{ followUp.lead?.mobile_number || 'N/A' }}</p>
                      <div class="flex items-center mt-2 space-x-2">
                        <span class="text-xs bg-purple-200 text-purple-800 px-2 py-1 rounded-full font-medium">
                          {{ followUp.follow_up_time || 'No time set' }}
                        </span>
                        <span class="text-xs bg-gray-200 text-gray-800 px-2 py-1 rounded-full">
                          {{ followUp.contact_method }}
                        </span>
                      </div>
                    </div>
                    <a
                      :href="`/counselor/leads/${followUp.lead_id}`"
                      class="ml-4 text-blue-600 hover:text-blue-800"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>

              <div v-else class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500">No follow-ups scheduled for today</p>
              </div>
            </div>

            <!-- Overdue Follow-ups List -->
            <div class="bg-white rounded-xl shadow-lg p-6">
              <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                  <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Overdue Follow-ups
                </h3>
                <a href="/counselor/follow-ups?filter=overdue" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                  View All →
                </a>
              </div>

              <div v-if="overdueFollowUps && overdueFollowUps.length > 0" class="space-y-3">
                <div
                  v-for="followUp in overdueFollowUps"
                  :key="followUp.id"
                  class="p-4 bg-red-50 border border-red-100 rounded-lg hover:shadow-md transition-shadow"
                >
                  <div class="flex items-start justify-between">
                    <div class="flex-1">
                      <h4 class="font-semibold text-gray-900">{{ followUp.lead?.student_name || 'N/A' }}</h4>
                      <p class="text-sm text-gray-600 mt-1">{{ followUp.lead?.mobile_number || 'N/A' }}</p>
                      <div class="flex items-center mt-2 space-x-2">
                        <span class="text-xs bg-red-200 text-red-800 px-2 py-1 rounded-full font-medium">
                          {{ formatDate(followUp.follow_up_date) }}
                        </span>
                        <span class="text-xs bg-gray-200 text-gray-800 px-2 py-1 rounded-full">
                          {{ followUp.priority }} Priority
                        </span>
                      </div>
                    </div>
                    <a
                      :href="`/counselor/leads/${followUp.lead_id}`"
                      class="ml-4 text-blue-600 hover:text-blue-800"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>

              <div v-else class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500">No overdue follow-ups!</p>
              </div>
            </div>
          </div>

          <!-- Recent Leads -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Recent Leads
              </h3>
              <a href="/counselor/leads" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All →
              </a>
            </div>

            <div v-if="recentLeads && recentLeads.length > 0" class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="lead in recentLeads" :key="lead.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      {{ lead.student_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                      {{ lead.mobile_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="{
                          'bg-red-100 text-red-800': lead.lead_category === 'Hot',
                          'bg-orange-100 text-orange-800': lead.lead_category === 'Warm',
                          'bg-blue-100 text-blue-800': lead.lead_category === 'Cold'
                        }"
                        class="px-2 py-1 text-xs font-semibold rounded-full"
                      >
                        {{ lead.lead_category || 'N/A' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        :class="{
                          'bg-green-100 text-green-800': lead.status === 'Enrolled',
                          'bg-blue-100 text-blue-800': lead.status === 'Interested',
                          'bg-yellow-100 text-yellow-800': lead.status === 'Contacted',
                          'bg-gray-100 text-gray-800': lead.status === 'New'
                        }"
                        class="px-2 py-1 text-xs font-semibold rounded-full"
                      >
                        {{ lead.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      <a
                        :href="`/counselor/leads/${lead.id}`"
                        class="text-blue-600 hover:text-blue-900 font-medium"
                      >
                        View Details
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div v-else class="text-center py-8">
              <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <p class="text-gray-500">No leads assigned yet</p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import CounselorSidebar from '../../Components/Counselor/CounselorSidebar.vue'
import CounselorTopbar from '../../Components/Counselor/CounselorTopbar.vue'

// Props
defineProps({
  user: Object,
  stats: Object,
  followUpStats: Object,
  todayFollowUps: Array,
  overdueFollowUps: Array,
  recentLeads: Array,
})

// Mobile menu state
const isMobileMenuOpen = ref(false)

// Methods
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

const formatDate = (date) => {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric'
  })
}
</script>
