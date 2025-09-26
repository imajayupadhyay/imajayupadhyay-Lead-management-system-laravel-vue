<template>
  <div class="admin-sidebar">
    <!-- Desktop Sidebar -->
    <div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:z-50">
      <div class="flex flex-col flex-grow bg-gradient-to-b from-navy-900 to-navy-800 shadow-xl">
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
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
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

          <!-- Leads Management -->
          <div class="sidebar-section">
            <div class="sidebar-section-title">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span>Leads</span>
            </div>
            <div class="sidebar-subsection">
              <a href="/admin/leads" class="sidebar-subitem">
                All Leads
              </a>
              <a href="/admin/leads/new" class="sidebar-subitem">
                New Leads
              </a>
              <a href="/admin/leads/in-progress" class="sidebar-subitem">
                In Progress
              </a>
              <a href="/admin/leads/converted" class="sidebar-subitem">
                Converted
              </a>
            </div>
          </div>

          <!-- Counselors Management -->
          <a 
            href="/admin/counselors" 
            class="sidebar-item"
            :class="{ 'active': isActiveRoute('/admin/counselors') }"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
            <span>Counselors</span>
          </a>

          <!-- Reports & Analytics -->
          <div class="sidebar-section">
            <div class="sidebar-section-title">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span>Reports</span>
            </div>
            <div class="sidebar-subsection">
              <a href="/admin/reports/overview" class="sidebar-subitem">
                Overview
              </a>
              <a href="/admin/reports/performance" class="sidebar-subitem">
                Performance
              </a>
              <a href="/admin/reports/conversion" class="sidebar-subitem">
                Conversion Rate
              </a>
            </div>
          </div>

          <!-- Settings -->
          <a 
            href="/admin/settings" 
            class="sidebar-item"
            :class="{ 'active': isActiveRoute('/admin/settings') }"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Settings</span>
          </a>
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
            <span class="text-lg font-bold text-white">LeadPro</span>
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

        <!-- Mobile Navigation - Same as desktop but condensed -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
          <!-- Same navigation items as desktop -->
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
          <!-- Add other menu items in mobile format -->
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

// Props
const props = defineProps({
  isMobileMenuOpen: {
    type: Boolean,
    default: false
  }
})

// Emits
const emit = defineEmits(['closeMobileMenu'])

// Composables
const page = usePage()

// Computed
const userName = computed(() => {
  return page.props.auth?.user?.name || 'Admin User'
})

const userInitials = computed(() => {
  const name = userName.value
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
})

const isActiveRoute = (routePath) => {
  return window.location.pathname === routePath
}

// Methods
const closeMobileMenu = () => {
  emit('closeMobileMenu')
}
</script>


<style scoped>
/* Custom Navy Colors */
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

/* Sidebar Items */
.sidebar-item {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #dbeafe;
  border-radius: 0.5rem;
  transition: all 0.2s;
}

.sidebar-item:hover {
  background-color: #334155;
  color: white;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.sidebar-item.active {
  background: linear-gradient(to right, #2563eb, #3b82f6);
  color: white;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.sidebar-item svg {
  margin-right: 0.75rem;
  flex-shrink: 0;
  transition: colors 0.2s;
}

/* Section Titles */
.sidebar-section-title {
  display: flex;
  align-items: center;
  padding: 0.5rem 1rem;
  font-size: 0.75rem;
  font-weight: 600;
  color: #93c5fd;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.sidebar-section-title svg {
  margin-right: 0.5rem;
}

/* Subsections */
.sidebar-subsection {
  margin-left: 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.sidebar-subitem {
  display: block;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  color: #bfdbfe;
  border-radius: 0.5rem;
  transition: all 0.2s;
  text-decoration: none;
}

.sidebar-subitem:hover {
  background-color: #334155;
  color: white;
  padding-left: 1.5rem;
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

.sidebar-item-mobile svg {
  margin-right: 0.75rem;
  flex-shrink: 0;
}
</style>