<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <Head title="Manage Counselors" />

    <!-- Mobile Sidebar -->
    <div v-show="isMobileMenuOpen" class="relative z-50 lg:hidden">
      <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="closeMobileMenu"></div>
      <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl">
        <AdminSidebar :isMobileMenuOpen="true" @closeMobileMenu="closeMobileMenu" />
      </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
      <AdminSidebar />
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64">
      <!-- Top Bar -->
      <AdminTopbar @toggleMobileMenu="toggleMobileMenu" />

      <!-- Main Content Area -->
      <main class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
          <!-- Header Section -->
          <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Manage Counselors</h1>
                <p class="mt-2 text-lg text-gray-600">Add, edit, and manage counseling team members</p>
              </div>
              <div class="mt-4 sm:ml-4 sm:mt-0">
                <button
                  @click="openCreateModal"
                  class="btn btn-primary"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Add New Counselor
                </button>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Total Counselors</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.total_counselors }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Active Counselors</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.active_counselors }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Inactive Counselors</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ stats.inactive_counselors }}</dd>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Filters and Search -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <!-- Search -->
              <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Counselors</label>
                <div class="relative">
                  <input
                    id="search"
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search by name, email, or phone..."
                    class="form-input pl-10"
                    @input="debounceSearch"
                  >
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Status Filter -->
              <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  id="status"
                  v-model="statusFilter"
                  class="form-input"
                  @change="applyFilters"
                >
                  <option value="">All Status</option>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>

            <!-- Clear Filters -->
            <div v-if="searchQuery || statusFilter" class="mt-4 pt-4 border-t border-gray-200">
              <button
                @click="clearFilters"
                class="btn btn-outline btn-sm"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Clear Filters
              </button>
            </div>
          </div>

          <!-- Counselors Table -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div v-if="counselors.data.length > 0">
              <!-- Bulk Actions -->
              <div v-if="selectedCounselors.length > 0" class="bg-blue-50 border-b border-blue-200 px-6 py-3">
                <div class="flex items-center justify-between">
                  <span class="text-sm font-medium text-blue-800">
                    {{ selectedCounselors.length }} counselor(s) selected
                  </span>
                  <div class="flex space-x-2">
                    <button
                      @click="bulkAction('activate')"
                      class="btn btn-sm btn-outline text-green-600 border-green-600 hover:bg-green-50"
                    >
                      Activate
                    </button>
                    <button
                      @click="bulkAction('deactivate')"
                      class="btn btn-sm btn-outline text-yellow-600 border-yellow-600 hover:bg-yellow-50"
                    >
                      Deactivate
                    </button>
                    <button
                      @click="bulkAction('delete')"
                      class="btn btn-sm btn-outline text-red-600 border-red-600 hover:bg-red-50"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>

              <!-- Table -->
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-4 text-left">
                        <input
                          type="checkbox"
                          :checked="selectedCounselors.length === counselors.data.length"
                          @change="toggleSelectAll"
                          class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Counselor
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Contact Info
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Status
                      </th>
                      <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Added
                      </th>
                      <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wide">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                      v-for="counselor in counselors.data"
                      :key="counselor.id"
                      class="hover:bg-gray-50 transition-colors duration-200"
                    >
                      <td class="px-6 py-4">
                        <input
                          type="checkbox"
                          :value="counselor.id"
                          v-model="selectedCounselors"
                          class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                      </td>
                      <td class="px-6 py-4">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-12 w-12">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                              {{ getInitials(counselor.name) }}
                            </div>
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-semibold text-gray-900">{{ counselor.name }}</div>
                            <div class="text-sm text-gray-500">ID: #{{ counselor.id }}</div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ counselor.email }}</div>
                        <div class="text-sm text-gray-500">{{ counselor.phone || 'No phone' }}</div>
                      </td>
                      <td class="px-6 py-4">
                        <span
                          :class="[
                            'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                            counselor.is_active
                              ? 'bg-green-100 text-green-800'
                              : 'bg-red-100 text-red-800'
                          ]"
                        >
                          <span
                            :class="[
                              'w-2 h-2 rounded-full mr-2',
                              counselor.is_active ? 'bg-green-400' : 'bg-red-400'
                            ]"
                          ></span>
                          {{ counselor.is_active ? 'Active' : 'Inactive' }}
                        </span>
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-500">
                        {{ formatDate(counselor.created_at) }}
                      </td>
                      <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                          <button
                            @click="showCounselor(counselor)"
                            class="btn-icon btn-icon-blue"
                            title="View Details"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                          </button>
                          <button
                            @click="editCounselor(counselor)"
                            class="btn-icon btn-icon-green"
                            title="Edit Counselor"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                          </button>
                          <button
                            @click="confirmDelete(counselor)"
                            class="btn-icon btn-icon-red"
                            title="Delete Counselor"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-16">
              <div class="mx-auto h-24 w-24 text-gray-300">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-full w-full">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
              </div>
              <h3 class="mt-4 text-lg font-medium text-gray-900">No counselors found</h3>
              <p class="mt-2 text-gray-500 max-w-sm mx-auto">
                {{ searchQuery || statusFilter ? 'No counselors match your current filters. Try adjusting your search criteria.' : 'Get started by creating your first counselor account.' }}
              </p>
              <button
                v-if="!searchQuery && !statusFilter"
                @click="openCreateModal"
                class="btn btn-primary mt-4"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Counselor
              </button>
            </div>

            <!-- Pagination -->
            <div v-if="counselors.links && counselors.links.length > 3" class="mt-8">
              <nav class="flex items-center justify-between bg-white px-6 py-4 rounded-2xl shadow-lg border border-gray-100">
                <div class="flex w-0 flex-1">
                  <Link
                    v-if="counselors.prev_page_url"
                    :href="counselors.prev_page_url"
                    class="btn btn-outline"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                  </Link>
                </div>
                <div class="text-sm text-gray-600 font-medium">
                  Showing {{ counselors.from }} to {{ counselors.to }} of {{ counselors.total }} counselors
                </div>
                <div class="flex justify-end w-0 flex-1">
                  <Link
                    v-if="counselors.next_page_url"
                    :href="counselors.next_page_url"
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
        </div>
      </main>
    </div>

    <!-- Create Counselor Modal -->
    <CreateCounselorModal
      :show="showCreateModal"
      @close="closeCreateModal"
      @counselorCreated="handleCounselorCreated"
    />

    <!-- Edit Counselor Modal -->
    <EditCounselorModal
      :show="showEditModal"
      :counselor="selectedCounselor"
      @close="closeEditModal"
      @counselorUpdated="handleCounselorUpdated"
    />

    <!-- Show Counselor Modal -->
    <ShowCounselorModal
      :show="showShowModal"
      :counselor="selectedCounselor"
      @close="closeShowModal"
      @editCounselor="handleEditFromShow"
      @deleteCounselor="handleDeleteFromShow"
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
              <h3 class="text-xl font-semibold leading-6 text-gray-900">Delete Counselor</h3>
              <div class="mt-3">
                <p class="text-sm text-gray-600">
                  Are you sure you want to permanently delete <strong class="text-gray-900">{{ counselorToDelete?.name }}</strong>? This action cannot be undone.
                </p>
              </div>
            </div>
          </div>
          <div class="mt-6 sm:flex sm:flex-row-reverse">
            <button
              @click="deleteCounselor"
              class="btn btn-danger sm:ml-3 sm:w-auto w-full"
            >
              Yes, Delete Counselor
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
import { ref, computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminSidebar from '../../../Components/Admin/AdminSidebar.vue'
import AdminTopbar from '../../../Components/Admin/AdminTopbar.vue'
import CreateCounselorModal from '../../../Components/Admin/Modals/CreateCounselorModal.vue'
import EditCounselorModal from '../../../Components/Admin/Modals/EditCounselorModal.vue'
import ShowCounselorModal from '../../../Components/Admin/Modals/ShowCounselorModal.vue'

const props = defineProps({
  counselors: Object,
  stats: Object,
  filters: Object,
})

// State
const searchQuery = ref(props.filters.search || '')
const statusFilter = ref(props.filters.status || '')
const selectedCounselors = ref([])
const isMobileMenuOpen = ref(false)

// Modal states
const showCreateModal = ref(false)
const showEditModal = ref(false)
const showShowModal = ref(false)
const showDeleteModal = ref(false)
const selectedCounselor = ref(null)
const counselorToDelete = ref(null)

// Search debounce
let searchTimeout = null

// Methods
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

const debounceSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    applyFilters()
  }, 500)
}

