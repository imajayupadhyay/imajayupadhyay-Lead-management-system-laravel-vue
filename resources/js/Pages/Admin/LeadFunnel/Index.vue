<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <Head title="Lead Funnel Analytics" />

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
            <h1 class="text-3xl font-bold text-gray-900">Lead Funnel Analytics</h1>
            <p class="mt-2 text-lg text-gray-600">Comprehensive insights into leads, revenue, and performance metrics</p>
          </div>

          <!-- Filters -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
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
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
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
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                    @change="applyFilters"
                  >
                </div>
                <div>
                  <label for="counselor_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Counselor
                  </label>
                  <select
                    id="counselor_id"
                    v-model="form.counselor_id"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 appearance-none cursor-pointer"
                    @change="applyFilters"
                  >
                    <option value="">All Counselors</option>
                    <option v-for="counselor in counselors" :key="counselor.id" :value="counselor.id">
                      {{ counselor.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Summary Stats -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Total Revenue</dt>
                    <dd class="text-2xl font-bold text-gray-900">₹{{ formatNumber(summaryStats.total_revenue) }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Avg Revenue/Lead</dt>
                    <dd class="text-2xl font-bold text-gray-900">₹{{ formatNumber(summaryStats.average_revenue_per_lead) }}</dd>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-100">
              <div class="p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                      <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-4">
                    <dt class="text-sm font-medium text-gray-500">Conversion Rate</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ conversionRates.conversion_rate }}%</dd>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Charts Grid -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Lead Funnel Chart -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Lead Funnel by Status</h3>
              </div>
              <div class="p-6">
                <canvas ref="leadFunnelChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Revenue by Counselor -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Revenue by Counselor (Top 10)</h3>
              </div>
              <div class="p-6">
                <canvas ref="revenueByCounselorChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Leads Trend -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Leads Trend</h3>
              </div>
              <div class="p-6">
                <canvas ref="leadsTrendChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Revenue Trend -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-orange-600 to-red-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Revenue Trend</h3>
              </div>
              <div class="p-6">
                <canvas ref="revenueTrendChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Lead Source Distribution -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Lead Source Distribution</h3>
              </div>
              <div class="p-6">
                <canvas ref="leadSourceChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>

            <!-- Payment Mode Distribution -->
            <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
              <div class="bg-gradient-to-r from-yellow-600 to-orange-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Payment Mode Distribution</h3>
              </div>
              <div class="p-6">
                <canvas ref="paymentModeChart" class="w-full" style="max-height: 300px;"></canvas>
              </div>
            </div>
          </div>

          <!-- Top Counselors Table -->
          <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
              <h3 class="text-lg font-bold text-white">Top Performing Counselors</h3>
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Counselor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Leads</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Converted</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Conversion Rate</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Revenue</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(counselor, index) in topCounselors" :key="index" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ counselor.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ counselor.total_leads }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ counselor.converted_leads }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        {{ counselor.conversion_rate }}%
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">₹{{ formatNumber(counselor.total_revenue) }}</td>
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
  leadFunnelData: Object,
  revenueByCounselor: Object,
  leadsTrend: Object,
  revenueTrend: Object,
  conversionRates: Object,
  leadSourceDistribution: Object,
  topCounselors: Array,
  summaryStats: Object,
  paymentModeDistribution: Object,
  counselors: Array,
  filters: Object,
});

const isMobileMenuOpen = ref(false);
const form = ref({
  date_from: props.filters.date_from,
  date_to: props.filters.date_to,
  counselor_id: props.filters.counselor_id || '',
});

// Chart refs
const leadFunnelChart = ref(null);
const revenueByCounselorChart = ref(null);
const leadsTrendChart = ref(null);
const revenueTrendChart = ref(null);
const leadSourceChart = ref(null);
const paymentModeChart = ref(null);

// Chart instances
let charts = {};

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const applyFilters = () => {
  router.get(route('admin.lead-funnel'), form.value, {
    preserveState: true,
    preserveScroll: true,
  });
};

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-IN').format(number || 0);
};

