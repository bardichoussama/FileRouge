<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-purple-600/20 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-indigo-400/20 to-pink-600/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-cyan-400/10 to-blue-600/10 rounded-full blur-2xl animate-pulse delay-500"></div>
    </div>

    <div class="relative z-10 px-6 py-12 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <!-- Enhanced Header Section -->
        <div class="text-center mb-16 space-y-6">
          <div class="relative inline-block">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full blur opacity-75 animate-pulse"></div>
            <div class="relative inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-2xl">
              <i class="pi pi-check-circle text-white text-4xl"></i>
            </div>
          </div>
          <div class="space-y-4">
            <h1 class="text-5xl lg:text-6xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent">
              Daily Check-In
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
              Take a moment to reflect on your progress and share your thoughts with us
            </p>
            <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
              <i class="pi pi-calendar text-blue-500"></i>
              <span>{{ new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
            </div>
          </div>
        </div>

        <!-- Available Forms List -->
        <div v-if="!selectedForm">
          <!-- Loading State -->
          <div v-if="loading" class="space-y-8">
            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
              <div v-for="n in 6" :key="n" class="bg-white/70 backdrop-blur-sm rounded-3xl p-8 shadow-lg animate-pulse">
                <div class="flex items-center space-x-4 mb-6">
                  <div class="w-16 h-16 bg-gray-200 rounded-2xl"></div>
                  <div class="flex-1 space-y-3">
                    <div class="h-6 bg-gray-200 rounded-lg w-3/4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                  </div>
                </div>
                <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-else-if="availableForms.length === 0" class="text-center py-24">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-16 shadow-2xl max-w-2xl mx-auto">
              <div class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-8 shadow-inner">
                <i class="pi pi-calendar-times text-gray-400 text-5xl"></i>
              </div>
              <h3 class="text-3xl font-bold text-gray-900 mb-4">All Caught Up!</h3>
              <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                You're doing great! No check-in forms are available at the moment.
              </p>
              <button 
                @click="loadAvailableForms"
                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
              >
                <i class="pi pi-refresh mr-3"></i>
                Refresh Forms
              </button>
            </div>
          </div>

          <!-- Enhanced Forms Grid -->
          <div v-else class="space-y-8">
            <div class="text-center">
              <h2 class="text-2xl font-semibold text-gray-800 mb-2">Available Check-ins</h2>
              <p class="text-gray-600">Choose a form to get started</p>
            </div>
            
            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
              <div 
                v-for="form in availableForms" 
                :key="form.id" 
                @click="selectForm(form)"
                class="group cursor-pointer bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-white/50 hover:border-blue-200"
              >
                <!-- Card Header -->
                <div class="flex items-start justify-between mb-6">
                  <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                      <i class="pi pi-file-edit text-white text-2xl"></i>
                    </div>
                    <div>
                      <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-1">
                        {{ form.title }}
                      </h3>
                      <p class="text-sm text-gray-500 flex items-center">
                        <i class="pi pi-question-circle mr-1"></i>
                        {{ form.questions.length }} questions
                      </p>
                    </div>
                  </div>
                  <div class="flex flex-col items-end space-y-2">
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                      <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                      Active
                    </div>
                  </div>
                </div>

                <!-- Description -->
                <p class="text-gray-600 text-base mb-6 leading-relaxed line-clamp-3">
                  {{ form.description }}
                </p>

                <!-- Enhanced Footer -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                  <div class="flex items-center text-sm text-gray-500">
                    <i class="pi pi-clock mr-2 text-orange-500"></i>
                    <span class="font-medium">Due {{ formatDate(form.end_date) }}</span>
                  </div>
                  <div class="flex items-center text-blue-600 font-semibold">
                    <span class="mr-2">Start Now</span>
                    <i class="pi pi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Enhanced Selected Form -->
        <div v-if="selectedForm" class="space-y-8">
          <!-- Form Header -->
          <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-2xl border border-white/50">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-6">
                <button 
                  @click="goBack" 
                  class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 transition-all duration-200 group"
                >
                  <i class="pi pi-arrow-left group-hover:-translate-x-0.5 transition-transform"></i>
                </button>
                <div>
                  <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ selectedForm.title }}</h2>
                  <p class="text-lg text-gray-600">{{ selectedForm.description }}</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-sm font-medium text-gray-500 mb-1">Progress</div>
                <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                  {{ Math.round((Object.keys(answers).filter(k => answers[k]).length / selectedForm.questions.length) * 100) }}%
                </div>
                <div class="text-sm text-gray-500">Complete</div>
              </div>
            </div>
          </div>

          <!-- Enhanced Progress Bar -->
          <div class="relative">
            <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
              <div 
                class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 h-3 rounded-full transition-all duration-500 ease-out shadow-lg"
                :style="{ width: `${(Object.keys(answers).filter(k => answers[k]).length / selectedForm.questions.length) * 100}%` }"
              ></div>
            </div>
            <div class="flex justify-between mt-2 text-sm text-gray-500">
              <span>{{ Object.keys(answers).filter(k => answers[k]).length }} of {{ selectedForm.questions.length }} completed</span>
              <span>{{ selectedForm.questions.length - Object.keys(answers).filter(k => answers[k]).length }} remaining</span>
            </div>
          </div>

          <!-- Enhanced Questions Form -->
          <form @submit.prevent="submitAnswers" class="space-y-8">
            <div 
              v-for="(question, index) in selectedForm.questions" 
              :key="question.id"
              class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-white/50"
            >
              <div class="space-y-6">
                <!-- Question Header -->
                <div class="flex items-start space-x-6">
                  <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-lg">{{ index + 1 }}</span>
                  </div>
                  <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 leading-relaxed">{{ question.question_text }}</h3>
                    
                    <!-- Text Question -->
                    <div v-if="question.question_type === 'text'" class="space-y-3">
                      <textarea 
                        v-model="answers[question.id]" 
                        rows="5" 
                        placeholder="Share your thoughts in detail..."
                        class="w-full p-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-colors resize-none text-gray-700 bg-white/50"
                        :class="{ 'border-red-300 focus:border-red-500': errors[question.id] }"
                      ></textarea>
                    </div>
                    
                    <!-- Choice Question -->
                    <div v-else-if="question.question_type === 'choice'" class="space-y-3">
                      <select 
                        v-model="answers[question.id]" 
                        class="w-full p-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-colors text-gray-700 bg-white/50"
                        :class="{ 'border-red-300 focus:border-red-500': errors[question.id] }"
                      >
                        <option value="">Select your answer...</option>
                        <option v-for="option in getChoiceOptions(question)" :key="option" :value="option">
                          {{ option }}
                        </option>
                      </select>
                    </div>
                    
                    <!-- Rating Question -->
                    <div v-else-if="question.question_type === 'rating'" class="space-y-6">
                      <div class="flex items-center justify-between px-4">
                        <span class="text-sm font-medium text-gray-500">Poor</span>
                        <div class="flex space-x-2">
                          <button
                            v-for="star in 5"
                            :key="star"
                            type="button"
                            @click="answers[question.id] = star"
                            class="text-3xl transition-all duration-200 hover:scale-110"
                            :class="star <= (answers[question.id] || 0) ? 'text-yellow-400' : 'text-gray-300'"
                          >
                            ⭐
                          </button>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Excellent</span>
                      </div>
                      <div v-if="answers[question.id]" class="text-center">
                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border border-yellow-200">
                          <i class="pi pi-star-fill mr-2 text-yellow-600"></i>
                          {{ answers[question.id] }} out of 5 stars
                        </span>
                      </div>
                    </div>
                    
                    <!-- Error Message -->
                    <div v-if="errors[question.id]" class="flex items-center space-x-3 text-red-600 bg-red-50 p-4 rounded-2xl border border-red-200">
                      <i class="pi pi-exclamation-triangle text-red-500"></i>
                      <span class="font-medium">{{ errors[question.id] }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Enhanced Submit Section -->
            <div class="bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 rounded-3xl p-12 shadow-2xl border border-white/50">
              <div class="text-center space-y-8">
                <div class="flex items-center justify-center space-x-3 text-gray-600">
                  <i class="pi pi-info-circle text-blue-500 text-xl"></i>
                  <span class="text-lg font-medium">Please review your answers before submitting</span>
                </div>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                  <button 
                    type="submit" 
                    :disabled="submitting"
                    class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <i class="pi pi-check mr-3 text-xl" :class="{ 'pi-spin pi-spinner': submitting }"></i>
                    {{ submitting ? 'Submitting...' : 'Submit Check-In' }}
                  </button>
                  <button 
                    type="button"
                    @click="goBack" 
                    class="inline-flex items-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-2xl shadow-lg hover:shadow-xl border-2 border-gray-200 hover:border-gray-300 transform hover:scale-105 transition-all duration-200"
                  >
                    <i class="pi pi-save mr-3"></i>
                    Save Draft
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useToast } from 'primevue/usetoast'

