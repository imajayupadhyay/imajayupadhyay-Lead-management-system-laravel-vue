<template>
    <div class="min-h-screen bg-navy-gradient-light">
        <!-- Header -->
        <div class="header-navy py-8 shadow-lg">
            <div class="container mx-auto px-4 text-center">
                <div class="inline-flex items-center bg-white px-8 py-3 rounded-full shadow-lg mb-4">
                    <h1 class="text-2xl font-bold text-navy-800">Enquiry Form</h1>
                </div>
                <p class="text-white text-lg">It helps us find the best course for you</p>
            </div>
        </div>

        <!-- Form Container -->
        <div class="container mx-auto px-4 py-8 max-w-5xl">
            <form @submit.prevent="submitForm" class="card-navy p-8 space-y-8">
                
                <!-- Success/Error Messages -->
                <div v-if="successMessage" class="alert-success-navy">
                    {{ successMessage }}
                </div>
                <div v-if="errorMessage" class="alert-error-navy">
                    {{ errorMessage }}
                </div>

                <!-- Section 1: Date -->
                <div class="form-section">
                    <div class="w-full md:w-80">
                        <label class="form-label-navy">Date: <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input
                                v-model="form.date"
                                type="date"
                                class="form-input-navy w-full"
                                required
                            />
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <span class="text-gray-400">____/____/_______</span>
                            </div>
                        </div>
                        <div v-if="errors.date" class="text-red-500 text-sm mt-1">{{ errors.date }}</div>
                    </div>
                </div>

                <!-- Section 2: Student Info Row -->
                <div class="form-section">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                        <!-- Student Name -->
                        <div class="lg:col-span-6">
                            <label class="form-label-navy">Student's Name: <span class="text-red-500">*</span></label>
                            <input
                                v-model="form.student_name"
                                type="text"
                                class="form-input-navy w-full"
                                placeholder=""
                                required
                            />
                            <div v-if="errors.student_name" class="text-red-500 text-sm mt-1">{{ errors.student_name }}</div>
                        </div>
                        
                        <!-- Gender -->
                        <div class="lg:col-span-3">
                            <label class="form-label-navy">Gender</label>
                            <select v-model="form.gender" class="form-input-navy w-full">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Trans">Trans</option>
                            </select>
                        </div>
                        
                        <!-- Age -->
                        <div class="lg:col-span-3">
                            <label class="form-label-navy">Age</label>
                            <div class="border border-gray-400 px-4 py-3 w-20 bg-white inline-block">
                                <input
                                    v-model="form.age"
                                    type="number"
                                    min="15"
                                    max="50"
                                    class="w-full border-none outline-none text-center bg-transparent"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Contact Info -->
                <div class="form-section space-y-4">
                    <!-- Mobile Number -->
                    <div>
                        <label class="form-label-navy">Mob. No.: <span class="text-red-500">*</span></label>
                        <input
                            v-model="form.mobile_number"
                            type="tel"
                            class="form-input-navy w-full"
                            required
                        />
                        <div v-if="errors.mobile_number" class="text-red-500 text-sm mt-1">{{ errors.mobile_number }}</div>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="form-label-navy">Email:</label>
                        <input
                            v-model="form.email"
                            type="email"
                            class="form-input-navy w-full"
                        />
                        <div v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</div>
                    </div>
                </div>

                <!-- Section 4: Address -->
                <div class="form-section space-y-4">
                    <div>
                        <label class="form-label-navy">Address: <span class="text-red-500">*</span></label>
                        <textarea
                            v-model="form.address"
                            rows="2"
                            class="form-input-navy w-full resize-none"
                            required
                        ></textarea>
                        <div v-if="errors.address" class="text-red-500 text-sm mt-1">{{ errors.address }}</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                        <div>
                            <span class="form-label-navy inline-block w-16">Pin:</span>
                            <input
                                v-model="form.pin_code"
                                type="text"
                                maxlength="6"
                                class="form-input-navy flex-1 ml-4"
                                style="width: calc(100% - 5rem);"
                                required
                            />
                            <div v-if="errors.pin_code" class="text-red-500 text-sm mt-1">{{ errors.pin_code }}</div>
                        </div>
                        
                        <div>
                            <span class="form-label-navy inline-block w-16">State:</span>
                            <input
                                v-model="form.state"
                                type="text"
                                class="form-input-navy flex-1 ml-4"
                                style="width: calc(100% - 5rem);"
                                required
                            />
                            <div v-if="errors.state" class="text-red-500 text-sm mt-1">{{ errors.state }}</div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Academic Info -->
                <div class="form-section">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                        <div>
                            <span class="form-label-navy inline-block">Qualification:</span>
                            <input
                                v-model="form.qualification"
                                type="text"
                                class="form-input-navy flex-1 ml-4"
                                style="width: calc(100% - 8rem);"
                                required
                            />
                            <div v-if="errors.qualification" class="text-red-500 text-sm mt-1">{{ errors.qualification }}</div>
                        </div>
                        
                        <div>
                            <span class="form-label-navy inline-block">College:</span>
                            <input
                                v-model="form.college"
                                type="text"
                                class="form-input-navy flex-1 ml-4"
                                style="width: calc(100% - 6rem);"
                            />
                        </div>
                    </div>
                </div>

                <!-- Section 6: Visit Info -->
                <div class="form-section space-y-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="form-label-navy">Visited with:</span>
                        
                        <!-- Self Checkbox -->
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-2 bg-white">
                                <input
                                    v-model="form.visited_with"
                                    type="radio"
                                    value="Self"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            Self
                        </label>
                        
                        <!-- Parent/Friend Checkbox -->
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-2 bg-white">
                                <input
                                    v-model="form.visited_with"
                                    type="radio"
                                    value="Parent/Friend"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            Parent/Friend (Specify)
                        </label>
                        
                        <input
                            v-if="form.visited_with === 'Parent/Friend'"
                            v-model="form.parent_friend_specify"
                            type="text"
                            class="form-input-navy flex-1 min-w-48"
                        />
                    </div>
                    
                    <!-- Parent Occupation -->
                    <div class="mt-4">
                        <span class="form-label-navy inline-block">Parent's Occupation</span>
                        <input
                            v-model="form.parent_occupation"
                            type="text"
                            class="form-input-navy flex-1 ml-4"
                            style="width: calc(100% - 10rem);"
                        />
                    </div>
                </div>

                <!-- Section 7: Course Interest -->
                <div class="form-section border border-gray-300 p-6 bg-white rounded">
                    <div class="mb-4">
                        <span class="form-label-navy text-lg">Interested in:</span>
                        <span class="text-gray-600 text-sm ml-2">(Take our Counsellor's Help for your best fit)</span>
                    </div>
                    
                    <!-- Course Types Row 1 -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                <input
                                    v-model="form.interested_in"
                                    type="checkbox"
                                    value="GS Foundation"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            GS Foundation
                        </label>
                        
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                <input
                                    v-model="form.interested_in"
                                    type="checkbox"
                                    value="1-Year"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            1-Year
                        </label>
                        
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                <input
                                    v-model="form.interested_in"
                                    type="checkbox"
                                    value="2-Year"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            2-Year
                        </label>
                        
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                <input
                                    v-model="form.interested_in"
                                    type="checkbox"
                                    value="3-Year"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            3-Year
                        </label>
                    </div>

                    <!-- Language Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                <input
                                    v-model="form.course_languages"
                                    type="checkbox"
                                    value="Bilingual"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            Bilingual
                        </label>
                        
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                <input
                                    v-model="form.course_languages"
                                    type="checkbox"
                                    value="English"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            English
                        </label>
                        
                        <label class="flex items-center">
                            <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                <input
                                    v-model="form.course_languages"
                                    type="checkbox"
                                    value="Hindi"
                                    class="checkbox-navy w-full h-full"
                                />
                            </div>
                            Hindi
                        </label>
                    </div>

                    <!-- Type Details -->
                    <div class="mb-6">
                        <input
                            v-model="form.course_type_details"
                            type="text"
                            class="form-input-navy w-full"
                            placeholder="(Type - NCERT/A-125/S-50)"
                        />
                    </div>

                    <!-- GS Module and Optional Row -->
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                    <input
                                        type="checkbox"
                                        class="checkbox-navy w-full h-full"
                                    />
                                </div>
                                GS Module
                            </label>
                            <input
                                v-model="form.gs_module"
                                type="text"
                                class="form-input-navy flex-1"
                                placeholder="(CSAT/Essay/Ethics etc.)"
                            />
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <div class="checkbox-container border border-gray-400 w-5 h-5 mr-3 bg-white">
                                    <input
                                        type="checkbox"
                                        class="checkbox-navy w-full h-full"
                                    />
                                </div>
                                Optional
                            </label>
                            <input
                                v-model="form.optional_subject"
                                type="text"
                                class="form-input-navy flex-1"
                                placeholder="(Specify Subject)"
                            />
                        </div>
                    </div>

                    <!-- Bottom Row: Other Query and Target Year -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                        <div>
                            <textarea
                                v-model="form.other_query"
                                class="form-input-navy w-full resize-none"
                                placeholder="(Any other Query)"
                                rows="3"
                            ></textarea>
                        </div>
                        <div class="text-right">
                            <span class="form-label-navy inline-block mr-4">Target Year</span>
                            <div class="border border-gray-400 px-4 py-3 w-24 bg-white inline-block">
                                <input
                                    v-model="form.target_year"
                                    type="text"
                                    class="w-full border-none outline-none text-center bg-transparent"
                                    placeholder=""
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 8: Office Use Only -->
                <div class="form-section border-2 border-dashed border-gray-400 rounded-lg p-6 bg-gray-50">
                    <div class="text-center mb-4">
                        <span class="bg-white px-4 py-1 border border-gray-400 rounded-full font-bold text-gray-700">
                            For Office Use Only
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="flex items-center gap-4">
                            <span class="form-label-navy">Enquiry By:</span>
                            <select v-model="form.marketer_id" class="form-input-navy flex-1">
                                <option value="">Select Marketer</option>
                                <option v-for="marketer in marketers" :key="marketer.id" :value="marketer.id">
                                    {{ marketer.name }}{{ marketer.designation ? ` (${marketer.designation})` : '' }}
                                </option>
                            </select>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <span class="form-label-navy">Counsellor:</span>
                            <select v-model="form.counselor_id" class="form-input-navy flex-1">
                                <option value="">Select Counsellor</option>
                                <option v-for="counselor in counselors" :key="counselor.id" :value="counselor.id">
                                    {{ counselor.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-8">
                        <div class="flex items-center gap-2">
                            <span class="form-label-navy">Visited Class</span>
                            <div class="w-6 h-6 border border-gray-400 rounded-full bg-white flex items-center justify-center">
                                <input
                                    v-model="form.visited_class"
                                    type="checkbox"
                                    class="checkbox-navy"
                                />
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span class="form-label-navy">Demo Attended</span>
                            <div class="w-6 h-6 border border-gray-400 rounded-full bg-white flex items-center justify-center">
                                <input
                                    v-model="form.demo_attended"
                                    type="checkbox"
                                    class="checkbox-navy"
                                />
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <span class="form-label-navy">Faculty:</span>
                            <select v-model="form.faculty_id" class="form-input-navy">
                                <option value="">Select</option>
                                <option v-for="faculty in faculties" :key="faculty.id" :value="faculty.id">
                                    {{ faculty.name }} {{ faculty.subject ? `(${faculty.subject})` : '' }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-6">
                    <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="btn-navy-gradient px-12 py-4 rounded-lg text-lg font-bold transition duration-200 disabled:opacity-50"
                    >
                        <span v-if="isSubmitting">Submitting...</span>
                        <span v-else>Submit Enquiry</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    counselors: {
        type: Array,
        default: () => []
    },
    faculty: {
        type: Array,
        default: () => []
    },
    marketers: {
        type: Array,
        default: () => []
    },
    errors: {
        type: Object,
        default: () => ({})
    },
})

const faculties = props.faculty

const isSubmitting = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const form = reactive({
    date: new Date().toISOString().split('T')[0],
    student_name: '',
    gender: '',
    age: '',
    mobile_number: '',
    email: '',
    address: '',
    pin_code: '',
    state: '',
    qualification: '',
    college: '',
    visited_with: 'Self',
    parent_friend_specify: '',
    parent_occupation: '',
    interested_in: [],
    course_languages: [], // Changed from course_language to array
    course_type_details: '',
    gs_module: '',
    optional_subject: '',
    other_query: '',
    target_year: '',
    enquiry_by: '',
    marketer_id: '',
    counselor_id: '',
    visited_class: false,
    demo_attended: false,
    faculty_id: '',
})

const submitForm = () => {
    isSubmitting.value = true
    errorMessage.value = ''
    successMessage.value = ''

    // Prepare data for submission
    const submitData = {
        ...form,
        course_language: form.course_languages.join(','), // Convert array to comma-separated string
        visited_class: form.visited_class ? 1 : 0,
        demo_attended: form.demo_attended ? 1 : 0,
        counselor_id: form.counselor_id || null,
        faculty_id: form.faculty_id || null,
        marketer_id: form.marketer_id || null
    }

    // Remove the course_languages field as we're sending course_language instead
    delete submitData.course_languages

    console.log('Submitting data:', submitData)

    router.post('/enquiry', submitData, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            successMessage.value = 'Your enquiry has been submitted successfully!'
            // Don't reset form immediately on success to let user see the message
            setTimeout(() => {
                resetForm()
            }, 3000)
        },
        onError: (errors) => {
            console.log('Form errors:', errors)
            errorMessage.value = 'Please check the form for errors and try again.'
            
            // Log detailed error information
            Object.keys(errors).forEach(key => {
                console.log(`${key}: ${errors[key]}`)
            })
        },
        onFinish: () => {
            isSubmitting.value = false
        }
    })
}

const resetForm = () => {
    Object.keys(form).forEach(key => {
        if (Array.isArray(form[key])) {
            form[key] = []
        } else if (typeof form[key] === 'boolean') {
            form[key] = false
        } else {
            form[key] = key === 'date' ? new Date().toISOString().split('T')[0] : ''
        }
    })
    form.visited_with = 'Self'
    form.course_languages = []
    form.marketer_id = ''
    form.counselor_id = ''
    form.faculty_id = ''
}
</script>

<style scoped>
.form-section {
    @apply space-y-2;
}

.checkbox-container {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.checkbox-container input[type="checkbox"],
.checkbox-container input[type="radio"] {
    appearance: none;
    -webkit-appearance: none;
    margin: 0;
}

.checkbox-container input[type="checkbox"]:checked::after {
    content: '✓';
    position: absolute;
    color: #334155;
    font-size: 14px;
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.checkbox-container input[type="radio"]:checked::after {
    content: '●';
    position: absolute;
    color: #334155;
    font-size: 12px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>