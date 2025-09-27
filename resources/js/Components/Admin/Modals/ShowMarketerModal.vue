<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" @click="closeModal"></div>
      
      <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                  {{ getInitials(marketer?.name) }}
                </div>
              </div>
              <div class="ml-4">
                <h3 class="text-2xl font-bold text-white">{{ marketer?.name }}</h3>
                <p class="text-indigo-100 text-sm">{{ marketer?.designation || 'Marketing Team Member' }}</p>
                <div class="flex items-center mt-2">
                  <span
                    :class="[
                      'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                      marketer?.is_active
                        ? 'bg-green-100 bg-opacity-20 text-green-200 border border-green-200'
                        : 'bg-red-100 bg-opacity-20 text-red-200 border border-red-200'
                    ]"
                  >
                    <span
                      :class="[
                        'w-2 h-2 rounded-full mr-2',
                        marketer?.is_active ? 'bg-green-300' : 'bg-red-300'
                      ]"
                    ></span>
                    {{ marketer?.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </div>
              </div>
            </div>
            <button
              @click="closeModal"
              class="text-indigo-100 hover:text-white transition-colors duration-200"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-6">
          <!-- Contact Information -->
          <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              Contact Information
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Email Address</dt>
                <dd class="form-input bg-white shadow-sm border-2 flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                  {{ marketer?.email || 'Not provided' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Phone Number</dt>
                <dd class="form-input bg-white shadow-sm border-2 flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  {{ marketer?.phone || 'Not provided' }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Professional Information -->
          <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H10a2 2 0 00-2-2V6m8 0H8" />
              </svg>
              Professional Details
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Designation</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ marketer?.designation || 'Not specified' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Marketer ID</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  #{{ marketer?.id }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Marketing Responsibilities -->
          <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              Marketing Responsibilities
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex items-center text-purple-700">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Lead generation and acquisition</span>
              </div>
              <div class="flex items-center text-purple-700">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Campaign management and tracking</span>
              </div>
              <div class="flex items-center text-purple-700">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Customer relationship building</span>
              </div>
              <div class="flex items-center text-purple-700">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Performance analytics and reporting</span>
              </div>
              <div class="flex items-center text-purple-700">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Brand promotion and marketing</span>
              </div>
              <div class="flex items-center text-purple-700">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm">Market research and analysis</span>
              </div>
            </div>
          </div>

          <!-- Account Timeline -->
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
                @click="deleteMarketer"
                class="btn btn-danger"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Marketer
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
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

const emit = defineEmits(['close', 'editMarketer', 'deleteMarketer'])

const closeModal = () => {
  emit('close')
}

const editMarketer = () => {
  emit('editMarketer', props.marketer)
}

const deleteMarketer = () => {
  emit('deleteMarketer', props.marketer)
}

const getInitials = (name) => {
  if (!name) return 'M'
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
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
