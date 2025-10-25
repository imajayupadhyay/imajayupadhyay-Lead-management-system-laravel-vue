<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-100">
    <Head title="Marketer Funnel Analytics" />

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
        <div class="mx-auto max-w-7xl">
          <!-- Header -->
          <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Marketer Funnel Analytics</h1>
            <p class="mt-2 text-lg text-gray-600">Comprehensive insights into marketer performance and lead generation</p>
          </div>

          <!-- Filters -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
              <h2 class="text-lg font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filters
              </h2>
            </div>
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                  <label for="date_from" class="block text-sm font-semibold text-gray-700 mb-2">
                    Date From
                  </label>
                  <input
                    id="date_from"
                    v-model="form.date_from"
                    type="date"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                    @change="applyFilters"
                  >
                </div>
                <div>
                  <label for="date_to" class="block text-sm font-semibold text-gray-700 mb-2">
                    Date To
                  </label>
                  <input
                    id="date_to"
                    v-model="form.date_to"
                    type="date"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                    @change="applyFilters"
                  >
                </div>
                <div>
                  <label for="marketer_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Marketer
                  </label>
                  <select
                    id="marketer_id"
                    v-model="form.marketer_id"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 appearance-none cursor-pointer"
                    @change="applyFilters"
                  >
                    <option value="">All Marketers</option>
                    <option v-for="marketer in marketers" :key="marketer.id" :value="marketer.id">
                      {{ marketer.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Summary Stats -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Total Leads</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ formatNumber(summaryStats.total_leads) }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Active Marketers</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ formatNumber(summaryStats.active_marketers) }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Avg Leads/Marketer</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ formatNumber(summaryStats.average_leads_per_marketer) }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100 transform transition-all duration-300 hover:scale-105">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-red-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Hot Leads</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ formatNumber(summaryStats.hot_leads) }}</dd>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Conversion Metrics -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 overflow-hidden shadow-lg rounded-2xl border border-green-200">
              <div class="p-6">
                <div class="text-white">
                  <dt class="text-sm font-medium text-green-100">Enrollment Rate</dt>
                  <dd class="mt-2 text-3xl font-bold">{{ conversionRates.enrollment_rate }}%</dd>
                  <p class="mt-2 text-sm text-green-100">{{ conversionRates.enrolled }} enrolled out of {{ conversionRates.total }}</p>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 overflow-hidden shadow-lg rounded-2xl border border-blue-200">
              <div class="p-6">
                <div class="text-white">
                  <dt class="text-sm font-medium text-blue-100">Interest Rate</dt>
                  <dd class="mt-2 text-3xl font-bold">{{ conversionRates.interest_rate }}%</dd>
                  <p class="mt-2 text-sm text-blue-100">{{ conversionRates.interested }} interested leads</p>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-pink-600 overflow-hidden shadow-lg rounded-2xl border border-purple-200">
              <div class="p-6">
                <div class="text-white">
                  <dt class="text-sm font-medium text-purple-100">Demo Attendance</dt>
                  <dd class="mt-2 text-3xl font-bold">{{ leadQualityMetrics.demo_attendance_rate }}%</dd>
                  <p class="mt-2 text-sm text-purple-100">{{ leadQualityMetrics.demo_attended }} attended demos</p>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-red-600 overflow-hidden shadow-lg rounded-2xl border border-orange-200">
              <div class="p-6">
                <div class="text-white">
                  <dt class="text-sm font-medium text-orange-100">Class Visit Rate</dt>
                  <dd class="mt-2 text-3xl font-bold">{{ leadQualityMetrics.class_visit_rate }}%</dd>
                  <p class="mt-2 text-sm text-orange-100">{{ leadQualityMetrics.visited_class }} visited classes</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Charts Grid -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Leads by Marketer Chart -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Lead Distribution by Marketer</h3>
              </div>
              <div class="p-6">
                <canvas ref="leadsByMarketerChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Leads by Status -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Leads by Status</h3>
              </div>
              <div class="p-6">
                <canvas ref="leadsByStatusChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Leads Trend -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Leads Trend</h3>
              </div>
              <div class="p-6">
                <canvas ref="leadsTrendChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Lead Category Distribution -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Lead Category Distribution</h3>
              </div>
              <div class="p-6">
                <canvas ref="leadCategoryChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Enquiry Source Distribution -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Enquiry Source Distribution</h3>
              </div>
              <div class="p-6">
                <canvas ref="enquiryByChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>
          </div>

          <!-- Top Marketers Table -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
              <h3 class="text-lg font-bold text-white">Top Performing Marketers</h3>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Marketer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Leads</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Enrolled</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Interested</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hot Leads</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Enrollment Rate</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(marketer, index) in topMarketers" :key="index" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ marketer.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ marketer.email || 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ marketer.total_leads }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        {{ marketer.enrolled_leads }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                        {{ marketer.interested_leads }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                        {{ marketer.hot_leads }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        {{ marketer.enrollment_rate }}%
                      </span>
                    </td>
                  </tr>
                  <tr v-if="topMarketers.length === 0">
                    <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                      No data available for the selected period
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue';
import AdminTopbar from '@/Components/Admin/AdminTopbar.vue';
import Chart from 'chart.js/auto';