const applyFilters = () => {
  const params = {}
  
  if (searchQuery.value) params.search = searchQuery.value
  if (statusFilter.value) params.status = statusFilter.value

  router.get(route('admin.counselors.index'), params, {
    preserveState: true,
    replace: true,
  })
}

const clearFilters = () => {
  searchQuery.value = ''
  statusFilter.value = ''
  router.get(route('admin.counselors.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

const getInitials = (name) => {
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

// Modal handlers
const openCreateModal = () => {
  showCreateModal.value = true
}

const closeCreateModal = () => {
  showCreateModal.value = false
}

const handleCounselorCreated = () => {
  closeCreateModal()
  router.reload()
}

const editCounselor = (counselor) => {
  selectedCounselor.value = counselor
  showEditModal.value = true
}

const closeEditModal = () => {
  showEditModal.value = false
  selectedCounselor.value = null
}

const handleCounselorUpdated = () => {
  closeEditModal()
  router.reload()
}

const showCounselor = (counselor) => {
  selectedCounselor.value = counselor
  showShowModal.value = true
}

const closeShowModal = () => {
  showShowModal.value = false
  selectedCounselor.value = null
}

const handleEditFromShow = (counselor) => {
  closeShowModal()
  editCounselor(counselor)
}

const handleDeleteFromShow = (counselor) => {
  closeShowModal()
  confirmDelete(counselor)
}

const confirmDelete = (counselor) => {
  counselorToDelete.value = counselor
  showDeleteModal.value = true
}

const deleteCounselor = () => {
  if (counselorToDelete.value) {
    router.delete(route('admin.counselors.destroy', counselorToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        counselorToDelete.value = null
      }
    })
  }
}

// Bulk actions
const toggleSelectAll = (event) => {
  if (event.target.checked) {
    selectedCounselors.value = props.counselors.data.map(counselor => counselor.id)
  } else {
    selectedCounselors.value = []
  }
}

const bulkAction = (action) => {
  if (selectedCounselors.value.length === 0) return

  router.post(route('admin.counselors.bulk-action'), {
    action: action,
    counselor_ids: selectedCounselors.value
  }, {
    onSuccess: () => {
      selectedCounselors.value = []
    }
  })
}
</script>

<style scoped>
@import '/resources/css/users.css';
</style>