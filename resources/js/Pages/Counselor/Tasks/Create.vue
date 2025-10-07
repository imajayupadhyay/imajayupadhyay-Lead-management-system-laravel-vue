<template>
  <Head title="Create Task - Counselor" />
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Counselor Sidebar -->
    <CounselorSidebar
      :isMobileMenuOpen="isMobileMenuOpen"
      @closeMobileMenu="closeMobileMenu"
    />

    <!-- Main Content Area -->
    <div class="lg:pl-64">
      <!-- Counselor Topbar -->
      <CounselorTopbar @toggleMobileMenu="toggleMobileMenu" />

      <!-- Page Content -->
      <main class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
          <!-- Page Header -->
          <div class="mb-8">
            <Link :href="route('counselor.tasks.index')" class="text-blue-600 hover:text-blue-700 mb-4 inline-flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Back to Tasks
            </Link>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Create New Task</h1>
            <p class="text-gray-600 mt-2">Add a new task to your to-do list</p>
          </div>

          <!-- Task Form -->
          <div class="bg-white rounded-xl shadow-lg p-8">
            <form @submit.prevent="submitForm">
              <!-- Title -->
              <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                  Task Title <span class="text-red-500">*</span>
                </label>
                <input
                  id="title"
                  v-model="form.title"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Enter task title"
                  required
                />
                <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</p>
              </div>

              <!-- Description -->
              <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                  Description
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  rows="4"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Enter task description"
                ></textarea>
                <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
              </div>

              <!-- Due Date and Time -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                  <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Due Date
                  </label>
                  <input
                    id="due_date"
                    v-model="form.due_date"
                    type="date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  />
                  <p v-if="form.errors.due_date" class="text-red-500 text-sm mt-1">{{ form.errors.due_date }}</p>
                </div>
                <div>
                  <label for="due_time" class="block text-sm font-medium text-gray-700 mb-2">
                    Due Time
                  </label>
                  <input
                    id="due_time"
                    v-model="form.due_time"
                    type="time"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  />
                  <p v-if="form.errors.due_time" class="text-red-500 text-sm mt-1">{{ form.errors.due_time }}</p>
                </div>
              </div>

              <!-- Priority and Status -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                  <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                    Priority <span class="text-red-500">*</span>
                  </label>
                  <select
                    id="priority"
                    v-model="form.priority"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                  >
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                  </select>
                  <p v-if="form.errors.priority" class="text-red-500 text-sm mt-1">{{ form.errors.priority }}</p>
                </div>
                <div>
                  <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                  </label>
                  <select
                    id="status"
                    v-model="form.status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                  >
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                  </select>
                  <p v-if="form.errors.status" class="text-red-500 text-sm mt-1">{{ form.errors.status }}</p>
                </div>
              </div>

              <!-- Form Actions -->
              <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <Link
                  :href="route('counselor.tasks.index')"
                  class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors"
                >
                  Cancel
                </Link>
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="form.processing">Creating...</span>
                  <span v-else>Create Task</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import CounselorSidebar from '@/Components/Counselor/CounselorSidebar.vue';
import CounselorTopbar from '@/Components/Counselor/CounselorTopbar.vue';

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const form = useForm({
  title: '',
  description: '',
  due_date: '',
  due_time: '',
  priority: 'Medium',
  status: 'Pending'
});

const submitForm = () => {
  form.post(route('counselor.tasks.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset()
  });
};
</script>
