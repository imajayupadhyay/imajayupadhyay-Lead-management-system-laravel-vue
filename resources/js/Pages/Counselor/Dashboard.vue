<template>
  <div class="min-h-screen bg-gray-50">
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
          <!-- Welcome Message -->
          <div class="bg-gradient-to-r from-navy-600 to-blue-600 rounded-2xl p-8 text-white relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-blue-400/20 rounded-full blur-xl"></div>

            <div class="relative text-center">
              <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <h2 class="text-3xl font-bold mb-4">Welcome, {{ user.name }}!</h2>
              <p class="text-xl text-blue-100">
                Counselor Dashboard - Lead Management System
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
import CounselorSidebar from '../../Components/Counselor/CounselorSidebar.vue'
import CounselorTopbar from '../../Components/Counselor/CounselorTopbar.vue'

// Props
defineProps({
  user: Object,
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