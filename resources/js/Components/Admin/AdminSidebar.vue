<template>
  <div class="admin-sidebar">
    <!-- Desktop Sidebar -->
    <div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:z-50">
      <div class="flex flex-col flex-grow bg-gradient-to-b from-navy-900 to-navy-800 shadow-xl w-64">
        <!-- Logo Section -->
        <div class="flex items-center justify-center h-20 px-6 bg-gradient-to-r from-navy-900 to-blue-800 shadow-lg">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <span class="text-xl font-bold text-white tracking-wide">NuclearEdge</span>
          </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
          <!-- Dashboard -->
          <a
            href="/admin/dashboard"
            class="sidebar-item"
            :class="{ 'active': isActiveRoute('/admin/dashboard') }"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
            </svg>
            <span>Dashboard</span>
          </a>

          <!-- Leads -->
          <a
            href="/admin/leads"
            class="sidebar-item"
            :class="{ 'active': isActiveRoute('/admin/leads') }"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Leads</span>
          </a>

          <!-- User Management Dropdown -->
          <div class="space-y-1">
            <button
              @click="toggleDropdown('userManagement')"
              class="sidebar-item w-full"
              :class="{ 'active': isUserManagementActive() }"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <span class="flex-1 text-left">User Management</span>
              <svg
                class="w-4 h-4 transition-transform duration-200"
                :class="{ 'rotate-180': dropdowns.userManagement }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <transition name="dropdown">
              <div v-show="dropdowns.userManagement" class="pl-4 space-y-1">
                <a
                  href="/admin/users"
                  class="sidebar-sub-item"
                  :class="{ 'active': isActiveRoute('/admin/users') }"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span>Admins</span>
                </a>

                <a
                  href="/admin/marketers"
                  class="sidebar-sub-item"
                  :class="{ 'active': isActiveRoute('/admin/marketers') }"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <span>Marketers</span>
                </a>

                <a
                  href="/admin/counselors"
                  class="sidebar-sub-item"
                  :class="{ 'active': isActiveRoute('/admin/counselors') }"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                  </svg>
                  <span>Counselors</span>
                </a>

                <a
                  href="/admin/faculty"
                  class="sidebar-sub-item"
                  :class="{ 'active': isActiveRoute('/admin/faculty') }"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                  <span>Faculty</span>
                </a>
              </div>
            </transition>
          </div>

          <!-- Revenue -->
          <a
            href="/admin/revenues"
            class="sidebar-item"
            :class="{ 'active': isActiveRoute('/admin/revenues') }"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Revenue</span>
          </a>

          <!-- Analytics Dropdown -->
          <div class="space-y-1">
            <button
              @click="toggleDropdown('analytics')"
              class="sidebar-item w-full"
              :class="{ 'active': isAnalyticsActive() }"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span class="flex-1 text-left">Analytics</span>
              <svg
                class="w-4 h-4 transition-transform duration-200"
                :class="{ 'rotate-180': dropdowns.analytics }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <transition name="dropdown">
              <div v-show="dropdowns.analytics" class="pl-4 space-y-1">
                <a
                  href="/admin/lead-funnel"
                  class="sidebar-sub-item"
                  :class="{ 'active': isActiveRoute('/admin/lead-funnel') }"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                  </svg>
                  <span>Lead Funnel</span>
                </a>

                <a
                  href="/admin/marketer-funnel"
                  class="sidebar-sub-item"
                  :class="{ 'active': isActiveRoute('/admin/marketer-funnel') }"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                  </svg>
                  <span>Marketer Funnel</span>
                </a>
              </div>
            </transition>
          </div>
        </nav>

        <!-- User Profile Section -->
        <div class="p-4 border-t border-navy-700">
          <div class="flex items-center space-x-3 p-3 rounded-lg bg-gradient-to-r from-navy-800 to-navy-700 hover:from-navy-700 hover:to-navy-600 transition-all duration-200 cursor-pointer group">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
              <span class="text-sm font-semibold text-white">{{ userInitials }}</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-white truncate">{{ userName }}</p>
              <p class="text-xs text-blue-200">Administrator</p>
            </div>
            <svg class="w-4 h-4 text-blue-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div v-if="isMobileMenuOpen" class="lg:hidden fixed inset-0 z-50">
      <!-- Overlay -->
      <div
        class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
        @click="closeMobileMenu"
      ></div>

      <!-- Mobile Sidebar -->
      <div class="relative flex flex-col w-full max-w-xs bg-gradient-to-b from-navy-900 to-navy-800 shadow-xl">
        <!-- Mobile Header -->
        <div class="flex items-center justify-between h-16 px-4 bg-gradient-to-r from-navy-900 to-blue-800">
          <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <span class="text-lg font-bold text-white">NuclearEdge</span>
          </div>
          <button
            @click="closeMobileMenu"
            class="p-2 rounded-md text-white hover:bg-navy-700 transition-colors"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Mobile Navigation -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scrollbar">
          <!-- Dashboard -->
          <a
            href="/admin/dashboard"
            class="sidebar-item-mobile"
            @click="closeMobileMenu"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
            </svg>
            <span>Dashboard</span>
          </a>

          <!-- Leads -->
          <a
            href="/admin/leads"
            class="sidebar-item-mobile"
            @click="closeMobileMenu"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Leads</span>
          </a>

          <!-- User Management Dropdown (Mobile) -->
          <div class="space-y-1">
            <button
              @click="toggleDropdown('userManagementMobile')"
              class="sidebar-item-mobile w-full"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <span class="flex-1 text-left">User Management</span>
              <svg
                class="w-4 h-4 transition-transform duration-200"
                :class="{ 'rotate-180': dropdowns.userManagementMobile }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <transition name="dropdown">
              <div v-show="dropdowns.userManagementMobile" class="pl-4 space-y-1">
                <a href="/admin/users" class="sidebar-sub-item-mobile" @click="closeMobileMenu">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span>Admins</span>
                </a>
                <a href="/admin/marketers" class="sidebar-sub-item-mobile" @click="closeMobileMenu">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <span>Marketers</span>
                </a>
                <a href="/admin/counselors" class="sidebar-sub-item-mobile" @click="closeMobileMenu">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                  </svg>
                  <span>Counselors</span>
                </a>
                <a href="/admin/faculty" class="sidebar-sub-item-mobile" @click="closeMobileMenu">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                  <span>Faculty</span>
                </a>
              </div>
            </transition>
          </div>

          <!-- Revenue -->
          <a href="/admin/revenues" class="sidebar-item-mobile" @click="closeMobileMenu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Revenue</span>
          </a>

          <!-- Analytics Dropdown (Mobile) -->
          <div class="space-y-1">
            <button
              @click="toggleDropdown('analyticsMobile')"
              class="sidebar-item-mobile w-full"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span class="flex-1 text-left">Analytics</span>
              <svg
                class="w-4 h-4 transition-transform duration-200"
                :class="{ 'rotate-180': dropdowns.analyticsMobile }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <transition name="dropdown">
              <div v-show="dropdowns.analyticsMobile" class="pl-4 space-y-1">
                <a href="/admin/lead-funnel" class="sidebar-sub-item-mobile" @click="closeMobileMenu">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                  </svg>
                  <span>Lead Funnel</span>
                </a>
                <a href="/admin/marketer-funnel" class="sidebar-sub-item-mobile" @click="closeMobileMenu">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                  </svg>
                  <span>Marketer Funnel</span>
                </a>
              </div>
            </transition>
          </div>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  isMobileMenuOpen: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['closeMobileMenu'])

