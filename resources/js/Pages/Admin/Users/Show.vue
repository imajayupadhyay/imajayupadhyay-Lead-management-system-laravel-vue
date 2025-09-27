<template>
  <div class="min-h-screen bg-gray-100">
    <Head :title="`User Details - ${user.name}`" />
    
    <!-- Page Header -->
    <div class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
          <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
              <li>
                <Link :href="route('admin.users.index')" class="text-gray-500 hover:text-gray-700">
                  Users
                </Link>
              </li>
              <li>
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-gray-900">{{ user.name }}</span>
              </li>
            </ol>
          </nav>
          
          <div class="mt-4 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
              <div class="flex items-center">
                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                  <span class="text-xl font-medium text-gray-700">
                    {{ user.name.charAt(0).toUpperCase() }}
                  </span>
                </div>
                <div class="ml-4">
                  <h1 class="text-2xl font-bold leading-7 text-gray-900">{{ user.name }}</h1>
                  <div class="mt-1 flex items-center space-x-3">
                    <span
                      :class="[
                        'px-2 py-1 text-xs font-medium rounded-full',
                        user.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'
                      ]"
                    >
                      {{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}
                    </span>
                    <span
                      :class="[
                        'px-2 py-1 text-xs font-medium rounded-full',
                        user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                      ]"
                    >
                      {{ user.is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
              <Link
                :href="route('admin.users.edit', user.id)"
                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
              >
                Edit
              </Link>
              <button
                @click="toggleUserStatus"
                :class="[
                  'inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold shadow-sm',
                  user.is_active 
                    ? 'bg-red-600 text-white hover:bg-red-500'
                    : 'bg-green-600 text-white hover:bg-green-500'
                ]"
              >
                {{ user.is_active ? 'Deactivate' : 'Activate' }}
              </button>
              <button
                @click="deleteUser"
                :disabled="user.id === $page.props.auth.user.id"
                :class="[
                  'inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500',
                  user.id === $page.props.auth.user.id ? 'opacity-50 cursor-not-allowed' : ''
                ]"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      
      <!-- User Information Card -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">User Information</h3>
        </div>
        <div class="px-6 py-5">
          <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500">Full Name</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ user.name }}</dd>
            </div>
            
            <div>
              <dt class="text-sm font-medium text-gray-500">Email Address</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <a :href="`mailto:${user.email}`" class="text-blue-600 hover:text-blue-500">
                  {{ user.email }}
                </a>
              </dd>
            </div>
            
            <div v-if="user.phone">
              <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
              <dd class="mt-1 text-sm text-gray-900">
                <a :href="`tel:${user.phone}`" class="text-blue-600 hover:text-blue-500">
                  {{ user.phone }}
                </a>
              </dd>
            </div>
            
            <div>
              <dt class="text-sm font-medium text-gray-500">Role</dt>
              <dd class="mt-1">
                <span
                  :class="[
                    'px-2 py-1 text-xs font-medium rounded-full',
                    user.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'
                  ]"
                >
                  {{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}
                </span>
              </dd>
            </div>
            
            <div>
              <dt class="text-sm font-medium text-gray-500">Account Status</dt>
              <dd class="mt-1">
                <span
                  :class="[
                    'px-2 py-1 text-xs font-medium rounded-full',
                    user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                  ]"
                >
                  {{ user.is_active ? 'Active' : 'Inactive' }}
                </span>
              </dd>
            </div>
            
            <div>
              <dt class="text-sm font-medium text-gray-500">Member Since</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ formatDate(user.created_at) }}</dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Role Permissions Card -->
      <div class="mt-6 bg-white shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Role Permissions</h3>
        </div>
        <div class="px-6 py-5">
          <div class="space-y-3">
            <template v-if="user.role === 'admin'">
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">Full system access</span>
              </div>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">Manage users (create, edit, delete)</span>
              </div>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">View and manage all leads</span>
              </div>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">Access reports and analytics</span>
              </div>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">System configuration and settings</span>
              </div>
            </template>
            <template v-else>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">View assigned leads</span>
              </div>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">Update lead status and add notes</span>
              </div>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">Schedule and manage follow-ups</span>
              </div>
              <div class="flex items-center">
                <span class="text-green-500 mr-3">✓</span>
                <span class="text-sm text-gray-900">View personal performance statistics</span>
              </div>
              <div class="flex items-center">
                <span class="text-red-500 mr-3">✗</span>
                <span class="text-sm text-gray-500">Cannot manage other users</span>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-10 overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showDeleteModal = false"></div>
        
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900">Delete User</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">
                  Are you sure you want to delete <strong>{{ user.name }}</strong>? This action cannot be undone.
                </p>
              </div>
            </div>
          </div>
          <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <button
              @click="confirmDelete"
              class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
            >
              Delete
            </button>
            <button
              @click="showDeleteModal = false"
              class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
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

const props = defineProps({
  user: Object,
})

const showDeleteModal = ref(false)

const toggleUserStatus = () => {
  router.patch(route('admin.users.toggle-status', props.user.id), {}, {
    preserveScroll: true,
  })
}

const deleteUser = () => {
  showDeleteModal.value = true
}

const confirmDelete = () => {
  router.delete(route('admin.users.destroy', props.user.id), {
    onSuccess: () => {
      showDeleteModal.value = false
    },
  })
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>