<template>
  <div class="users-page">
    <Head title="User Management" />

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

          <!-- Page Header -->
          <div class="mb-8">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                <p class="mt-2 text-gray-600">Manage your team members and their permissions</p>
              </div>
              <button
                @click="openCreateModal"
                class="btn btn-primary"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New User
              </button>
            </div>
          </div>

          <!-- Statistics Dashboard -->
          <div class="stats-container animate-fade-in-up">
            <!-- Total Users -->
            <div class="stats-card total-users">
              <div class="stats-content">
                <div class="stats-info">
                  <h3>Total Users</h3>
                  <div class="stats-number">{{ stats.total_users }}</div>
                  <div class="stats-description">All registered users</div>
                </div>
                <div class="stats-icon">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Total Admins -->
            <div class="stats-card total-admins">
              <div class="stats-content">
                <div class="stats-info">
                  <h3>Admins</h3>
                  <div class="stats-number">{{ stats.total_admins }}</div>
                  <div class="stats-description">System administrators</div>
                </div>
                <div class="stats-icon">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Total Counselors -->
            <div class="stats-card total-counselors">
              <div class="stats-content">
                <div class="stats-info">
                  <h3>Counselors</h3>
                  <div class="stats-number">{{ stats.total_counselors }}</div>
                  <div class="stats-description">Lead counselors</div>
                </div>
                <div class="stats-icon">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Active Users -->
            <!-- <div class="stats-card active-users">
              <div class="stats-content">
                <div class="stats-info">
                  <h3>Active</h3>
                  <div class="stats-number">{{ stats.active_users }}</div>
                  <div class="stats-description">Currently active</div>
                </div>
                <div class="stats-icon">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
            </div> -->

            <!-- Inactive Users -->
            <!-- <div class="stats-card inactive-users">
              <div class="stats-content">
                <div class="stats-info">
                  <h3>Inactive</h3>
                  <div class="stats-number">{{ stats.inactive_users }}</div>
                  <div class="stats-description">Inactive accounts</div>
                </div>
                <div class="stats-icon">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
            </div> -->
          </div>

          <!-- Advanced Filters Panel -->
          <div class="filter-panel">
            <div class="filter-header">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                  </svg>
                  Filter Users
                </h3>
                <button
                  @click="showFilters = !showFilters"
                  class="filter-toggle"
                >
                  <svg :class="{'rotate-180': showFilters}" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
              </div>
            </div>

            <div v-show="showFilters" class="p-6 transition-all duration-300">
              <div class="flex items-center justify-between">
                <!-- Search Input -->
                <div class="col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                  <div class="search-input-container">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input
                      type="text"
                      v-model="searchQuery"
                      @input="applyFilters"
                      class="form-input"
                      placeholder="Search by name, email, or phone..."
                    />
                  </div>
                </div>

                <!-- Role Filter -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                  <select
                    v-model="roleFilter"
                    @change="applyFilters"
                    class="form-input"
                  >
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="counselor">Counselor</option>
                  </select>
                </div>

                <!-- Status Filter -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                  <select
                    v-model="statusFilter"
                    @change="applyFilters"
                    class="form-input"
                  >
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                  Showing {{ users.data.length }} of {{ users.total }} users
                </div>
                <button
                  @click="clearFilters"
                  class="btn btn-outline"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                  </svg>
                  Clear Filters
                </button>
              </div>
            </div>
          </div>

          <!-- Users Grid -->
          <div v-if="users.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            <div
              v-for="user in users.data"
              :key="user.id"
              class="user-card animate-slide-in-right"
              @click="openShowModal(user)"
              style="cursor: pointer;"
            >
              <!-- User Card Header -->
              <div class="user-card-header">
                <div class="absolute top-4 right-4 z-10">
                  <div :class="[
                    'w-3 h-3 rounded-full border-2 border-white',
                    user.is_active ? 'bg-green-400' : 'bg-red-400'
                  ]"></div>
                </div>
              </div>

              <!-- User Info -->
              <div class="p-6 -mt-8 relative">
                <!-- Avatar -->
                <div class="relative mb-4">
                  <div class="user-avatar mx-auto">
                    <span class="text-xl font-bold">
                      {{ user.name.charAt(0).toUpperCase() }}
                    </span>
                    <div :class="[
                      'status-indicator',
                      user.is_active ? 'active' : 'inactive'
                    ]"></div>
                  </div>
                </div>

                <!-- User Details -->
                <div class="text-center mb-4">
                  <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ user.name }}</h3>
                  <p class="text-sm text-gray-600 mb-2">{{ user.email }}</p>
                  <p v-if="user.phone" class="text-sm text-gray-600 mb-3">{{ user.phone }}</p>

                  <!-- Badges -->
                  <div class="flex items-center justify-center space-x-2 mb-4">
                    <span :class="[
                      'badge',
                      user.role === 'admin' ? 'badge-admin' : 'badge-counselor'
                    ]">
                      {{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}
                    </span>
                    <span :class="[
                      'badge',
                      user.is_active ? 'badge-active' : 'badge-inactive'
                    ]">
                      {{ user.is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-center space-x-2">
                  <button
                    @click.stop="openEditModal(user)"
                    class="btn btn-primary flex-1"
                    style="padding: 0.5rem 0.75rem; font-size: 0.8125rem;"
                  >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </button>

                  <button
                    @click.stop="toggleStatus(user)"
                    :class="[
                      'btn flex-1',
                      user.is_active ? 'btn-warning' : 'btn-success'
                    ]"
                    style="padding: 0.5rem 0.75rem; font-size: 0.8125rem;"
                  >
                    <svg v-if="user.is_active" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg v-else class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ user.is_active ? 'Disable' : 'Enable' }}
                  </button>

                  <button
                    @click.stop="deleteUser(user)"
                    :disabled="user.id === $page.props.auth.user.id"
                    class="btn btn-danger"
                    style="padding: 0.5rem; font-size: 0.8125rem;"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-else class="empty-state">
            <div class="empty-state-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">No users found</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
              {{ searchQuery || roleFilter || statusFilter ? 'No users match your current filters. Try adjusting your search criteria.' : 'Get started by creating your first user account.' }}
            </p>
            <button
              v-if="!searchQuery && !roleFilter && !statusFilter"
              @click="openCreateModal"
              class="btn btn-primary"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Add New User
            </button>
          </div>

          <!-- Pagination -->
          <div v-if="users.links && users.links.length > 3" class="mt-8">
            <nav class="flex items-center justify-between bg-white px-6 py-4 rounded-2xl shadow-lg border border-gray-100">
              <div class="flex w-0 flex-1">
                <Link
                  v-if="users.prev_page_url"
                  :href="users.prev_page_url"
                  class="btn btn-outline"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                  Previous
                </Link>
              </div>
              <div class="text-sm text-gray-600 font-medium">
                Showing {{ users.from }} to {{ users.to }} of {{ users.total }} users
              </div>
              <div class="flex justify-end w-0 flex-1">
                <Link
                  v-if="users.next_page_url"
                  :href="users.next_page_url"
                  class="btn btn-outline"
                >
                  Next
                  <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </Link>
              </div>
            </nav>
          </div>
        </div>
      </main>
    </div>

    <!-- Create User Modal -->
    <CreateUserModal
      :show="showCreateModal"
      @close="closeCreateModal"
      @userCreated="handleUserCreated"
    />

    <!-- Edit User Modal -->
    <EditUserModal
      :show="showEditModal"
      :user="selectedUser"
      @close="closeEditModal"
      @userUpdated="handleUserUpdated"
    />

    <!-- Show User Modal -->
    <ShowUserModal
      :show="showShowModal"
      :user="selectedUser"
      @close="closeShowModal"
      @editUser="handleEditFromShow"
      @deleteUser="handleDeleteFromShow"
    />

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>

        <div class="relative transform overflow-hidden rounded-2xl bg-white px-6 pb-6 pt-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-12 sm:w-12">
              <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-xl font-semibold leading-6 text-gray-900">Delete User Account</h3>
              <div class="mt-3">
                <p class="text-sm text-gray-600">
                  Are you sure you want to permanently delete <strong class="text-gray-900">{{ userToDelete?.name }}</strong>'s account? This action cannot be undone and will remove all associated data.
                </p>
              </div>
            </div>
          </div>
          <div class="mt-6 sm:flex sm:flex-row-reverse">
            <button
              @click="confirmDelete"
              class="btn btn-danger sm:ml-3 sm:w-auto w-full"
            >
              Yes, Delete User
            </button>
            <button
              @click="showDeleteModal = false"
              class="btn btn-outline mt-3 sm:mt-0 sm:w-auto w-full"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminSidebar from '../../../Components/Admin/AdminSidebar.vue'
