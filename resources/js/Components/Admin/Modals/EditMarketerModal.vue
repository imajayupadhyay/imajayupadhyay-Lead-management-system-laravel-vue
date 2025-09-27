<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" @click="closeModal"></div>
      
      <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
        <form @submit.prevent="submit" class="bg-white">
          <!-- Header -->
          <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-xl font-bold text-white">Edit Marketer</h3>
                  <p class="text-emerald-100 text-sm">Update marketer information and settings</p>
                </div>
              </div>
              <button
                type="button"
                @click="closeModal"
                class="text-emerald-100 hover:text-white transition-colors duration-200"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Form Content -->
          <div class="px-6 py-6 space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Name -->
              <div>
                <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">
                  Full Name <span class="text-red-500">*</span>
                </label>
                <input
                  id="edit_name"
                  v-model="form.name"
                  type="text"
                  required
                  class="form-input"
                  :class="{ 'border-red-300': form.errors.name }"
                  placeholder="Enter full name"
                />
                <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                  {{ form.errors.name }}
                </div>
              </div>

              <!-- Email -->
              <div>
                <label for="edit_email" class="block text-sm font-semibold text-gray-700 mb-2">
                  Email Address <span class="text-red-500">*</span>
                </label>
                <input
                  id="edit_email"
                  v-model="form.email"
                  type="email"
                  required
                  class="form-input"
                  :class="{ 'border-red-300': form.errors.email }"
                  placeholder="Enter email address"
                />
                <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                  {{ form.errors.email }}
                </div>
              </div>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Phone -->
              <div>
                <label for="edit_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                  Phone Number
                </label>
                <input
                  id="edit_phone"
                  v-model="form.phone"
                  type="text"
                  class="form-input"
                  :class="{ 'border-red-300': form.errors.phone }"
                  placeholder="Enter phone number"
                />
                <div v-if="form.errors.phone" class="mt-1 text-sm text-red-600">
                  {{ form.errors.phone }}
                </div>
              </div>

              <!-- Designation -->
              <div>
                <label for="edit_designation" class="block text-sm font-semibold text-gray-700 mb-2">
                  Designation
                </label>
                <input
                  id="edit_designation"
                  v-model="form.designation"
                  type="text"
                  class="form-input"
                  :class="{ 'border-red-300': form.errors.designation }"
                  placeholder="e.g., Marketing Executive"
                />
                <div v-if="form.errors.designation" class="mt-1 text-sm text-red-600">
                  {{ form.errors.designation }}
                </div>
              </div>
            </div>

            <!-- Status -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3">Account Status</label>
              <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                  <input
                    v-model="form.is_active"
                    :value="true"
                    type="radio"
                    class="form-radio text-green-600 focus:ring-green-500"
                  />
                  <span class="ml-2 text-sm text-gray-700 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-green-400 mr-2"></span>
                    Active
                  </span>
                </label>
                <label class="inline-flex items-center">
                  <input
                    v-model="form.is_active"
                    :value="false"
                    type="radio"
                    class="form-radio text-red-600 focus:ring-red-500"
                  />
                  <span class="ml-2 text-sm text-gray-700 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-red-400 mr-2"></span>
                    Inactive
                  </span>
                </label>
              </div>
              <div v-if="form.errors.is_active" class="mt-1 text-sm text-red-600">
                {{ form.errors.is_active }}
              </div>
            </div>

            <!-- Marketing Information -->
            <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-6 border border-emerald-200">
              <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Update Marketer Responsibilities
              </h4>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center text-emerald-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Lead generation and acquisition</span>
                </div>
                <div class="flex items-center text-emerald-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Campaign management and tracking</span>
                </div>
                <div class="flex items-center text-emerald-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Customer relationship building</span>
                </div>
                <div class="flex items-center text-emerald-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Performance analytics and reporting</span>
                </div>
              </div>
            </div>

            <!-- Account Information -->
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
                    {{ formatDate(marketer?.created_at) }}
                  </dd>
                </div>

                <div>
                  <dt class="text-sm font-semibold text-gray-700 mb-2">Last Updated</dt>
                  <dd class="form-input bg-white shadow-sm border-2">
                    {{ formatDate(marketer?.updated_at) }}
                  </dd>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 border-t border-gray-200">
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
              <span v-if="form.processing">Updating Marketer...</span>
              <span v-else>Update Marketer</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  marketer: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'marketerUpdated'])

const form = useForm({
  name: '',
  email: '',
  phone: '',
  designation: '',
  is_active: true,
})

watch(() => props.marketer, (newMarketer) => {
  if (newMarketer) {
    form.name = newMarketer.name || ''
    form.email = newMarketer.email || ''
    form.phone = newMarketer.phone || ''
    form.designation = newMarketer.designation || ''
    form.is_active = newMarketer.is_active !== undefined ? newMarketer.is_active : true
  }
}, { immediate: true })

watch(() => props.show, (newValue) => {
  if (!newValue) {
    // Clear errors when modal is closed
    form.clearErrors()
  }
})

const closeModal = () => {
  emit('close')
}

const submit = () => {
  if (!props.marketer) return

  form.put(route('admin.marketers.update', props.marketer.id), {
    onSuccess: () => {
      emit('marketerUpdated')
    },
    onError: () => {
      // Form errors will be automatically handled by Inertia
    }
  })
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