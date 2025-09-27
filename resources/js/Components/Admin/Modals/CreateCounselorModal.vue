<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" @click="closeModal"></div>
      
      <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
        <form @submit.prevent="submit" class="bg-white">
          <!-- Header -->
          <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-xl font-bold text-white">Add New Counselor</h3>
                  <p class="text-purple-100 text-sm">Create a new counseling team member account</p>
                </div>
              </div>
              <button
                type="button"
                @click="closeModal"
                class="text-purple-100 hover:text-white transition-colors duration-200"
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
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                  Full Name <span class="text-red-500">*</span>
                </label>
                <input
                  id="name"
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
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                  Email Address <span class="text-red-500">*</span>
                </label>
                <input
                  id="email"
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
            <div>
              <!-- Phone -->
              <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                  Phone Number
                </label>
                <input
                  id="phone"
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

            <!-- Counseling Information -->
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-200">
              <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Counselor Responsibilities
              </h4>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center text-purple-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Student guidance and counseling</span>
                </div>
                <div class="flex items-center text-purple-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Lead management and follow-ups</span>
                </div>
                <div class="flex items-center text-purple-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Course consultation and advice</span>
                </div>
                <div class="flex items-center text-purple-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Enrollment process assistance</span>
                </div>
                <div class="flex items-center text-purple-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Student progress monitoring</span>
                </div>
                <div class="flex items-center text-purple-700">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span>Academic planning support</span>
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
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-lg shadow-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105"
            >
              <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span v-if="form.processing">Creating Counselor...</span>
              <span v-else>Create Counselor</span>
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
  }
})

const emit = defineEmits(['close', 'counselorCreated'])

const form = useForm({
  name: '',
  email: '',
  phone: '',
  is_active: true,
})

watch(() => props.show, (newValue) => {
  if (!newValue) {
    // Reset form when modal is closed
    form.reset()
    form.clearErrors()
  }
})

const closeModal = () => {
  emit('close')
}

const submit = () => {
  form.post(route('admin.counselors.store'), {
    onSuccess: () => {
      emit('counselorCreated')
    },
    onError: () => {
      // Form errors will be automatically handled by Inertia
    }
  })
}
</script>