const page = usePage()

// Dropdown states
const dropdowns = ref({
  userManagement: false,
  analytics: false,
  userManagementMobile: false,
  analyticsMobile: false,
})

const userName = computed(() => {
  return page.props.auth?.user?.name || 'Admin User'
})

const userInitials = computed(() => {
  const name = userName.value
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
})

const isActiveRoute = (routePath) => {
  return window.location.pathname === routePath || window.location.pathname.startsWith(routePath)
}

const isUserManagementActive = () => {
  const userManagementRoutes = ['/admin/users', '/admin/marketers', '/admin/counselors', '/admin/faculty']
  return userManagementRoutes.some(route => isActiveRoute(route))
}

const isAnalyticsActive = () => {
  const analyticsRoutes = ['/admin/lead-funnel', '/admin/marketer-funnel']
  return analyticsRoutes.some(route => isActiveRoute(route))
}

const toggleDropdown = (dropdownName) => {
  dropdowns.value[dropdownName] = !dropdowns.value[dropdownName]
}

const closeMobileMenu = () => {
  emit('closeMobileMenu')
}

// Auto-open dropdowns if current route is within them
onMounted(() => {
  if (isUserManagementActive()) {
    dropdowns.value.userManagement = true
    dropdowns.value.userManagementMobile = true
  }
  if (isAnalyticsActive()) {
    dropdowns.value.analytics = true
    dropdowns.value.analyticsMobile = true
  }
})
</script>

