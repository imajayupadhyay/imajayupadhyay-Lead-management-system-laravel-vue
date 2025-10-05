<template>
  <Head title="Dashboard - Admin" />
  <div class="min-h-screen bg-gray-50">
    <!-- Admin Sidebar -->
    <AdminSidebar
      :isMobileMenuOpen="isMobileMenuOpen"
      @closeMobileMenu="closeMobileMenu"
    />
    
    <!-- Main Content Area -->
    <div class="lg:pl-64">
      <!-- Admin Topbar -->
      <AdminTopbar @toggleMobileMenu="toggleMobileMenu" />
      
      <!-- Page Content -->
      <main class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <!-- Welcome Heading -->
          <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 animate-fade-in">
              Welcome, {{ user.name }}!
            </h1>
          </div>

          <!-- Statistics Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Users Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Users</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats?.users?.total || 0 }}</p>
                  <p class="text-sm text-gray-600 mt-1">
                    <span class="text-green-600 font-medium">{{ stats?.users?.active || 0 }}</span> active
                  </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Leads Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Leads</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats?.leads?.total || 0 }}</p>
                  <p class="text-sm text-gray-600 mt-1">
                    <span class="text-green-600 font-medium">{{ stats?.leads?.today || 0 }}</span> today
                  </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Counselors Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Counselors</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats?.counselors?.total || 0 }}</p>
                  <p class="text-sm text-gray-600 mt-1">
                    <span class="text-green-600 font-medium">{{ stats?.counselors?.active || 0 }}</span> active
                  </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Faculty Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Faculty</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats?.faculty?.total || 0 }}</p>
                  <p class="text-sm text-gray-600 mt-1">
                    <span class="text-green-600 font-medium">{{ stats?.faculty?.active || 0 }}</span> active
                  </p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Additional Statistics Cards -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Marketers Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Marketers</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats?.marketers?.total || 0 }}</p>
                  <p class="text-sm text-gray-600 mt-1">
                    <span class="text-green-600 font-medium">{{ stats?.marketers?.active || 0 }}</span> active
                  </p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Monthly Growth -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Monthly Growth</p>
                  <p class="text-3xl font-bold text-gray-900">{{ leadsAnalytics?.monthlyComparison?.growth || 0 }}%</p>
                  <p class="text-sm text-gray-600 mt-1">
                    vs previous month
                  </p>
                </div>
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- This Week's Leads -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">This Week</p>
                  <p class="text-3xl font-bold text-gray-900">{{ stats?.leads?.this_week || 0 }}</p>
                  <p class="text-sm text-gray-600 mt-1">
                    new leads
                  </p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Leads Status Breakdown -->
          <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Leads Status Breakdown</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
              <!-- New Leads -->
              <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-100">
                <div class="text-2xl font-bold text-blue-600">{{ stats?.leads?.new || 0 }}</div>
                <div class="text-sm text-blue-800 font-medium">New</div>
              </div>

              <!-- Contacted -->
              <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                <div class="text-2xl font-bold text-yellow-600">{{ stats?.leads?.contacted || 0 }}</div>
                <div class="text-sm text-yellow-800 font-medium">Contacted</div>
              </div>

              <!-- Interested -->
              <div class="text-center p-4 bg-green-50 rounded-lg border border-green-100">
                <div class="text-2xl font-bold text-green-600">{{ stats?.leads?.interested || 0 }}</div>
                <div class="text-sm text-green-800 font-medium">Interested</div>
              </div>

              <!-- Enrolled -->
              <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-100">
                <div class="text-2xl font-bold text-purple-600">{{ stats?.leads?.enrolled || 0 }}</div>
                <div class="text-sm text-purple-800 font-medium">Enrolled</div>
              </div>

              <!-- Not Interested -->
              <div class="text-center p-4 bg-red-50 rounded-lg border border-red-100">
                <div class="text-2xl font-bold text-red-600">{{ stats?.leads?.not_interested || 0 }}</div>
                <div class="text-sm text-red-800 font-medium">Not Interested</div>
              </div>
            </div>
          </div>

          <!-- Charts Section -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Leads Trend Chart - Spans full width on large screens -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Leads Trend (Last 30 Days)</h3>
              <div class="h-64 md:h-80">
                <canvas ref="leadsChartCanvas" id="leadsChart"></canvas>
              </div>
            </div>

            <!-- Leads Status Distribution -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Leads by Status</h3>
              <div class="h-64 md:h-80">
                <canvas ref="statusChartCanvas" id="statusChart"></canvas>
              </div>
            </div>

            <!-- Course Interest Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Courses</h3>
              <div class="h-64 md:h-80">
                <canvas ref="courseChartCanvas" id="courseChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AdminSidebar from '../../Components/Admin/AdminSidebar.vue'