const createCharts = () => {
  // Destroy existing charts
  Object.values(charts).forEach(chart => chart?.destroy());
  charts = {};

  // Lead Funnel Chart (Funnel/Bar)
  if (leadFunnelChart.value) {
    charts.leadFunnel = new Chart(leadFunnelChart.value, {
      type: 'bar',
      data: {
        labels: props.leadFunnelData.labels,
        datasets: [{
          label: 'Number of Leads',
          data: props.leadFunnelData.values,
          backgroundColor: [
            'rgba(147, 51, 234, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(34, 197, 94, 0.8)',
            'rgba(156, 163, 175, 0.8)',
          ],
          borderColor: [
            'rgb(147, 51, 234)',
            'rgb(59, 130, 246)',
            'rgb(16, 185, 129)',
            'rgb(245, 158, 11)',
            'rgb(239, 68, 68)',
            'rgb(34, 197, 94)',
            'rgb(156, 163, 175)',
          ],
          borderWidth: 2,
          borderRadius: 8,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            titleFont: { size: 14 },
            bodyFont: { size: 13 },
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0, 0, 0, 0.05)' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
  }

  // Revenue by Counselor Chart (Horizontal Bar)
  if (revenueByCounselorChart.value) {
    charts.revenueByCounselor = new Chart(revenueByCounselorChart.value, {
      type: 'bar',
      data: {
        labels: props.revenueByCounselor.labels,
        datasets: [{
          label: 'Revenue (₹)',
          data: props.revenueByCounselor.values,
          backgroundColor: 'rgba(16, 185, 129, 0.8)',
          borderColor: 'rgb(16, 185, 129)',
          borderWidth: 2,
          borderRadius: 8,
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: { color: 'rgba(0, 0, 0, 0.05)' }
          },
          y: {
            grid: { display: false }
          }
        }
      }
    });
  }

  // Leads Trend Chart (Line)
  if (leadsTrendChart.value) {
    charts.leadsTrend = new Chart(leadsTrendChart.value, {
      type: 'line',
      data: {
        labels: props.leadsTrend.labels,
        datasets: [{
          label: 'Leads',
          data: props.leadsTrend.values,
          borderColor: 'rgb(59, 130, 246)',
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6,
          pointBackgroundColor: 'rgb(59, 130, 246)',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0, 0, 0, 0.05)' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
  }

  // Revenue Trend Chart (Line)
  if (revenueTrendChart.value) {
    charts.revenueTrend = new Chart(revenueTrendChart.value, {
      type: 'line',
      data: {
        labels: props.revenueTrend.labels,
        datasets: [{
          label: 'Revenue (₹)',
          data: props.revenueTrend.values,
          borderColor: 'rgb(249, 115, 22)',
          backgroundColor: 'rgba(249, 115, 22, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6,
          pointBackgroundColor: 'rgb(249, 115, 22)',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0, 0, 0, 0.05)' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
  }

  // Lead Source Distribution (Doughnut)
  if (leadSourceChart.value) {
    charts.leadSource = new Chart(leadSourceChart.value, {
      type: 'doughnut',
      data: {
        labels: props.leadSourceDistribution.labels,
        datasets: [{
          data: props.leadSourceDistribution.values,
          backgroundColor: [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(147, 51, 234, 0.8)',
            'rgba(236, 72, 153, 0.8)',
          ],
          borderWidth: 2,
          borderColor: '#fff',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: {
              padding: 15,
              font: { size: 12 }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
          }
        }
      }
    });
  }

  // Payment Mode Distribution (Pie)
  if (paymentModeChart.value) {
    charts.paymentMode = new Chart(paymentModeChart.value, {
      type: 'pie',
      data: {
        labels: props.paymentModeDistribution.labels,
        datasets: [{
          data: props.paymentModeDistribution.values,
          backgroundColor: [
            'rgba(34, 197, 94, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(147, 51, 234, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(156, 163, 175, 0.8)',
          ],
          borderWidth: 2,
          borderColor: '#fff',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: {
              padding: 15,
              font: { size: 12 }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
          }
        }
      }
    });
  }
};

onMounted(() => {
  createCharts();
});

// Recreate charts when data changes
watch(() => props.leadFunnelData, () => {
  createCharts();
}, { deep: true });
</script>
