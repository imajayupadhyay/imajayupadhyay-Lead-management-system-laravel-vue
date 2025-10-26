<template>
  <teleport to="body">
    <transition name="modal">
      <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto" @click.self="closeModal">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
          <!-- Background overlay -->
          <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" @click="closeModal"></div>

          <!-- Modal panel -->
          <div class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-6">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                  <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                  <div>
                    <h3 class="text-2xl font-bold text-white">Revenue Details</h3>
                    <p class="text-blue-100 text-sm mt-1">Receipt #{{ revenue.receipt_number }}</p>
                  </div>
                </div>
                <button
                  @click="closeModal"
                  class="text-white hover:bg-white/20 rounded-xl p-2 transition-colors"
                >
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Content -->
            <div class="px-8 py-6 max-h-[calc(100vh-250px)] overflow-y-auto">
              <!-- Status Badges -->
              <div class="mb-6 flex flex-wrap gap-3">
                <span :class="getStatusClass(revenue.status)" class="px-4 py-2 inline-flex items-center text-sm font-bold rounded-xl shadow-md">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ revenue.status }}
                </span>
                <span v-if="revenue.verified_at" class="px-4 py-2 inline-flex items-center text-sm font-bold rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-md">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Verified
                </span>
              </div>

              <!-- Payment Information -->
              <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 mb-6 border border-blue-200">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  Payment Information
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                  <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Date</dt>
                    <dd class="text-base font-semibold text-gray-900">{{ formatDate(revenue.date) }}</dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Amount</dt>
                    <dd class="text-xl font-bold text-green-600">₹{{ formatNumber(revenue.amount) }}</dd>
                  </div>
                  <div v-if="revenue.discount_applied > 0">
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Discount</dt>
                    <dd class="text-base font-semibold text-red-600">-₹{{ formatNumber(revenue.discount_applied) }}</dd>
                  </div>
                  <div v-if="revenue.discount_applied > 0">
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Net Amount</dt>
                    <dd class="text-xl font-bold text-blue-600">₹{{ formatNumber(netAmount) }}</dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Payment Type</dt>
                    <dd class="text-base font-semibold text-gray-900">{{ revenue.payment_type }}</dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Payment Mode</dt>
                    <dd class="text-base font-semibold text-gray-900">{{ revenue.payment_mode }}</dd>
                  </div>
                  <div v-if="revenue.transaction_id">
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Transaction ID</dt>
                    <dd class="text-sm font-medium text-gray-900 break-all">{{ revenue.transaction_id }}</dd>
                  </div>
                  <div v-if="revenue.course_type">
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Course Type</dt>
                    <dd class="text-base font-semibold text-gray-900">{{ revenue.course_type }}</dd>
                  </div>
                  <div v-if="revenue.installment_number">
                    <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Installment</dt>
                    <dd class="text-base font-semibold text-gray-900">{{ revenue.installment_number }} of {{ revenue.total_installments }}</dd>
                  </div>
                </div>
              </div>

              <!-- Counselor, Marketer and Lead Details -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Counselor -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200">
                  <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Counselor
                  </h4>
                  <div class="space-y-3">
                    <div>
                      <dt class="text-xs font-medium text-gray-500 uppercase">Name</dt>
                      <dd class="text-base font-semibold text-gray-900 mt-1">{{ revenue.counselor?.name }}</dd>
                    </div>
                    <div v-if="revenue.counselor?.email">
                      <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                      <dd class="text-sm text-gray-900 mt-1">{{ revenue.counselor?.email }}</dd>
                    </div>
                    <div v-if="revenue.counselor?.phone">
                      <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                      <dd class="text-sm text-gray-900 mt-1">{{ revenue.counselor?.phone }}</dd>
                    </div>
                  </div>
                </div>

                <!-- Marketer -->
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-6 border border-indigo-200">
                  <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Marketer
                  </h4>
                  <div v-if="revenue.marketer" class="space-y-3">
                    <div>
                      <dt class="text-xs font-medium text-gray-500 uppercase">Name</dt>
                      <dd class="text-base font-semibold text-gray-900 mt-1">{{ revenue.marketer.name }}</dd>
                    </div>
                    <div v-if="revenue.marketer.email">
                      <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                      <dd class="text-sm text-gray-900 mt-1">{{ revenue.marketer.email }}</dd>
                    </div>
                    <div v-if="revenue.marketer.phone">
                      <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                      <dd class="text-sm text-gray-900 mt-1">{{ revenue.marketer.phone }}</dd>
                    </div>
                  </div>
                  <div v-else class="text-center text-gray-400 py-4">
                    <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-2 text-sm">No marketer assigned</p>
                  </div>
                </div>

                <!-- Lead -->
                <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl p-6 border border-green-200">
                  <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Lead Details
                  </h4>
                  <div v-if="revenue.lead" class="space-y-3">
                    <div>
                      <dt class="text-xs font-medium text-gray-500 uppercase">Student Name</dt>
                      <dd class="text-base font-semibold text-gray-900 mt-1">{{ revenue.lead.student_name }}</dd>
                    </div>
                    <div v-if="revenue.lead.mobile_number">
                      <dt class="text-xs font-medium text-gray-500 uppercase">Mobile</dt>
                      <dd class="text-sm text-gray-900 mt-1">{{ revenue.lead.mobile_number }}</dd>
                    </div>
                    <div v-if="revenue.lead.email">
                      <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                      <dd class="text-sm text-gray-900 mt-1">{{ revenue.lead.email }}</dd>
                    </div>
                  </div>
                  <div v-else class="text-center text-gray-400 py-4">
                    <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="mt-2 text-sm">No lead associated</p>
                  </div>
                </div>
              </div>

              <!-- Notes -->
              <div v-if="revenue.notes" class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 mb-6 border border-yellow-200">
                <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                  </svg>
                  Notes
                </h4>
                <p class="text-gray-700 whitespace-pre-wrap">{{ revenue.notes }}</p>
              </div>

              <!-- Audit Trail -->
              <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Audit Trail
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                  <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Collected By</dt>
                    <dd class="text-base font-semibold text-gray-900 mt-1">{{ revenue.collected_by?.name || 'N/A' }}</dd>
                  </div>
                  <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Created At</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ formatDateTime(revenue.created_at) }}</dd>
                  </div>
                  <div v-if="revenue.verified_by">
                    <dt class="text-xs font-medium text-gray-500 uppercase">Verified By</dt>
                    <dd class="text-base font-semibold text-gray-900 mt-1">{{ revenue.verified_by?.name }}</dd>
                  </div>
                  <div v-if="revenue.verified_at">
                    <dt class="text-xs font-medium text-gray-500 uppercase">Verified At</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ formatDateTime(revenue.verified_at) }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 flex justify-between items-center">
              <div class="text-xs text-gray-500">
                Last updated: {{ formatDateTime(revenue.updated_at) }}
              </div>
              <div class="flex space-x-3">
                <button
                  @click="closeModal"
                  class="px-6 py-2.5 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-200"
                >
                  Close
                </button>
                <Link
                  v-if="revenue.status === 'Pending' || revenue.status === 'Confirmed'"
                  :href="route('admin.revenues.edit', revenue.id)"
                  class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl text-white font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 flex items-center space-x-2"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  <span>Edit Revenue</span>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </teleport>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  show: Boolean,
  revenue: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['close']);

const netAmount = computed(() => {
  return (parseFloat(props.revenue.amount) || 0) - (parseFloat(props.revenue.discount_applied) || 0);
});

const closeModal = () => {
  emit('close');
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-IN', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const formatDateTime = (datetime) => {
  return new Date(datetime).toLocaleString('en-IN', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(number || 0);
};

const getStatusClass = (status) => {
  const classes = {
    'Pending': 'bg-yellow-100 text-yellow-800',
    'Confirmed': 'bg-green-100 text-green-800',
    'Cancelled': 'bg-red-100 text-red-800',
    'Refunded': 'bg-gray-100 text-gray-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .inline-block,
.modal-leave-active .inline-block {
  transition: all 0.3s ease;
}

.modal-enter-from .inline-block,
.modal-leave-to .inline-block {
  transform: scale(0.95) translateY(-20px);
  opacity: 0;
}
</style>
