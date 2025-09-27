<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <!-- Background overlay -->
      <div
        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity"
        @click="closeModal"
      ></div>

      <!-- Modal panel -->
      <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-6 relative overflow-hidden">
          <!-- Background decoration -->
          <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
          <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-purple-400/20 rounded-full blur-xl"></div>

          <div class="relative flex items-center justify-between">
            <div class="flex items-center">
              <!-- User Avatar -->
              <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                <span class="text-2xl font-bold text-white">
                  {{ user?.name?.charAt(0)?.toUpperCase() }}
                </span>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">{{ user?.name }}</h3>
                <p class="text-indigo-100 text-sm">{{ user?.email }}</p>
                <div class="flex items-center mt-2 space-x-2">
                  <span
                    :class="[
                      'px-2 py-1 text-xs font-semibold rounded-full',
                      user?.role === 'admin'
                        ? 'bg-white bg-opacity-20 text-white border border-white border-opacity-30'
                        : 'bg-blue-100 bg-opacity-20 text-white border border-blue-200 border-opacity-30'
                    ]"
                  >
                    {{ user?.role?.charAt(0)?.toUpperCase() + user?.role?.slice(1) }}
                  </span>
                  <span
                    :class="[
                      'px-2 py-1 text-xs font-semibold rounded-full border border-opacity-30',
                      user?.is_active
                        ? 'bg-green-100 bg-opacity-20 text-white border-green-200'
                        : 'bg-red-100 bg-opacity-20 text-white border-red-200'
                    ]"
                  >
                    {{ user?.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </div>
              </div>
            </div>
            <button
              @click="closeModal"
              class="text-white hover:text-indigo-200 transition-colors p-2 hover:bg-white hover:bg-opacity-10 rounded-lg"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
          <!-- User Information -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              User Information
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Full Name</dt>
                <dd class="form-input bg-white shadow-sm border-2">{{ user?.name || 'N/A' }}</dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Email Address</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  <a :href="`mailto:${user?.email}`" class="text-blue-600 hover:text-blue-700 transition-colors font-medium">
                    {{ user?.email || 'N/A' }}
                  </a>
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Phone Number</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  <span v-if="user?.phone">
                    <a :href="`tel:${user.phone}`" class="text-blue-600 hover:text-blue-700 transition-colors font-medium">
                      {{ user.phone }}
                    </a>
                  </span>
                  <span v-else class="text-gray-400">N/A</span>
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Role</dt>
                <dd class="text-sm text-gray-900">
                  <span :class="[
                    'badge inline-flex items-center',
                    user?.role === 'admin' ? 'badge-admin' : 'badge-counselor'
                  ]">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path v-if="user?.role === 'admin'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                      <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    {{ user?.role?.charAt(0)?.toUpperCase() + user?.role?.slice(1) }}
                  </span>
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Account Status</dt>
                <dd class="text-sm text-gray-900">
                  <span :class="[
                    'badge inline-flex items-center',
                    user?.is_active ? 'badge-active' : 'badge-inactive'
                  ]">
                    <div :class="[
                      'w-2 h-2 rounded-full mr-2',
                      user?.is_active ? 'bg-white' : 'bg-white'
                    ]"></div>
                    {{ user?.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Member Since</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ formatDate(user?.created_at) }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Role Permissions -->
          <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
            <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Role Permissions
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <template v-if="user?.role === 'admin'">
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">Full system access</span>
                </div>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">Manage users (create, edit, delete)</span>
                </div>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">View and manage all leads</span>
                </div>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">Access reports and analytics</span>
                </div>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">System configuration and settings</span>
                </div>
              </template>
              <template v-else>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">View assigned leads</span>
                </div>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">Update lead status and add notes</span>
                </div>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">Schedule and manage follow-ups</span>
                </div>
                <div class="flex items-center text-blue-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="text-sm">View personal performance statistics</span>
                </div>
                <div class="flex items-center text-gray-500">
                  <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  <span class="text-sm">Cannot manage other users</span>
                </div>
                <div class="flex items-center text-gray-500">
                  <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  <span class="text-sm">No system configuration access</span>
                </div>
              </template>
            </div>
          </div>

          <!-- Account Activity -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Account Timeline
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Account Created</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ formatDate(user?.created_at) }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Last Updated</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ formatDate(user?.updated_at) }}
                </dd>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
          <div class="flex justify-between items-center">
            <button
              @click="closeModal"
              class="btn btn-outline"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              Close
            </button>

            <div class="flex space-x-3">
              <button
                @click="editUser"
                class="btn btn-primary"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit User
              </button>

              <button
                @click="deleteUser"
                :disabled="user?.id === $page.props.auth.user.id"
                :class="[
                  'btn',
                  user?.id === $page.props.auth.user.id ? 'btn-secondary' : 'btn-danger'
                ]"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                {{ user?.id === $page.props.auth.user.id ? 'Cannot Delete' : 'Delete User' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  user: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'editUser', 'deleteUser'])

const page = usePage()

const closeModal = () => {
  emit('close')
}

const editUser = () => {
  emit('editUser', props.user)
}

const deleteUser = () => {
  emit('deleteUser', props.user)
}

const formatDate = (dateString) => {
  if (!dateString) return 'N/A'

  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>

<style scoped>
@import '/resources/css/users.css';
</style>