<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" @click="closeModal"></div>
      
      <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                  {{ getInitials(lead?.student_name) }}
                </div>
              </div>
              <div class="ml-4">
                <h3 class="text-2xl font-bold text-white">{{ lead?.student_name }}</h3>
                <p class="text-indigo-100 text-sm">Student Lead Details</p>
                <div class="flex items-center mt-2">
                  <span
                    :class="[
                      'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                      getStatusBadgeClass(lead?.status)
                    ]"
                  >
                    {{ lead?.status }}
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
        <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
          <!-- Personal Information -->
          <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Personal Information
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Full Name</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.student_name || 'Not provided' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Gender</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.gender || 'Not specified' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Age</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.age ? `${lead.age} years` : 'Not provided' }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Contact Information -->
          <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              Contact Information
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Mobile Number</dt>
                <dd class="form-input bg-white shadow-sm border-2 flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  {{ lead?.mobile_number || 'Not provided' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Email Address</dt>
                <dd class="form-input bg-white shadow-sm border-2 flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                  {{ lead?.email || 'Not provided' }}
                </dd>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Address</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.address || 'Not provided' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">PIN Code</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.pin_code || 'Not provided' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">State</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.state || 'Not provided' }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Academic Information -->
          <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              Academic Information
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Qualification</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.qualification || 'Not provided' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">College/University</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.college || 'Not specified' }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Course Interest -->
          <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
              Course Interest & Preferences
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Interested Courses</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ formatInterestedCourses(lead?.interested_in) }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Course Language</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.course_language || 'Not specified' }}
                </dd>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Course Type</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.course_type_details || 'Not specified' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">GS Module</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.gs_module || 'Not specified' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Target Year</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.target_year || 'Not specified' }}
                </dd>
              </div>
            </div>

            <div v-if="lead?.optional_subject || lead?.other_query" class="mt-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div v-if="lead?.optional_subject">
                  <dt class="text-sm font-semibold text-gray-700 mb-2">Optional Subject</dt>
                  <dd class="form-input bg-white shadow-sm border-2">
                    {{ lead.optional_subject }}
                  </dd>
                </div>

                <div v-if="lead?.other_query">
                  <dt class="text-sm font-semibold text-gray-700 mb-2">Other Query</dt>
                  <dd class="form-input bg-white shadow-sm border-2">
                    {{ lead.other_query }}
                  </dd>
                </div>
              </div>
            </div>
          </div>

          <!-- Visit Information -->
          <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-6 border border-cyan-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              Visit & Family Information
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Visited With</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.visited_with || 'Not specified' }}
                </dd>
              </div>

              <div v-if="lead?.parent_friend_specify">
                <dt class="text-sm font-semibold text-gray-700 mb-2">Parent/Friend Name</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead.parent_friend_specify }}
                </dd>
              </div>

              <div v-if="lead?.parent_occupation">
                <dt class="text-sm font-semibold text-gray-700 mb-2">Parent Occupation</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead.parent_occupation }}
                </dd>
              </div>
            </div>
          </div>

          <!-- Assignment & Management -->
          <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-200 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
              </svg>
              Assignment & Management
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-4">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Assigned Counselor</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.counselor?.name || 'Not assigned' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Assigned Marketer</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.marketer?.name || 'Not assigned' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Assigned Faculty</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.faculty ? `${lead.faculty.name} (${lead.faculty.subject})` : 'Not assigned' }}
                </dd>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Enquiry By</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ lead?.enquiry_by || 'Not specified' }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Visited Class</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  <span :class="lead?.visited_class ? 'text-green-600' : 'text-red-600'">
                    {{ lead?.visited_class ? 'Yes' : 'No' }}
                  </span>
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Demo Attended</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  <span :class="lead?.demo_attended ? 'text-green-600' : 'text-red-600'">
                    {{ lead?.demo_attended ? 'Yes' : 'No' }}
                  </span>
                </dd>
              </div>
            </div>
          </div>

          <!-- Timeline -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
              <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Lead Timeline
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Enquiry Date</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ formatDate(lead?.date) }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Created At</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ formatDateTime(lead?.created_at) }}
                </dd>
              </div>

              <div>
                <dt class="text-sm font-semibold text-gray-700 mb-2">Last Updated</dt>
                <dd class="form-input bg-white shadow-sm border-2">
                  {{ formatDateTime(lead?.updated_at) }}
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
                @click="editLead"
                class="btn btn-primary"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Lead
              </button>

              <button
                @click="deleteLead"
                class="btn btn-danger"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Lead
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
  lead: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'editLead', 'deleteLead'])

const closeModal = () => {
  emit('close')
}

const editLead = () => {
  emit('editLead', props.lead)
}

const deleteLead = () => {
  emit('deleteLead', props.lead)
}

const getInitials = (name) => {
  if (!name) return 'L'
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
}

const formatDate = (dateString) => {
  if (!dateString) return 'N/A'
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatDateTime = (dateString) => {
  if (!dateString) return 'N/A'
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatInterestedCourses = (courses) => {
  if (!courses) return 'Not specified'
  
  try {
    if (typeof courses === 'string') {
      const parsed = JSON.parse(courses)
      return Array.isArray(parsed) ? parsed.join(', ') : courses
    }
    if (Array.isArray(courses)) {
      return courses.join(', ')
    }
    return courses.toString()
  } catch (e) {
    return courses || 'Not specified'
  }
}

const getStatusBadgeClass = (status) => {
  const classes = {
    'New': 'bg-blue-100 bg-opacity-20 text-blue-200 border border-blue-200',
    'Contacted': 'bg-yellow-100 bg-opacity-20 text-yellow-200 border border-yellow-200',
    'Interested': 'bg-purple-100 bg-opacity-20 text-purple-200 border border-purple-200',
    'Not Interested': 'bg-red-100 bg-opacity-20 text-red-200 border border-red-200',
    'Enrolled': 'bg-green-100 bg-opacity-20 text-green-200 border border-green-200'
  }
  return classes[status] || 'bg-gray-100 bg-opacity-20 text-gray-200 border border-gray-200'
}
</script>

<style scoped>
@import '/resources/css/users.css';
</style>