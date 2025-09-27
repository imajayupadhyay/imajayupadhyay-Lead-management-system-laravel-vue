<template>
  <div class="min-h-screen bg-gray-100">
    <Head title="Add New User" />
    
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
                <span class="text-gray-900">Add New User</span>
              </li>
            </ol>
          </nav>
          
          <div class="mt-4">
            <h1 class="text-2xl font-bold leading-7 text-gray-900">Add New User</h1>
            <p class="mt-1 text-sm text-gray-500">Create a new admin or counselor account</p>
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
                  placeholder="Enter full name"
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
                  placeholder="user@example.com"
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
                  placeholder="+1 (555) 000-0000"
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
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              
              <!-- Password -->
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                  Password <span class="text-red-500">*</span>
                </label>
                <input
                  :type="showPassword ? 'text' : 'password'"
                  id="password"
                  v-model="form.password"
                  required
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  :class="{ 'border-red-300': form.errors.password }"
                  placeholder="Minimum 8 characters"
                />
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long</p>
              </div>

              <!-- Confirm Password -->
              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                  Confirm Password <span class="text-red-500">*</span>
                </label>
                <input
                  :type="showPasswordConfirmation ? 'text' : 'password'"
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  required
                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  :class="{ 'border-red-300': form.errors.password_confirmation }"
                  placeholder="Confirm password"
                />
                <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
              </div>
            </div>

            <!-- Status -->
            <div class="mt-6">
              <div class="flex items-center">
                <input
                  id="is_active"
                  type="checkbox"
                  v-model="form.is_active"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                  Activate account immediately
                </label>
              </div>
              <p class="mt-1 text-sm text-gray-500">
                When checked, the user will be able to log in immediately after creation
              </p>
            </div>
          </div>

          <!-- Role Information -->
          <div v-if="form.role" class="border-t border-gray-200 pt-6">
            <div class="rounded-md bg-blue-50 p-4">
              <div class="flex">
                <div class="ml-3">
                  <h4 class="text-sm font-medium text-blue-900">
                    {{ form.role === 'admin' ? 'Admin' : 'Counselor' }} Role Permissions
                  </h4>
                  <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc pl-5 space-y-1">
                      <template v-if="form.role === 'admin'">
                        <li>Full access to all system features</li>
                        <li>Manage users (create, edit, delete)</li>
                        <li>View and manage all leads</li>
                        <li>Access to reports and analytics</li>
                        <li>System configuration and settings</li>
                      </template>
                      <template v-else>
                        <li>Access to assigned leads only</li>
                        <li>Update lead status and add notes</li>
                        <li>Schedule and manage follow-ups</li>
                        <li>View personal performance statistics</li>
                        <li>Update own profile information</li>
                      </template>
                    </ul>
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
                <span v-if="form.processing">Creating User...</span>
                <span v-else>Create User</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  phone: '',
  role: '',
  password: '',
  password_confirmation: '',
  is_active: true,
})

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)

const submit = () => {
  form.post(route('admin.users.store'))
}
</script>