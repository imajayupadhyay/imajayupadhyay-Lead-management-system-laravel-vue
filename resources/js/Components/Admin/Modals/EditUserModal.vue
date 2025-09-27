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
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-white">Edit User</h3>
                <p class="text-emerald-100 text-sm">Update {{ user?.name }}'s information</p>
              </div>
            </div>
            <button
              @click="closeModal"
              class="text-white hover:text-emerald-200 transition-colors p-2 hover:bg-white hover:bg-opacity-10 rounded-lg"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="p-6 space-y-6">
          <!-- Basic Information Section -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Basic Information
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Full Name -->
              <div>
                <label for="edit-name" class="block text-sm font-semibold text-gray-700 mb-2">
                  Full Name <span class="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  id="edit-name"
                  v-model="form.name"
                  required
                  class="form-input"
                  :class="{ 'border-red-500 ring-red-500': form.errors.name }"
                  placeholder="Enter full name"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.name }}</p>
              </div>

              <!-- Email -->
              <div>
                <label for="edit-email" class="block text-sm font-semibold text-gray-700 mb-2">
                  Email Address <span class="text-red-500">*</span>
                </label>
                <input
                  type="email"
                  id="edit-email"
                  v-model="form.email"
                  required
                  class="form-input"
                  :class="{ 'border-red-500 ring-red-500': form.errors.email }"
                  placeholder="user@example.com"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.email }}</p>
              </div>

              <!-- Phone -->
              <div>
                <label for="edit-phone" class="block text-sm font-semibold text-gray-700 mb-2">
                  Phone Number
                </label>
                <input
                  type="tel"
                  id="edit-phone"
                  v-model="form.phone"
                  class="form-input"
                  :class="{ 'border-red-500 ring-red-500': form.errors.phone }"
                  placeholder="+1 (555) 000-0000"
                />
                <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.phone }}</p>
              </div>

              <!-- Role -->
              <div>
                <label for="edit-role" class="block text-sm font-semibold text-gray-700 mb-2">
                  Role <span class="text-red-500">*</span>
                </label>
                <select
                  id="edit-role"
                  v-model="form.role"
                  required
                  class="form-input"
                  :class="{ 'border-red-500 ring-red-500': form.errors.role }"
                >
                  <option value="">Select Role</option>
                  <option value="admin">Admin</option>
                  <option value="counselor">Counselor</option>
                </select>
                <p v-if="form.errors.role" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.role }}</p>
              </div>
            </div>

            <!-- Account Status -->
            <div class="mt-6 p-4 bg-white rounded-lg border-2 border-gray-300 shadow-sm">
              <div class="flex items-center">
                <input
                  id="edit-is-active"
                  type="checkbox"
                  v-model="form.is_active"
                  class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                />
                <label for="edit-is-active" class="ml-3 block text-sm text-gray-900 font-semibold">
                  Account is active
                </label>
              </div>
              <p class="mt-2 text-sm text-gray-600 ml-8">
                When unchecked, the user will not be able to log in
              </p>
            </div>
          </div>

          <!-- Password Update Section -->
          <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl p-6 border-2 border-amber-200">
            <h4 class="text-lg font-semibold text-amber-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
              Password Settings
            </h4>

            <div class="mb-4 p-4 bg-white rounded-lg border-2 border-amber-200 shadow-sm">
              <div class="flex items-center">
                <input
                  id="edit-update-password"
                  type="checkbox"
                  v-model="updatePassword"
                  class="h-5 w-5 text-amber-600 focus:ring-amber-500 border-gray-300 rounded"
                />
                <label for="edit-update-password" class="ml-3 block text-sm font-semibold text-gray-900">
                  Update Password
                </label>
              </div>
              <p class="mt-2 text-sm text-gray-600 ml-8">
                Check this box if you want to change the user's password. Leave unchecked to keep the current password.
              </p>
            </div>

            <div v-if="updatePassword" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- New Password -->
              <div>
                <label for="edit-password" class="block text-sm font-semibold text-gray-700 mb-2">
                  New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input
                    :type="showPassword ? 'text' : 'password'"
                    id="edit-password"
                    v-model="form.password"
                    :required="updatePassword"
                    class="form-input pr-12"
                    :class="{ 'border-red-500 ring-red-500': form.errors.password }"
                    placeholder="Minimum 8 characters"
                  />
                  <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                  >
                    <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                </div>
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.password }}</p>
              </div>

              <!-- Confirm New Password -->
              <div>
                <label for="edit-password-confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                  Confirm New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <input
                    :type="showPasswordConfirmation ? 'text' : 'password'"
                    id="edit-password-confirmation"
                    v-model="form.password_confirmation"
                    :required="updatePassword"
                    class="form-input pr-12"
                    :class="{ 'border-red-500 ring-red-500': form.errors.password_confirmation }"
                    placeholder="Confirm new password"
                  />
                  <button
                    type="button"
                    @click="showPasswordConfirmation = !showPasswordConfirmation"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                  >
                    <svg v-if="showPasswordConfirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                </div>
                <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600 font-medium">{{ form.errors.password_confirmation }}</p>
              </div>
            </div>
          </div>

          <!-- Current User Warning -->
          <div v-if="user && user.id === $page.props.auth.user.id" class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
              </div>
              <div class="ml-3">
                <h4 class="text-sm font-medium text-amber-800">You are editing your own account</h4>
                <p class="mt-2 text-sm text-amber-700">
                  Be careful when changing your role or deactivating your account as this could prevent you from accessing the admin panel.
                </p>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
            <button
              type="button"
              @click="closeModal"
              class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 shadow-sm"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105"
            >
              <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span v-if="form.processing">Updating User...</span>
              <span v-else>Update User</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

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

const emit = defineEmits(['close', 'userUpdated'])

const page = usePage()

const form = useForm({
  name: '',
  email: '',
  phone: '',
  role: '',
  is_active: true,
  password: '',
  password_confirmation: '',
})

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)
const updatePassword = ref(false)

watch(() => props.user, (newUser) => {
  if (newUser) {
    form.name = newUser.name || ''
    form.email = newUser.email || ''
    form.phone = newUser.phone || ''
    form.role = newUser.role || ''
    form.is_active = newUser.is_active || false
    form.password = ''
    form.password_confirmation = ''
  }
}, { immediate: true })

watch(() => props.show, (newValue) => {
  if (!newValue) {
    // Reset password fields and flags when modal is closed
    form.password = ''
    form.password_confirmation = ''
    form.clearErrors()
    showPassword.value = false
    showPasswordConfirmation.value = false
    updatePassword.value = false
  }
})

watch(updatePassword, (newValue) => {
  if (!newValue) {
    form.password = ''
    form.password_confirmation = ''
    form.clearErrors('password', 'password_confirmation')
  }
})

const closeModal = () => {
  emit('close')
}

const submit = () => {
  if (!props.user) return

  const formData = { ...form.data() }

  // Remove password fields if not updating password
  if (!updatePassword.value) {
    delete formData.password
    delete formData.password_confirmation
  }

  form.put(route('admin.users.update', props.user.id), {
    data: formData,
    onSuccess: () => {
      emit('userUpdated')
    },
    onError: () => {
      // Form errors will be automatically handled by Inertia
    }
  })
}
</script>