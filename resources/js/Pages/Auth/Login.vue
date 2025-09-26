<template>
  <div class="min-h-screen bg-gradient-to-br from-navy-900 via-navy-800 to-blue-900 flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <!-- Background Animation Elements -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white/3 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <!-- Login Container -->
    <div class="relative w-full max-w-md">
      <!-- Logo Section -->
      <div class="text-center mb-8 animate-fade-in-down">
        <div class="mx-auto w-20 h-20 bg-gradient-to-tr from-white to-blue-100 rounded-2xl flex items-center justify-center mb-6 shadow-xl transform hover:scale-105 transition-transform duration-300">
          <svg class="w-10 h-10 text-navy-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
          </svg>
        </div>
        <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
          Lead Management
        </h1>
        <p class="text-blue-200 text-lg font-medium">
          System Dashboard
        </p>
      </div>

      <!-- Login Form Card -->
      <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 overflow-hidden animate-fade-in-up">
        <div class="px-8 py-10">
          <!-- Form Header -->
          

          <!-- Login Form -->
          <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Field -->
            <div class="space-y-2">
              <label for="email" class="block text-sm font-semibold text-gray-700">
                Email Address
              </label>
              <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400 group-focus-within:text-navy-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                </div>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  autocomplete="username"
                  class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-navy-500 focus:border-transparent transition-all duration-300 text-gray-800 placeholder-gray-500"
                  placeholder="Enter your email"
                  :class="{ 'border-red-300 ring-red-100': form.errors.email }"
                />
              </div>
              <div v-if="form.errors.email" class="text-red-600 text-sm mt-1 animate-shake">
                {{ form.errors.email }}
              </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
              <label for="password" class="block text-sm font-semibold text-gray-700">
                Password
              </label>
              <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400 group-focus-within:text-navy-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <input
                  id="password"
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  autocomplete="current-password"
                  class="w-full pl-12 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-navy-500 focus:border-transparent transition-all duration-300 text-gray-800 placeholder-gray-500"
                  placeholder="Enter your password"
                  :class="{ 'border-red-300 ring-red-100': form.errors.password }"
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-navy-500 transition-colors"
                >
                  <svg v-if="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                  </svg>
                  <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
              <div v-if="form.errors.password" class="text-red-600 text-sm mt-1 animate-shake">
                {{ form.errors.password }}
              </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
              <label class="flex items-center">
                <input
                  v-model="form.remember"
                  type="checkbox"
                  class="rounded border-gray-300 text-navy-600 shadow-sm focus:ring-navy-500 focus:ring-offset-0"
                />
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
              </label>
              
              <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="text-sm text-navy-600 hover:text-navy-500 font-medium transition-colors"
              >
                Forgot password?
              </Link>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              :disabled="form.processing"
              class="w-full bg-gradient-to-r from-navy-600 to-blue-600 hover:from-navy-700 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            >
              <span v-if="!form.processing" class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Sign In
              </span>
              <span v-else class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Signing In...
              </span>
            </button>
          </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-blue-50 border-t border-gray-200">
          <p class="text-center text-sm text-gray-600">
            Secure login powered by 
            <span class="font-semibold text-navy-600">NuclearEdge</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
})

const showPassword = ref(false)

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<style scoped>
@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

.animate-fade-in-down {
  animation: fadeInDown 0.8s ease-out;
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out 0.2s both;
}

.animate-shake {
  animation: shake 0.5s ease-in-out;
}

/* Custom navy color classes */
.text-navy-900 { color: #0f172a; }
.text-navy-800 { color: #1e293b; }
.text-navy-700 { color: #334155; }
.text-navy-600 { color: #475569; }
.text-navy-500 { color: #64748b; }

.bg-navy-900 { background-color: #0f172a; }
.bg-navy-800 { background-color: #1e293b; }
.bg-navy-700 { background-color: #334155; }
.bg-navy-600 { background-color: #475569; }
.bg-navy-500 { background-color: #64748b; }

.from-navy-900 { --tw-gradient-from: #0f172a; }
.from-navy-800 { --tw-gradient-from: #1e293b; }
.from-navy-700 { --tw-gradient-from: #334155; }
.from-navy-600 { --tw-gradient-from: #475569; }

.to-navy-900 { --tw-gradient-to: #0f172a; }
.to-navy-800 { --tw-gradient-to: #1e293b; }
.to-navy-700 { --tw-gradient-to: #334155; }
.to-navy-600 { --tw-gradient-to: #475569; }

.via-navy-900 { --tw-gradient-via: #0f172a; }
.via-navy-800 { --tw-gradient-via: #1e293b; }

.border-navy-500 { border-color: #64748b; }
.ring-navy-500 { --tw-ring-color: #64748b; }

.hover\:text-navy-500:hover { color: #64748b; }
.hover\:text-navy-700:hover { color: #334155; }
.hover\:from-navy-700:hover { --tw-gradient-from: #334155; }
.hover\:to-blue-700:hover { --tw-gradient-to: #1d4ed8; }

.focus\:ring-navy-500:focus { --tw-ring-color: #64748b; }
.group-focus-within\:text-navy-500 { color: #64748b; }
</style>