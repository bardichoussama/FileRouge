<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Enhanced Header -->
      <div class="mb-12">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent">
              My Wellness Journey
            </h1>
            <p class="text-lg text-gray-600 mt-3 max-w-2xl">
              Track your progress and reflect on your completed wellness check-ins
            </p>
          </div>
          <div class="hidden md:flex items-center space-x-4">
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 border border-white/20 shadow-lg">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center">
                  <i class="pi pi-check text-white text-lg"></i>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ submissions.length }}</p>
                  <p class="text-xs text-gray-500">Check-ins</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="relative">
          <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-200"></div>
          <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-600 border-t-transparent absolute top-0"></div>
        </div>
        <p class="mt-4 text-gray-600 animate-pulse">Loading your wellness journey...</p>
      </div>

      <!-- Enhanced Empty State -->
      <div v-else-if="!submissions.length" class="text-center py-20">
        <div class="relative mx-auto mb-8 w-32 h-32">
          <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 rounded-full"></div>
          <div class="absolute inset-2 bg-white rounded-full flex items-center justify-center">
            <i class="pi pi-heart text-4xl text-transparent bg-gradient-to-br from-blue-500 to-indigo-600 bg-clip-text"></i>
          </div>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">Begin Your Wellness Journey</h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
          Start tracking your mental health and wellbeing with your first check-in
        </p>
        <Button label="Complete Your First Check-In" 
                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5" 
                icon="pi pi-plus" />
      </div>

      <!-- Enhanced Submissions List -->
      <div v-else class="space-y-6">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-600">Total Check-ins</p>
                <p class="text-3xl font-bold text-gray-900">{{ submissions.length }}</p>
              </div>
              <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <i class="pi pi-chart-line text-white text-xl"></i>
              </div>
            </div>
          </div>
          
          <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-600">This Month</p>
                <p class="text-3xl font-bold text-gray-900">{{ getThisMonthCount() }}</p>
              </div>
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <i class="pi pi-calendar text-white text-xl"></i>
              </div>
            </div>
          </div>
          
          <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg hover:shadow-xl transition-all duration-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-medium text-gray-600">Last Check-in</p>
                <p class="text-lg font-semibold text-gray-900">{{ getLastCheckinDate() }}</p>
              </div>
              <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                <i class="pi pi-clock text-white text-xl"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Filter/Sort Options -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
          <div class="flex items-center space-x-3">
            <h2 class="text-xl font-semibold text-gray-900">Your Check-ins</h2>
            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
              {{ submissions.length }} total
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <Button label="Export" 
                    icon="pi pi-download" 
                    text 
                    class="text-gray-600 hover:text-gray-800 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors" />
          </div>
        </div>

        <!-- Submissions Cards -->
        <div class="grid gap-6">
          <div v-for="(submission, index) in submissions" :key="submission.id"
               class="group bg-white/80 backdrop-blur-sm rounded-2xl border border-white/20 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            
            <!-- Submission Header -->
            <div class="p-8 border-b border-gray-100/50">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center space-x-4 mb-3">
                    <div class="flex items-center space-x-3">
                      <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold">
                        {{ index + 1 }}
                      </div>
                      <h3 class="text-2xl font-bold text-gray-900">{{ submission.checkin_form.title }}</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                      <span class="bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 text-sm px-3 py-1 rounded-full flex items-center font-medium">
                        <i class="pi pi-check text-xs mr-1.5"></i>
                        Completed
                      </span>
                    </div>
                  </div>
                  <p class="text-gray-600 mb-4 text-lg">{{ submission.checkin_form.description }}</p>
                  <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500">
                    <span class="flex items-center bg-gray-50 px-3 py-1.5 rounded-lg">
                      <i class="pi pi-calendar mr-2 text-blue-500"></i>
                      {{ formatDate(submission.created_at) }}
                    </span>
                    <span class="flex items-center bg-gray-50 px-3 py-1.5 rounded-lg">
                      <i class="pi pi-list mr-2 text-indigo-500"></i>
                      {{ submission.answers.length }} responses
                    </span>
                    <span class="flex items-center bg-gray-50 px-3 py-1.5 rounded-lg">
                      <i class="pi pi-clock mr-2 text-purple-500"></i>
                      {{ getTimeAgo(submission.created_at) }}
                    </span>
                  </div>
                </div>
                
                <Button :icon="expandedSubmissions.includes(submission.id) ? 'pi pi-chevron-up' : 'pi pi-chevron-down'"
                        text rounded size="large"
                        @click="toggleDetails(submission.id)"
                        class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-12 h-12 transition-colors" />
              </div>
            </div>

            <!-- Enhanced Expanded Details -->
            <Transition name="slide-down">
              <div v-if="expandedSubmissions.includes(submission.id)" class="p-8 bg-gradient-to-br from-gray-50 to-blue-50/30">
                <h4 class="font-bold text-xl text-gray-900 mb-6 flex items-center">
                  <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="pi pi-comment text-white text-sm"></i>
                  </div>
                  Your Responses
                </h4>
                
                <div class="grid gap-6">
                  <div v-for="(answer, answerIndex) in submission.answers" :key="answer.id"
                       class="bg-white rounded-xl p-6 border border-gray-200/50 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start space-x-4">
                      <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                        <span class="text-sm font-bold text-blue-700">{{ answerIndex + 1 }}</span>
                      </div>
                      <div class="flex-1">
                        <p class="font-semibold text-gray-900 mb-3 text-lg">{{ answer.question.question_text }}</p>
                        <div class="text-gray-700">
                          <div v-if="answer.question.question_type === 'rating'" class="flex items-center space-x-3">
                            <Rating :model-value="parseInt(answer.answer_text)" readonly :cancel="false" class="text-yellow-400" />
                            <span class="text-lg font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-lg">
                              {{ answer.answer_text }}/5
                            </span>
                          </div>
                          <div v-else-if="answer.question.question_type === 'choice'" 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 font-medium rounded-xl">
                            <i class="pi pi-check-circle mr-2"></i>
                            {{ answer.answer_text }}
                          </div>
                          <div v-else class="bg-gradient-to-br from-gray-50 to-blue-50/50 rounded-xl p-4 border border-gray-200/50">
                            <p class="text-gray-800 leading-relaxed">{{ answer.answer_text }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </Transition>
          </div>
        </div>

        <!-- Enhanced Load More Button -->
        <div v-if="submissions.length >= 10" class="text-center pt-8">
          <Button label="Load More Check-ins" 
                  text 
                  class="text-blue-600 hover:text-blue-700 hover:bg-blue-50 px-6 py-3 rounded-xl font-semibold transition-colors" 
                  icon="pi pi-refresh" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useToast } from 'primevue/usetoast'
