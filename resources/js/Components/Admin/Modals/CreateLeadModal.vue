<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
      
      <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 sm:px-8">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Add New Lead</h3>
                <p class="text-blue-100 text-sm">Add a new lead manually</p>
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
        <form @submit.prevent="submit" class="px-6 py-6 sm:px-8">
          <!-- Date Field -->
          <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
            <input
              v-model="form.date"
              type="date"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
            />
            <span v-if="form.errors.date" class="text-red-500 text-xs mt-1">{{ form.errors.date }}</span>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Left Column -->
            <div class="space-y-4">
              
              <!-- Student Name -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student Name *</label>
                <input
                  v-model="form.student_name"
                  type="text"
                  required
                  placeholder="Enter student name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
                <span v-if="form.errors.student_name" class="text-red-500 text-xs mt-1">{{ form.errors.student_name }}</span>
              </div>

              <!-- Gender -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                <select
                  v-model="form.gender"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                >
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Trans">Trans</option>
                </select>
              </div>

              <!-- Age -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                <input
                  v-model="form.age"
                  type="number"
                  min="1"
                  max="100"
                  placeholder="Enter age"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>

              <!-- Mobile Number -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number *</label>
                <input
                  v-model="form.mobile_number"
                  type="tel"
                  required
                  placeholder="Enter mobile number"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
                <span v-if="form.errors.mobile_number" class="text-red-500 text-xs mt-1">{{ form.errors.mobile_number }}</span>
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="Enter email address"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
                <span v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</span>
              </div>

              <!-- Address -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                <textarea
                  v-model="form.address"
                  required
                  rows="3"
                  placeholder="Enter complete address"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                ></textarea>
                <span v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}</span>
              </div>

              <!-- Pin Code -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pin Code *</label>
                <input
                  v-model="form.pin_code"
                  type="text"
                  required
                  placeholder="Enter pin code"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
                <span v-if="form.errors.pin_code" class="text-red-500 text-xs mt-1">{{ form.errors.pin_code }}</span>
              </div>

              <!-- State -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                <input
                  v-model="form.state"
                  type="text"
                  required
                  placeholder="Enter state"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
                <span v-if="form.errors.state" class="text-red-500 text-xs mt-1">{{ form.errors.state }}</span>
              </div>

              <!-- Qualification -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Qualification *</label>
                <input
                  v-model="form.qualification"
                  type="text"
                  required
                  placeholder="Enter qualification"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
                <span v-if="form.errors.qualification" class="text-red-500 text-xs mt-1">{{ form.errors.qualification }}</span>
              </div>

              <!-- College -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">College</label>
                <input
                  v-model="form.college"
                  type="text"
                  placeholder="Enter college name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
              
              <!-- Visited With -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Visited With *</label>
                <select
                  v-model="form.visited_with"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                >
                  <option value="">Select option</option>
                  <option value="Self">Self</option>
                  <option value="Parent/Friend">Parent/Friend</option>
                </select>
                <span v-if="form.errors.visited_with" class="text-red-500 text-xs mt-1">{{ form.errors.visited_with }}</span>
              </div>

              <!-- Parent/Friend Specify (conditional) -->
              <div v-if="form.visited_with === 'Parent/Friend'">
                <label class="block text-sm font-medium text-gray-700 mb-2">Parent/Friend Specify</label>
                <input
                  v-model="form.parent_friend_specify"
                  type="text"
                  placeholder="Enter name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>

              <!-- Parent Occupation -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Parent Occupation</label>
                <input
                  v-model="form.parent_occupation"
                  type="text"
                  placeholder="Enter parent occupation"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>

              <!-- Interested In -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Interested In</label>
                <div class="grid grid-cols-2 gap-2">
                  <label v-for="course in courseOptions" :key="course" class="flex items-center">
                    <input
                      type="checkbox"
                      :value="course"
                      v-model="form.interested_in"
                      class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    />
                    <span class="ml-2 text-sm text-gray-700">{{ course }}</span>
                  </label>
                </div>
              </div>

              <!-- Course Language -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course Language</label>
                <select
                  v-model="form.course_language"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                >
                  <option value="">Select Language</option>
                  <option value="Bilingual">Bilingual</option>
                  <option value="English">English</option>
                  <option value="Hindi">Hindi</option>
                </select>
              </div>

              <!-- Course Type Details -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course Type Details</label>
                <input
                  v-model="form.course_type_details"
                  type="text"
                  placeholder="Enter course type details"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>

              <!-- GS Module -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">GS Module</label>
                <input
                  v-model="form.gs_module"
                  type="text"
                  placeholder="Enter GS module"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>

              <!-- Optional Subject -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Optional Subject</label>
                <input
                  v-model="form.optional_subject"
                  type="text"
                  placeholder="Enter optional subject"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>

              <!-- Other Query -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Other Query</label>
                <textarea
                  v-model="form.other_query"
                  rows="3"
                  placeholder="Enter any other query"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                ></textarea>
              </div>

              <!-- Target Year -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Target Year</label>
                <input
                  v-model="form.target_year"
                  type="text"
                  placeholder="Enter target year"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
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
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105"
            >
              <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ form.processing ? 'Creating...' : 'Add Lead' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close', 'leadCreated'])

// Course options (same as public form)
const courseOptions = ref([
  'UPSC CSE',
  'State PSC',
  'Banking',
  'SSC',
  'Railway',
  'Teaching',
  'Defence',
  'Other'
])

// Form setup (matching public enquiry form fields exactly)
const form = useForm({
  date: new Date().toISOString().split('T')[0],
  student_name: '',
  gender: '',
  age: null,
  mobile_number: '',
  email: '',
  address: '',
  pin_code: '',
  state: '',
  qualification: '',
  college: '',
  visited_with: '',
  parent_friend_specify: '',
  parent_occupation: '',
  interested_in: [],
  course_language: '',
  course_type_details: '',
  gs_module: '',
  optional_subject: '',
  other_query: '',
  target_year: ''
})

// Watch for modal close
watch(() => props.show, (newValue) => {
  if (!newValue) {
    form.reset()
    form.clearErrors()
  }
})

// Clear parent/friend specify when visited_with changes
watch(() => form.visited_with, (newValue) => {
  if (newValue !== 'Parent/Friend') {
    form.parent_friend_specify = ''
  }
})

const closeModal = () => {
  emit('close')
}

const submit = () => {
  form.post(route('admin.leads.store'), {
    onSuccess: () => {
      emit('leadCreated')
      closeModal()
    },
    onError: () => {
      // Form errors will be automatically handled by Inertia
    }
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