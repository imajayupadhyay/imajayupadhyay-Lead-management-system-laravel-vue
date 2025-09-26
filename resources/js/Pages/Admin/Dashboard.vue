<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-navy-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo & Title -->
          <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-gradient-to-tr from-navy-600 to-blue-600 rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
              </svg>
            </div>
            <div>
              <h1 class="text-xl font-bold text-gray-900">Lead Management System</h1>
              <p class="text-sm text-gray-500">Admin Dashboard</p>
            </div>
          </div>

          <!-- User Menu -->
          <div class="flex items-center space-x-4">
            <div class="text-right">
              <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
              <p class="text-xs text-gray-500 capitalize">{{ user.role }}</p>
            </div>
            <button
              @click="logout"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-navy-600 to-blue-600 hover:from-navy-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2 transition-all duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Message -->
      <div class="bg-gradient-to-r from-navy-600 to-blue-600 rounded-2xl p-8 text-white relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-blue-400/20 rounded-full blur-xl"></div>
        
        <div class="relative text-center">
          <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
          </div>
          <h2 class="text-3xl font-bold mb-4">Welcome, {{ user.name }}!</h2>
          <p class="text-xl text-blue-100">
            Admin Dashboard - Lead Management System
          </p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

// Props
defineProps({
  user: Object,
})

// Methods
const logout = () => {
  router.post(route('logout'))
}
</script>

<style scoped>
.text-navy-900 { color: #0f172a; }
.text-navy-800 { color: #1e293b; }
.text-navy-700 { color: #334155; }
.text-navy-600 { color: #475569; }
.text-navy-500 { color: #64748b; }

.bg-navy-900 { background-color: #0f172a; }
.bg-navy-800 { background-color: #1e293b; }
.bg-navy-700 { background-color: #334155; }
.bg-navy-600 { background-color: #475569; }
.bg-navy-500 { background-color: #64748b; }

.from-navy-900 { --tw-gradient-from: #0f172a; }
.from-navy-800 { --tw-gradient-from: #1e293b; }
.from-navy-700 { --tw-gradient-from: #334155; }
.from-navy-600 { --tw-gradient-from: #475569; }

.to-navy-900 { --tw-gradient-to: #0f172a; }
.to-navy-800 { --tw-gradient-to: #1e293b; }
.to-navy-700 { --tw-gradient-to: #334155; }
.to-navy-600 { --tw-gradient-to: #475569; }

.border-navy-500 { border-color: #64748b; }
.ring-navy-500 { --tw-ring-color: #64748b; }

.hover\:from-navy-700:hover { --tw-gradient-from: #334155; }
.hover\:to-blue-700:hover { --tw-gradient-to: #1d4ed8; }

.focus\:ring-navy-500:focus { --tw-ring-color: #64748b; }
</style>