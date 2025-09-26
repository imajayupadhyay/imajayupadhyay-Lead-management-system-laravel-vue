<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Admin Sidebar -->
    <AdminSidebar 
      :isMobileMenuOpen="isMobileMenuOpen" 
      @closeMobileMenu="closeMobileMenu" 
    />
    
    <!-- Main Content Area -->
    <div class="lg:pl-64">
      <!-- Admin Topbar -->
      <AdminTopbar @toggleMobileMenu="toggleMobileMenu" />
      
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
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
              </div>
              <h2 class="text-3xl font-bold mb-4">Welcome, {{ user.name }}!</h2>
              <p class="text-xl text-blue-100">
                Admin Dashboard - Lead Management System
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
import { router } from '@inertiajs/vue3'
import AdminSidebar from '../../Components/Admin/AdminSidebar.vue'
import AdminTopbar from '../../Components/Admin/AdminTopbar.vue'

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
/* Custom Navy Colors */
.bg-navy-600 { background-color: #475569; }
.from-navy-600 { --tw-gradient-from: #475569; }
</style>