import AdminTopbar from '../../../Components/Admin/AdminTopbar.vue'
import CreateUserModal from '../../../Components/Admin/Modals/CreateUserModal.vue'
import EditUserModal from '../../../Components/Admin/Modals/EditUserModal.vue'
import ShowUserModal from '../../../Components/Admin/Modals/ShowUserModal.vue'

const props = defineProps({
  users: Object,
  stats: Object,
  filters: Object,
})

// State
const searchQuery = ref(props.filters.search || '')
const roleFilter = ref(props.filters.role || '')
const statusFilter = ref(props.filters.status || '')
const showDeleteModal = ref(false)
const userToDelete = ref(null)
const isMobileMenuOpen = ref(false)
const showFilters = ref(true)

// Modal states
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showShowModal = ref(false)
const selectedUser = ref(null)

// Methods
const applyFilters = () => {
  const params = {}

  if (searchQuery.value) params.search = searchQuery.value
  if (roleFilter.value) params.role = roleFilter.value
  if (statusFilter.value) params.status = statusFilter.value

  router.get(route('admin.users.index'), params, {
    preserveState: true,
    replace: true,
  })
}

const clearFilters = () => {
  searchQuery.value = ''
  roleFilter.value = ''
  statusFilter.value = ''
  router.get(route('admin.users.index'))
}