import { getAvailableFormsForStudent, getFormWithQuestions } from '@/modules/EntretienIndividuel.module/service/CheckinForm.service'
import { submitCheckin } from '@/modules/EntretienIndividuel.module/service/StudentCheckin.service'

const toast = useToast()

const loading = ref(false)
const submitting = ref(false)
const availableForms = ref([])
const selectedForm = ref(null)
const answers = ref({})
const errors = ref({})

const getUserId = () => {
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  return user.id || 23
}

const loadAvailableForms = async () => {
  loading.value = true
  try {
    const userId = getUserId()
    const response = await getAvailableFormsForStudent(userId)
    availableForms.value = response.data
  } catch (error) {
    toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to load forms', life: 5000 })
  } finally {
    loading.value = false
  }
}

const selectForm = async (form) => {
  try {
    const response = await getFormWithQuestions(form.id)
    selectedForm.value = response.data
    
    selectedForm.value.questions.forEach(q => {
      answers.value[q.id] = q.question_type === 'rating' ? 0 : ''
    })
  } catch (error) {
    toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to load form', life: 5000 })
  }
}

const validateAnswers = () => {
  errors.value = {}
  let isValid = true
  
  selectedForm.value.questions.forEach(question => {
    if (!answers.value[question.id] || 
        (question.question_type === 'rating' && answers.value[question.id] === 0)) {
      errors.value[question.id] = 'This field is required'
      isValid = false
    }
  })
  
  return isValid
}