<style scoped>
/* Navy Color Palette */
.bg-navy-900 { background-color: #0f172a; }
.bg-navy-800 { background-color: #1e293b; }
.bg-navy-700 { background-color: #334155; }
.border-navy-700 { border-color: #334155; }
.from-navy-900 { --tw-gradient-from: #0f172a; }
.from-navy-800 { --tw-gradient-from: #1e293b; }
.from-navy-700 { --tw-gradient-from: #334155; }
.to-navy-800 { --tw-gradient-to: #1e293b; }
.to-navy-700 { --tw-gradient-to: #334155; }
.to-navy-600 { --tw-gradient-to: #475569; }
.hover\:bg-navy-700:hover { background-color: #334155; }

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: #1e293b;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #475569;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #64748b;
}

/* Main Sidebar Items */
.sidebar-item {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #dbeafe;
  border-radius: 0.5rem;
  transition: all 0.2s;
  text-decoration: none;
}

.sidebar-item:hover {
  background-color: #334155;
  color: white;
  transform: translateX(4px);
}

.sidebar-item.active {
  background: linear-gradient(to right, #2563eb, #3b82f6);
  color: white;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}

.sidebar-item svg {
  margin-right: 0.75rem;
  flex-shrink: 0;
}

/* Sub Items */
.sidebar-sub-item {
  display: flex;
  align-items: center;
  padding: 0.625rem 1rem;
  font-size: 0.8125rem;
  font-weight: 500;
  color: #bfdbfe;
  border-radius: 0.5rem;
  transition: all 0.2s;
  text-decoration: none;
  margin-left: 0.5rem;
}

.sidebar-sub-item:hover {
  background-color: rgba(51, 65, 85, 0.6);
  color: white;
  transform: translateX(4px);
}

.sidebar-sub-item.active {
  background: linear-gradient(to right, rgba(37, 99, 235, 0.8), rgba(59, 130, 246, 0.8));
  color: white;
}

.sidebar-sub-item svg {
  margin-right: 0.625rem;
  flex-shrink: 0;
}

/* Mobile Styles */
.sidebar-item-mobile {
  display: flex;
  align-items: center;
  padding: 0.75rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #dbeafe;
  border-radius: 0.5rem;
  transition: all 0.2s;
  text-decoration: none;
}

.sidebar-item-mobile:hover {
  background-color: #334155;
  color: white;
}

.sidebar-item-mobile svg {
  margin-right: 0.75rem;
  flex-shrink: 0;
}

.sidebar-sub-item-mobile {
  display: flex;
  align-items: center;
  padding: 0.625rem 0.75rem;
  font-size: 0.8125rem;
  font-weight: 500;
  color: #bfdbfe;
  border-radius: 0.5rem;
  transition: all 0.2s;
  text-decoration: none;
  margin-left: 0.5rem;
}

.sidebar-sub-item-mobile:hover {
  background-color: rgba(51, 65, 85, 0.6);
  color: white;
}

.sidebar-sub-item-mobile svg {
  margin-right: 0.625rem;
  flex-shrink: 0;
}

/* Dropdown Animation */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.3s ease;
  overflow: hidden;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  max-height: 0;
  transform: translateY(-10px);
}

.dropdown-enter-to,
.dropdown-leave-from {
  opacity: 1;
  max-height: 500px;
  transform: translateY(0);
}

/* Rotation Animation */
.rotate-180 {
  transform: rotate(180deg);
}
</style>
