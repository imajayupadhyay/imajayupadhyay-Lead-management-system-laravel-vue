<template>
  <div class="admin-topbar">
    <!-- Main Topbar -->
    <div class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-40">
      <div class="flex items-center justify-between h-16 px-4 lg:px-6">
        
        <!-- Left Section -->
        <div class="flex items-center space-x-4">
          <!-- Mobile Menu Button -->
          <button
            @click="toggleMobileMenu"
            class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          <!-- Page Title -->
          <div class="hidden sm:block">
            <h1 class="text-xl font-semibold text-gray-900">{{ currentPageTitle }}</h1>
            <p class="text-sm text-gray-500">{{ currentPageSubtitle }}</p>
          </div>

          <!-- Mobile Page Title -->
          <h1 class="sm:hidden text-lg font-semibold text-gray-900">
            {{ currentPageTitle }}
          </h1>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4">
          <!-- Search Bar -->
          <div class="hidden md:flex relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search leads, counselors..."
              class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
              @keyup.enter="performSearch"
            />
            <div v-if="searchQuery" class="absolute inset-y-0 right-0 pr-3 flex items-center">
              <button 
                @click="clearSearch"
                class="text-gray-400 hover:text-gray-600 transition-colors"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="hidden lg:flex items-center space-x-2">
            <!-- Add New Lead Button - Disabled for now -->
            <button
              disabled
              class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded-lg shadow-md cursor-not-allowed opacity-60"
              title="Coming Soon"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add Lead
            </button>
          </div>

          <!-- Notifications -->
          <div class="relative">
            <button
              @click="toggleNotifications"
              class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 relative"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 17h5l-5 5v-5zM12 3a5 5 0 015 5v4a2 2 0 002 2h1a1 1 0 110 2H4a1 1 0 110-2h1a2 2 0 002-2V8a5 5 0 015-5z" />
              </svg>
              <!-- Notification Badge -->
              <span v-if="notificationCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                {{ notificationCount > 9 ? '9+' : notificationCount }}
              </span>
            </button>

            <!-- Notifications Dropdown -->
            <div
              v-if="showNotifications"
              v-click-outside="closeNotifications"
              class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
            >
              <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                  <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                  <button
                    v-if="notificationCount > 0"
                    @click="markAllAsRead"
                    class="text-sm text-blue-600 hover:text-blue-800 transition-colors"
                  >
                    Mark all read
                  </button>
                </div>
              </div>
              <div class="max-h-64 overflow-y-auto">
                <div v-if="notifications.length === 0" class="p-4 text-center text-gray-500">
                  No new notifications
                </div>
                <div
                  v-for="notification in notifications"
                  :key="notification.id"
                  class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors cursor-pointer"
                  @click="handleNotificationClick(notification)"
                >
                  <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                      <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 truncate">
                        {{ notification.title }}
                      </p>
                      <p class="text-sm text-gray-500 truncate">
                        {{ notification.message }}
                      </p>
                      <p class="text-xs text-gray-400 mt-1">
                        {{ formatTime(notification.created_at) }}
                      </p>
                    </div>
                    <div v-if="!notification.read" class="w-2 h-2 bg-blue-500 rounded-full"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- User Profile Dropdown -->
          <div class="relative">
            <button
              @click="toggleProfileMenu"
              class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                <span class="text-sm font-semibold text-white">{{ userInitials }}</span>
              </div>
              <div class="hidden sm:block text-left">
                <p class="text-sm font-medium text-gray-900">{{ userName }}</p>
                <p class="text-xs text-gray-500">Administrator</p>
              </div>
              <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Profile Dropdown Menu -->
            <div
              v-if="showProfileMenu"
              v-click-outside="closeProfileMenu"
              class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50"
            >
              <div class="py-2">
                <button
                  disabled
                  class="block w-full text-left px-4 py-2 text-sm text-gray-400 cursor-not-allowed"
                  title="Coming Soon"
                >
                  <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profile (Coming Soon)</span>
                  </div>
                </button>
                <button
                  disabled
                  class="block w-full text-left px-4 py-2 text-sm text-gray-400 cursor-not-allowed"
                  title="Coming Soon"
                >
                  <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Settings (Coming Soon)</span>
                  </div>
                </button>
                <hr class="my-2 border-gray-200">
                <button
                  @click="logout"
                  class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                >
                  <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                  </div>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