import AdminTopbar from '../../Components/Admin/AdminTopbar.vue'
import { Chart, registerables } from 'chart.js'

// Register Chart.js components
Chart.register(...registerables)

// Props
const props = defineProps({
  user: Object,
  stats: Object,
  leadsAnalytics: Object,
})

// Mobile menu state
const isMobileMenuOpen = ref(false)

// Chart refs
const leadsChartCanvas = ref(null)
const statusChartCanvas = ref(null)
const courseChartCanvas = ref(null)

// Chart instances
let leadsChart = null
let statusChart = null
let courseChart = null

// Methods
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

// Chart initialization
const initializeCharts = () => {
  // Initialize Leads Trend Chart
  if (leadsChartCanvas.value) {
    const ctx = leadsChartCanvas.value.getContext('2d')
    const labels = props.leadsAnalytics?.leadsLast30Days?.map(item => item.label) || []
    const data = props.leadsAnalytics?.leadsLast30Days?.map(item => item.count) || []

    leadsChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Leads',
          data: data,
          borderColor: '#8B5CF6',
          backgroundColor: 'rgba(139, 92, 246, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#8B5CF6',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 5,
          pointHoverRadius: 7
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: '#f3f4f6'
            },
            ticks: {
              color: '#6b7280'
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              color: '#6b7280',
              maxRotation: 45
            }
          }
        },
        elements: {
          point: {
            hoverBackgroundColor: '#8B5CF6'
          }
        }
      }
    })
  }

  // Initialize Status Distribution Chart
  if (statusChartCanvas.value) {
    const ctx = statusChartCanvas.value.getContext('2d')
    const statusData = props.leadsAnalytics?.leadsByStatus || {}
    const labels = Object.keys(statusData)
    const data = Object.values(statusData)

    const colors = [
      '#3B82F6', // Blue
      '#10B981', // Green
      '#F59E0B', // Yellow
      '#EF4444', // Red
      '#8B5CF6', // Purple
      '#F97316', // Orange
    ]

    statusChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: colors.slice(0, labels.length),
          borderColor: '#ffffff',
          borderWidth: 3,
          hoverOffset: 10
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              usePointStyle: true,
              color: '#374151'
            }
          }
        },
        cutout: '60%'
      }
    })
  }

  // Initialize Course Interest Chart
  if (courseChartCanvas.value) {
    const ctx = courseChartCanvas.value.getContext('2d')
    const courseData = props.leadsAnalytics?.leadsByCourse || {}
    const labels = Object.keys(courseData).slice(0, 8) // Show top 8 courses
    const data = Object.values(courseData).slice(0, 8)

    const colors = [
      '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
      '#8B5CF6', '#F97316', '#06B6D4', '#84CC16'
    ]

    courseChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Leads',
          data: data,
          backgroundColor: colors.slice(0, labels.length),
          borderColor: colors.slice(0, labels.length),
          borderWidth: 2,
          borderRadius: 8,
          borderSkipped: false,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: '#f3f4f6'
            },
            ticks: {
              color: '#6b7280'
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              color: '#6b7280',
              maxRotation: 45
            }
          }
        }
      }
    })
  }
}

// Cleanup charts
const destroyCharts = () => {
  if (leadsChart) {
    leadsChart.destroy()
    leadsChart = null
  }
  if (statusChart) {
    statusChart.destroy()
    statusChart = null
  }
  if (courseChart) {
    courseChart.destroy()
    courseChart = null
  }
}

// Lifecycle
onMounted(() => {
  initializeCharts()
})

onUnmounted(() => {
  destroyCharts()
})
</script>

<style scoped>
/* Custom Navy Colors */
.bg-navy-600 { background-color: #475569; }
.from-navy-600 { --tw-gradient-from: #475569; }

/* Animation */
.animate-fade-in {
  animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(-10px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>