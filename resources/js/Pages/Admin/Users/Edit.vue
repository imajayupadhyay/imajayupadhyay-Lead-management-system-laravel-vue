<template>
  <div class="min-h-screen bg-gray-100">
    <Head :title="`Edit User - ${user.name}`" />
    
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
                <span class="text-gray-900">Edit {{ user.name }}</span>
              </li>
            </ol>
          </nav>
          
          <div class="mt-4">
            <h1 class="text-2xl font-bold leading-7 text-gray-900">Edit User: {{ user.name }}</h1>
            <p class="mt-1 text-sm text-gray-500">Update user information and settings</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white shadow rounded-lg">
        <form @submit.prevent="submit" class="space-y-6 p-6">
          
          <!-- Basic Information -->
          <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              
              <!-- Name -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                  Full Name <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  required
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  :class="{ 'border-red-300': form.errors.name }"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                  Email Address <span class="text-red-500">*</span>
                </label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  required
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  :class="{ 'border-red-300': form.errors.email }"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
              </div>

              <!-- Phone -->
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input
                  type="tel"
                  id="phone"
                  v-model="form.phone"
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  :class="{ 'border-red-300': form.errors.phone }"
                />
                <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</p>
              </div>

              <!-- Role -->
              <div>
                <label for="role" class="block text-sm font-medium text-gray-700">
                  Role <span class="text-red-500">*</span>
                </label>
                <select
                  id="role"
                  v-model="form.role"
                  required
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  :class="{ 'border-red-300': form.errors.role }"
                >
                  <option value="">Select Role</option>
                  <option value="admin">Admin</option>
                  <option value="counselor">Counselor</option>
                </select>
                <p v-if="form.errors.role" class="mt-1 text-sm text-red-600">{{ form.errors.role }}</p>
              </div>
            </div>
          </div>

          <!-- Account Settings -->
          <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Settings</h3>
            
            <!-- Status -->
            <div class="mb-6">
              <div class="flex items-center">
                <input
                  id="is_active"
                  type="checkbox"
                  v-model="form.is_active"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                  Account is active
                </label>
              </div>
              <p class="mt-1 text-sm text-gray-500">
                When unchecked, the user will not be able to log in
              </p>
            </div>

            <!-- Password Update Section -->
            <div class="border border-gray-200 rounded-md p-4 bg-gray-50">
              <div class="flex items-center mb-4">
                <input
                  id="update_password"
                  type="checkbox"
                  v-model="updatePassword"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label for="update_password" class="ml-2 block text-sm font-medium text-gray-900">
                  Update Password
                </label>
              </div>
              <p class="text-sm text-gray-600 mb-4">
                Check this box if you want to change the user's password. Leave unchecked to keep the current password.
              </p>
              
              <div v-if="updatePassword" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <!-- New Password -->
                <div>
                  <label for="password" class="block text-sm font-medium text-gray-700">
                    New Password <span class="text-red-500">*</span>
                  </label>
                  <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    v-model="form.password"
                    :required="updatePassword"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    :class="{ 'border-red-300': form.errors.password }"
                    placeholder="Minimum 8 characters"
                  />
                  <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <!-- Confirm New Password -->
                <div>
                  <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirm New Password <span class="text-red-500">*</span>
                  </label>
                  <input
                    :type="showPasswordConfirmation ? 'text' : 'password'"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :required="updatePassword"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    :class="{ 'border-red-300': form.errors.password_confirmation }"
                    placeholder="Confirm new password"
                  />
                  <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Current User Warning -->
          <div v-if="user.id === $page.props.auth.user.id" class="border-t border-gray-200 pt-6">
            <div class="rounded-md bg-yellow-50 p-4">
              <div class="flex">
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-yellow-800">
                    You are editing your own account
                  </h3>
                  <div class="mt-2 text-sm text-yellow-700">
                    <p>
                      Be careful when changing your role or deactivating your account as this could prevent you from accessing the admin panel.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="border-t border-gray-200 pt-6">
            <div class="flex justify-end space-x-3">
              <Link
                :href="route('admin.users.index')"
                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Cancel
              </Link>
              <button
                type="submit"
                :disabled="form.processing"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50"
              >
                <span v-if="form.processing">Updating User...</span>
                <span v-else>Update User</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
  user: Object,
})

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  phone: props.user.phone || '',
  role: props.user.role,
  is_active: props.user.is_active,
  password: '',
  password_confirmation: '',
})

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)
const updatePassword = ref(false)

watch(updatePassword, (newValue) => {
  if (!newValue) {
    form.password = ''
    form.password_confirmation = ''
    form.clearErrors('password', 'password_confirmation')
  }
})

const submit = () => {
  const formData = { ...form.data() }
  if (!updatePassword.value) {
    delete formData.password
    delete formData.password_confirmation
  }
  
  form.put(route('admin.users.update', props.user.id), {
    data: formData,
  })
}
</script>