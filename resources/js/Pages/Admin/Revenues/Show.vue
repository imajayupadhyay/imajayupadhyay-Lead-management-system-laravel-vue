<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <Head title="View Revenue" />

    <!-- Mobile Sidebar -->
    <div v-show="isMobileMenuOpen" class="relative z-50 lg:hidden">
      <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="closeMobileMenu"></div>
      <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl">
        <AdminSidebar :isMobileMenuOpen="true" @closeMobileMenu="closeMobileMenu" />
      </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
      <AdminSidebar />
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64">
      <!-- Top Bar -->
      <AdminTopbar @toggleMobileMenu="toggleMobileMenu" />

      <!-- Main Content Area -->
      <main class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
          <!-- Header -->
          <div class="mb-8">
            <div class="flex items-center justify-between">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Revenue Details</h1>
                <p class="mt-2 text-lg text-gray-600">Receipt #{{ revenue.receipt_number }}</p>
              </div>
              <div class="flex space-x-3">
                <Link :href="route('admin.revenues.index')" class="btn btn-outline">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                  </svg>
                  Back to List
                </Link>
                <Link
                  v-if="revenue.status === 'Pending' || revenue.status === 'Confirmed'"
                  :href="route('admin.revenues.edit', revenue.id)"
                  class="btn btn-primary"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Edit
                </Link>
              </div>
            </div>
          </div>

          <!-- Status Badges -->
          <div class="mb-8 flex flex-wrap gap-3">
            <span :class="getStatusClass(revenue.status)" class="px-5 py-2.5 inline-flex items-center text-base font-bold rounded-xl shadow-lg">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ revenue.status }}
            </span>
            <span v-if="revenue.verified_at" class="px-5 py-2.5 inline-flex items-center text-base font-bold rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Verified
            </span>
            <span v-else class="px-5 py-2.5 inline-flex items-center text-base font-semibold rounded-xl bg-yellow-100 text-yellow-800 border-2 border-yellow-200">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Pending Verification
            </span>
          </div>

          <!-- Main Details Card -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
              <h2 class="text-xl font-bold text-white">Payment Information</h2>
            </div>
            <div class="p-6">
              <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Date</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ formatDate(revenue.date) }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Receipt Number</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.receipt_number }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Amount</dt>
                  <dd class="text-2xl font-bold text-green-600">₹{{ formatNumber(revenue.amount) }}</dd>
                </div>
                <div v-if="revenue.discount_applied > 0">
                  <dt class="text-sm font-medium text-gray-500 mb-1">Discount</dt>
                  <dd class="text-base font-semibold text-red-600">-₹{{ formatNumber(revenue.discount_applied) }}</dd>
                </div>
                <div v-if="revenue.discount_applied > 0">
                  <dt class="text-sm font-medium text-gray-500 mb-1">Net Amount</dt>
                  <dd class="text-2xl font-bold text-blue-600">₹{{ formatNumber(netAmount) }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Payment Type</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.payment_type }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Payment Mode</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.payment_mode }}</dd>
                </div>
                <div v-if="revenue.transaction_id">
                  <dt class="text-sm font-medium text-gray-500 mb-1">Transaction ID</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.transaction_id }}</dd>
                </div>
                <div v-if="revenue.course_type">
                  <dt class="text-sm font-medium text-gray-500 mb-1">Course Type</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.course_type }}</dd>
                </div>
                <div v-if="revenue.installment_number">
                  <dt class="text-sm font-medium text-gray-500 mb-1">Installment</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.installment_number }} of {{ revenue.total_installments }}</dd>
                </div>
              </dl>
            </div>
          </div>

          <!-- Counselor and Lead Details -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Counselor Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Counselor Details</h3>
              </div>
              <div class="p-6">
                <dl class="space-y-3">
                  <div>
                    <dt class="text-sm font-medium text-gray-500 mb-1">Name</dt>
                    <dd class="text-base font-semibold text-gray-900">{{ revenue.counselor?.name }}</dd>
                  </div>
                  <div v-if="revenue.counselor?.email">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Email</dt>
                    <dd class="text-base text-gray-900">{{ revenue.counselor?.email }}</dd>
                  </div>
                  <div v-if="revenue.counselor?.phone">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Phone</dt>
                    <dd class="text-base text-gray-900">{{ revenue.counselor?.phone }}</dd>
                  </div>
                </dl>
              </div>
            </div>

            <!-- Lead Card -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Lead Details</h3>
              </div>
              <div class="p-6">
                <dl v-if="revenue.lead" class="space-y-3">
                  <div>
                    <dt class="text-sm font-medium text-gray-500 mb-1">Student Name</dt>
                    <dd class="text-base font-semibold text-gray-900">{{ revenue.lead.student_name }}</dd>
                  </div>
                  <div v-if="revenue.lead.mobile_number">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Mobile</dt>
                    <dd class="text-base text-gray-900">{{ revenue.lead.mobile_number }}</dd>
                  </div>
                  <div v-if="revenue.lead.email">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Email</dt>
                    <dd class="text-base text-gray-900">{{ revenue.lead.email }}</dd>
                  </div>
                </dl>
                <div v-else class="text-center text-gray-400 py-4">
                  <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <p class="mt-2 text-sm">No lead associated</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Notes -->
          <div v-if="revenue.notes" class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-yellow-600 to-orange-600 px-6 py-4">
              <h3 class="text-lg font-bold text-white">Notes</h3>
            </div>
            <div class="p-6">
              <p class="text-gray-700 whitespace-pre-wrap">{{ revenue.notes }}</p>
            </div>
          </div>

          <!-- Audit Information -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
              <h3 class="text-lg font-bold text-white">Audit Trail</h3>
            </div>
            <div class="p-6">
              <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Collected By</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.collected_by?.name || 'N/A' }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Created At</dt>
                  <dd class="text-base text-gray-900">{{ formatDateTime(revenue.created_at) }}</dd>
                </div>
                <div v-if="revenue.verified_by">
                  <dt class="text-sm font-medium text-gray-500 mb-1">Verified By</dt>
                  <dd class="text-base font-semibold text-gray-900">{{ revenue.verified_by?.name }}</dd>
                </div>
                <div v-if="revenue.verified_at">
                  <dt class="text-sm font-medium text-gray-500 mb-1">Verified At</dt>
                  <dd class="text-base text-gray-900">{{ formatDateTime(revenue.verified_at) }}</dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500 mb-1">Last Updated</dt>
                  <dd class="text-base text-gray-900">{{ formatDateTime(revenue.updated_at) }}</dd>
                </div>
              </dl>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue';
import AdminTopbar from '@/Components/Admin/AdminTopbar.vue';

const props = defineProps({
  revenue: Object,
});

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const netAmount = computed(() => {
  return (parseFloat(props.revenue.amount) || 0) - (parseFloat(props.revenue.discount_applied) || 0);
});

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