const toggleStatus = (user) => {
  router.patch(route('admin.users.toggle-status', user.id), {}, {
    preserveScroll: true,
  })
}

const deleteUser = (user) => {
  userToDelete.value = user
  showDeleteModal.value = true
}

const confirmDelete = () => {
  if (userToDelete.value) {
    router.delete(route('admin.users.destroy', userToDelete.value.id), {
      preserveScroll: true,
      onSuccess: () => {
        showDeleteModal.value = false
        userToDelete.value = null
      },
    })
  }
}

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

// Modal methods
const openCreateModal = () => {
  showCreateModal.value = true
}

const closeCreateModal = () => {
  showCreateModal.value = false
}

const openEditModal = (user) => {
  selectedUser.value = user
  showEditModal.value = true
}

const closeEditModal = () => {
  showEditModal.value = false
  selectedUser.value = null
}

const openShowModal = (user) => {
  selectedUser.value = user
  showShowModal.value = true
}

const closeShowModal = () => {
  showShowModal.value = false
  selectedUser.value = null
}

const handleUserCreated = () => {
  closeCreateModal()
  // Refresh the page or update the list
  router.reload()
}

const handleUserUpdated = () => {
  closeEditModal()
  // Refresh the page or update the list
  router.reload()
}

const handleEditFromShow = (user) => {
  closeShowModal()
  openEditModal(user)
}

const handleDeleteFromShow = (user) => {
  closeShowModal()
  deleteUser(user)
}
</script>

<style scoped>
@import '/resources/css/users.css';
</style>