import Button from 'primevue/button'
import Rating from 'primevue/rating'

import { getMyCheckins } from '@/modules/EntretienIndividuel.module/service/StudentCheckin.service'

const toast = useToast()
const loading = ref(false)
const submissions = ref([])
const expandedSubmissions = ref([])

const loadSubmissions = async () => {
  loading.value = true
  try {
    const response = await getMyCheckins()
    submissions.value = response.data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
  } catch (error) {
    toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to load submissions' })
  } finally {
    loading.value = false
  }
}

const toggleDetails = (submissionId) => {
  const index = expandedSubmissions.value.indexOf(submissionId)
  if (index > -1) {
    expandedSubmissions.value.splice(index, 1)
  } else {
    expandedSubmissions.value.push(submissionId)
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getTimeAgo = (dateString) => {
  const now = new Date()
  const date = new Date(dateString)
  const diffInDays = Math.floor((now - date) / (1000 * 60 * 60 * 24))
  
  if (diffInDays === 0) return 'Today'
  if (diffInDays === 1) return 'Yesterday'
  if (diffInDays < 7) return `${diffInDays} days ago`
  if (diffInDays < 30) return `${Math.floor(diffInDays / 7)} weeks ago`
  return `${Math.floor(diffInDays / 30)} months ago`
}

const getThisMonthCount = () => {
  const now = new Date()
  const thisMonth = submissions.value.filter(submission => {
    const date = new Date(submission.created_at)
    return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear()
  })
  return thisMonth.length
}

const getLastCheckinDate = () => {
  if (submissions.value.length === 0) return 'Never'
  return getTimeAgo(submissions.value[0].created_at)
}

onMounted(loadSubmissions)
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  overflow: hidden;
}

.slide-down-enter-from,
.slide-down-leave-to {
  max-height: 0;
  opacity: 0;
  transform: translateY(-10px);
}

.slide-down-enter-to,
.slide-down-leave-from {
  max-height: 2000px;
  opacity: 1;
  transform: translateY(0);
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #3b82f6, #6366f1);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #2563eb, #4f46e5);
}
</style>