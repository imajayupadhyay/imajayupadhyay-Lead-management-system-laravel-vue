<template>
    <div class="min-h-screen bg-gradient-to-br from-white via-blue-50 to-navy-100 flex items-center justify-center">
        <div class="max-w-md mx-auto text-center">
            <div class="bg-white rounded-lg shadow-xl p-8">
                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Success Message -->
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Thank You!</h1>
                <p class="text-gray-600 mb-6">
                    Your enquiry has been submitted successfully. Our counselor will contact you shortly to discuss the best course options for you.
                </p>

                <!-- Actions -->
                <div class="space-y-4">
                    <a
                        href="/"
                        class="inline-block w-full bg-gradient-to-r from-navy-600 to-navy-800 text-white px-6 py-3 rounded-lg font-semibold hover:from-navy-700 hover:to-navy-900 transition duration-200"
                    >
                        Submit Another Enquiry
                    </a>
                    
                    <div class="text-sm text-gray-500">
                        <p>For immediate assistance, call us at:</p>
                        <p class="font-semibold text-navy-600">+91 XXXXX-XXXXX</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// No props needed for this component
</script>

<style scoped>
.navy-600 { background-color: #1e3a8a; }
.navy-700 { background-color: #1d4ed8; }
.navy-800 { background-color: #1e40af; }
.navy-900 { background-color: #1f2937; }
.navy-100 { background-color: #dbeafe; }
.navy-500 { color: #3b82f6; }
</style>