// Emits
const emit = defineEmits(['toggleMobileMenu'])

// Composables
const page = usePage()

// Reactive data
const searchQuery = ref('')
const showNotifications = ref(false)
const showProfileMenu = ref(false)
const notifications = ref([
  {
    id: 1,
    title: 'New Lead Assigned',
    message: 'John Doe has been assigned to you',
    created_at: new Date(),
    read: false
  },
  {
    id: 2,
    title: 'Follow-up Reminder',
    message: 'Follow up with Sarah Johnson',
    created_at: new Date(Date.now() - 3600000),
    read: false
  }
])

// Computed properties
const userName = computed(() => {
  return page.props.auth?.user?.name || 'Admin User'
})

const userInitials = computed(() => {
  const name = userName.value
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
})

const currentPageTitle = computed(() => {
  const url = window.location.pathname
  if (url.includes('/admin/dashboard')) return 'Dashboard'
  if (url.includes('/admin/leads')) return 'Leads'
  if (url.includes('/admin/counselors')) return 'Counselors'
  if (url.includes('/admin/reports')) return 'Reports'
  if (url.includes('/admin/settings')) return 'Settings'
  return 'Dashboard'
})

const currentPageSubtitle = computed(() => {
  const url = window.location.pathname
  if (url.includes('/admin/dashboard')) return 'Overview of your lead management system'
  if (url.includes('/admin/leads')) return 'Manage and track all leads'
  if (url.includes('/admin/counselors')) return 'Manage counselor accounts'
  if (url.includes('/admin/reports')) return 'View analytics and reports'
  if (url.includes('/admin/settings')) return 'System configuration'
  return 'Welcome to your admin panel'
})

const notificationCount = computed(() => {
  return notifications.value.filter(n => !n.read).length
})

// Methods
const toggleMobileMenu = () => {
  emit('toggleMobileMenu')
}

const performSearch = () => {
  // Disabled for now - search functionality not implemented yet
  console.log('Search functionality coming soon:', searchQuery.value)
}

const clearSearch = () => {
  searchQuery.value = ''
}

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value
  showProfileMenu.value = false
}

const closeNotifications = () => {
  showNotifications.value = false
}

const toggleProfileMenu = () => {
  showProfileMenu.value = !showProfileMenu.value
  showNotifications.value = false
}

const closeProfileMenu = () => {
  showProfileMenu.value = false
}

const markAllAsRead = () => {
  notifications.value.forEach(notification => {
    notification.read = true
  })
}

const handleNotificationClick = (notification) => {
  notification.read = true
  closeNotifications()
}

const formatTime = (date) => {
  const now = new Date()
  const diff = now - new Date(date)
  const minutes = Math.floor(diff / 60000)
  const hours = Math.floor(diff / 3600000)
  const days = Math.floor(diff / 86400000)

  if (minutes < 1) return 'Just now'
  if (minutes < 60) return `${minutes}m ago`
  if (hours < 24) return `${hours}h ago`
  return `${days}d ago`
}

const logout = () => {
  router.post('/logout')
}

// Custom directive for click outside
const vClickOutside = {
  mounted(el, binding) {
    el.clickOutsideEvent = function(event) {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value()
      }
    }
    document.addEventListener('click', el.clickOutsideEvent)
  },
  unmounted(el) {
    document.removeEventListener('click', el.clickOutsideEvent)
  }
}
</script>

<style scoped>
/* Additional custom styles if needed */
.admin-topbar {
  /* Custom topbar styles */
}
</style>