const submitAnswers = async () => {
  if (!validateAnswers()) {
    toast.add({ 
      severity: 'warn', 
      summary: 'Incomplete Form', 
      detail: 'Please answer all questions before submitting', 
      life: 5000 
    })
    return
  }
  
  submitting.value = true
  try {
    const payload = {
      checkin_form_id: selectedForm.value.id,
      answers: Object.entries(answers.value).map(([questionId, answerText]) => ({
        question_id: parseInt(questionId),
        answer_text: answerText.toString()
      }))
    }
    
    await submitCheckin(payload)
    toast.add({ 
      severity: 'success', 
      summary: 'Success!', 
      detail: 'Your check-in has been submitted successfully', 
      life: 5000 
    })
    goBack()
    loadAvailableForms()
  } catch (error) {
    toast.add({ 
      severity: 'error', 
      summary: 'Submission Failed', 
      detail: 'Failed to submit your check-in. Please try again.', 
      life: 5000 
    })
  } finally {
    submitting.value = false
  }
}

const goBack = () => {
  selectedForm.value = null
  answers.value = {}
  errors.value = {}
}

const getChoiceOptions = (question) => {
  return ['Excellent', 'Good', 'Average', 'Poor', 'Very Poor']
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric' 
  })
}

onMounted(() => {
  loadAvailableForms()
})
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}
</style>