const props = defineProps({
  leadsByMarketer: Object,
  leadsByStatus: Object,
  leadsTrend: Object,
  leadCategoryDistribution: Object,
  conversionRates: Object,
  topMarketers: Array,
  summaryStats: Object,
  leadQualityMetrics: Object,
  enquiryByDistribution: Object,
  marketers: Array,
  filters: Object,
});

const isMobileMenuOpen = ref(false);
const form = ref({
  date_from: props.filters.date_from,
  date_to: props.filters.date_to,
  marketer_id: props.filters.marketer_id || '',
});

// Chart refs
const leadsByMarketerChart = ref(null);
const leadsByStatusChart = ref(null);
const leadsTrendChart = ref(null);
const leadCategoryChart = ref(null);
const enquiryByChart = ref(null);

// Chart instances
let chartInstances = {};

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const applyFilters = () => {
  router.get(route('admin.marketer-funnel'), form.value, {
    preserveState: true,
    preserveScroll: true,
  });
};

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-IN').format(number || 0);
};

const createLeadsByMarketerChart = () => {
  if (chartInstances.leadsByMarketerChart) {
    chartInstances.leadsByMarketerChart.destroy();
  }

  const ctx = leadsByMarketerChart.value.getContext('2d');
  chartInstances.leadsByMarketerChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: props.leadsByMarketer.labels,
      datasets: [{
        label: 'Leads Generated',
        data: props.leadsByMarketer.values,
        backgroundColor: 'rgba(168, 85, 247, 0.8)',
        borderColor: 'rgba(168, 85, 247, 1)',
        borderWidth: 2,
        borderRadius: 8,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 14,
          },
          bodyFont: {
            size: 13,
          },
          borderColor: 'rgba(168, 85, 247, 1)',
          borderWidth: 1,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)',
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
    },
  });
};

const createLeadsByStatusChart = () => {
  if (chartInstances.leadsByStatusChart) {
    chartInstances.leadsByStatusChart.destroy();
  }

  const ctx = leadsByStatusChart.value.getContext('2d');
  chartInstances.leadsByStatusChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: props.leadsByStatus.labels,
      datasets: [{
        data: props.leadsByStatus.values,
        backgroundColor: [
          'rgba(59, 130, 246, 0.8)',
          'rgba(16, 185, 129, 0.8)',
          'rgba(168, 85, 247, 0.8)',
          'rgba(239, 68, 68, 0.8)',
          'rgba(34, 197, 94, 0.8)',
        ],
        borderWidth: 3,
        borderColor: '#fff',
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 15,
            font: {
              size: 12,
            },
          },
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 14,
          },
          bodyFont: {
            size: 13,
          },
        },
      },
    },
  });
};

const createLeadsTrendChart = () => {
  if (chartInstances.leadsTrendChart) {
    chartInstances.leadsTrendChart.destroy();
  }

  const ctx = leadsTrendChart.value.getContext('2d');
  chartInstances.leadsTrendChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: props.leadsTrend.labels,
      datasets: [{
        label: 'Leads',
        data: props.leadsTrend.values,
        borderColor: 'rgba(16, 185, 129, 1)',
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        borderWidth: 3,
        fill: true,
        tension: 0.4,
        pointRadius: 4,
        pointBackgroundColor: 'rgba(16, 185, 129, 1)',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 14,
          },
          bodyFont: {
            size: 13,
          },
          borderColor: 'rgba(16, 185, 129, 1)',
          borderWidth: 1,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)',
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
    },
  });
};

const createLeadCategoryChart = () => {
  if (chartInstances.leadCategoryChart) {
    chartInstances.leadCategoryChart.destroy();
  }

  const ctx = leadCategoryChart.value.getContext('2d');
  chartInstances.leadCategoryChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: props.leadCategoryDistribution.labels,
      datasets: [{
        data: props.leadCategoryDistribution.values,
        backgroundColor: [
          'rgba(239, 68, 68, 0.8)',
          'rgba(251, 146, 60, 0.8)',
          'rgba(59, 130, 246, 0.8)',
          'rgba(156, 163, 175, 0.8)',
        ],
        borderWidth: 3,
        borderColor: '#fff',
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 15,
            font: {
              size: 12,
            },
          },
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 14,
          },
          bodyFont: {
            size: 13,
          },
        },
      },
    },
  });
};

const createEnquiryByChart = () => {
  if (chartInstances.enquiryByChart) {
    chartInstances.enquiryByChart.destroy();
  }

  const ctx = enquiryByChart.value.getContext('2d');
  chartInstances.enquiryByChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: props.enquiryByDistribution.labels,
      datasets: [{
        label: 'Enquiries',
        data: props.enquiryByDistribution.values,
        backgroundColor: 'rgba(59, 130, 246, 0.8)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 2,
        borderRadius: 8,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          titleFont: {
            size: 14,
          },
          bodyFont: {
            size: 13,
          },
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1,
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)',
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
    },
  });
};

const initializeCharts = () => {
  createLeadsByMarketerChart();
  createLeadsByStatusChart();
  createLeadsTrendChart();
  createLeadCategoryChart();
  createEnquiryByChart();
};

onMounted(() => {
  initializeCharts();
});

watch(() => props.filters, () => {
  setTimeout(() => {
    initializeCharts();
  }, 100);
}, { deep: true });
</script>

<style scoped>
/* Custom scrollbar for table */
.overflow-x-auto::-webkit-scrollbar {
  height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #a855f7;
  border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #9333ea;
}
</style>
