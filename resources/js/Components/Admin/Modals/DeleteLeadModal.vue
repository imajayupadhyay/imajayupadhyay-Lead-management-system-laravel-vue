<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
      
      <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833-.208 2.5 1.732 2.5z" />
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Delete Lead</h3>
                <p class="text-red-100 text-sm">This action cannot be undone</p>
              </div>
            </div>
            <button
              @click="closeModal"
              class="text-white/80 hover:text-white transition-colors duration-200"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-6">
          <!-- Warning Icon and Message -->
          <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </div>
            </div>
            
            <div class="flex-1">
              <h4 class="text-lg font-semibold text-gray-900 mb-2">
                Are you sure you want to delete this lead?
              </h4>
              
              <p class="text-sm text-gray-600 mb-4">
                You are about to permanently delete the lead for <strong class="text-gray-900">{{ lead?.student_name }}</strong>. 
                This action cannot be undone and all associated data will be lost.
              </p>

              <!-- Lead Information Summary -->
              <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <h5 class="text-sm font-medium text-gray-900 mb-2">Lead Details:</h5>
                <div class="space-y-1 text-sm text-gray-700">
                  <div class="flex justify-between">
                    <span class="font-medium">Name:</span>
                    <span>{{ lead?.student_name }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="font-medium">Mobile:</span>
                    <span>{{ lead?.mobile_number }}</span>
                  </div>
                  <div v-if="lead?.email" class="flex justify-between">
                    <span class="font-medium">Email:</span>
                    <span>{{ lead?.email }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="font-medium">Date:</span>
                    <span>{{ formatDate(lead?.date) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="font-medium">Lead ID:</span>
                    <span>#{{ lead?.id }}</span>
                  </div>
                </div>
              </div>

              <!-- Confirmation Checkbox -->
              <div class="flex items-center space-x-3 mb-4">
                <input
                  id="confirm-delete"
                  v-model="confirmDelete"
                  type="checkbox"
                  class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                />
                <label for="confirm-delete" class="text-sm text-gray-700">
                  I understand this action is permanent and cannot be undone
                </label>
              </div>

              <!-- Final Warning -->
              <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <div class="flex items-center">
                  <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833-.208 2.5 1.732 2.5z" />
                  </svg>
                  <span class="text-sm text-yellow-800 font-medium">
                    Warning: This will permanently remove all lead data from the system.
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
          <div class="flex justify-end space-x-3">
            <button
              type="button"
              @click="closeModal"
              class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 shadow-sm"
            >
              Cancel
            </button>
            <button
              @click="deleteLead"
              :disabled="!confirmDelete || isDeleting"
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold rounded-lg shadow-lg hover:from-red-700 hover:to-pink-700 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            >
              <svg v-if="isDeleting" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              {{ isDeleting ? 'Deleting...' : 'Delete Lead' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  lead: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'leadDeleted'])

const confirmDelete = ref(false)
const isDeleting = ref(false)

// Watch for modal close and reset state
watch(() => props.show, (newValue) => {
  if (!newValue) {
    confirmDelete.value = false
    isDeleting.value = false
  }
})

const closeModal = () => {
  emit('close')
}

const deleteLead = () => {
  if (!props.lead || !confirmDelete.value || isDeleting.value) return

  isDeleting.value = true

  router.delete(route('admin.leads.destroy', props.lead.id), {
    onSuccess: () => {
      emit('leadDeleted')
      closeModal()
    },
    onError: () => {
      isDeleting.value = false
      // Handle error if needed
    },
    onFinish: () => {
      isDeleting.value = false
    }
  })
}

const formatDate = (dateString) => {
  if (!dateString) return 'N/A'
  
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>

<style scoped>
/* Custom animations */
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

.relative {
  animation: fadeIn 0.2s ease-out;
}
</style>