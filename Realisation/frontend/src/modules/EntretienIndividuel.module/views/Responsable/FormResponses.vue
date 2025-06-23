<template>
    <div class="p-6 bg-gray-50 min-h-screen">
      <!-- Header -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm">
        <div class="flex items-center gap-3">
          <Button 
            icon="pi pi-arrow-left" 
            outlined 
            @click="goBack"
            class="rounded-lg"
          />
          <div>
            <h1 class="text-2xl font-bold text-gray-800">Form Responses</h1>
            <p class="text-gray-600 text-sm" v-if="form">{{ form.title }}</p>
          </div>
        </div>
        
        <Button 
          label="Generate AI Analysis" 
          icon="pi pi-sparkles" 
          :loading="analyzingLoading"
          :disabled="!form || responses.length === 0"
          @click="generateAnalysis"
          severity="help"
          class="rounded-lg font-medium"
        />
      </div>
  
      <!-- Loading State -->
      <div v-if="loading" class="bg-white p-6 rounded-lg shadow-sm">
        <Skeleton height="4rem" class="mb-4"></Skeleton>
        <Skeleton height="20rem"></Skeleton>
      </div>
  
      <!-- Main Content -->
      <Card v-else class="shadow-lg border-0 rounded-lg">
        <template #content>
          <TabView>
            
            <!-- Student Responses Tab -->
            <TabPanel header="Student Responses">
              <!-- Empty State -->
              <div v-if="responses.length === 0" class="text-center py-12">
                <div class="text-6xl text-gray-300 mb-4">
                  <i class="pi pi-users"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Responses Yet</h3>
                <p class="text-gray-500 max-w-md mx-auto">Students haven't submitted their responses for this form yet.</p>
              </div>
              
              <!-- Responses Grid -->
              <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                <div 
                  v-for="response in responses" 
                  :key="response.id"
                  class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-blue-300 transition-all duration-300 cursor-pointer"
                  @click="viewStudentResponse(response.id)"
                >
                  <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                      <h4 class="font-bold text-gray-900 text-lg mb-2">{{ response.student_name }}</h4>
                      <div class="space-y-1">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                          <i class="pi pi-users text-blue-500"></i>
                          <span class="font-medium">{{ response.group_name }}</span>
                          <span v-if="response.promotion_year" class="text-gray-400">• {{ response.promotion_year }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                          <i class="pi pi-calendar text-green-500"></i>
                          <span>{{ formatDate(response.submitted_at) }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="bg-blue-50 p-2 rounded-lg">
                      <i class="pi pi-eye text-blue-600"></i>
                    </div>
                  </div>
                  
                  <div class="border-t border-gray-100 pt-3">
                    <span class="text-xs text-gray-500 uppercase tracking-wide font-medium">Click to view responses</span>
                  </div>
                </div>
              </div>
            </TabPanel>
  
            <!-- AI Insights Tab -->
            <TabPanel header="AI Insights">
              <!-- Empty State -->
              <div v-if="insights.length === 0" class="text-center py-12">
                <div class="text-6xl text-yellow-400 mb-4">
                  <i class="pi pi-lightbulb"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No AI Insights Yet</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6">Generate AI analysis to get intelligent insights about student responses.</p>
                <Button 
                  label="Generate Analysis" 
                  icon="pi pi-sparkles" 
                  @click="generateAnalysis"
                  :loading="analyzingLoading"
                  :disabled="responses.length === 0"
                  severity="help"
                  class="font-medium"
                />
              </div>
              
              <!-- Insights List -->
              <div v-else class="space-y-4 mt-4">
                <div 
                  v-for="insight in insights" 
                  :key="insight.id"
                  class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200"
                >
                  <div class="flex justify-between items-start mb-3">
                    <div>
                      <h4 class="font-semibold text-gray-800 mb-1">{{ insight.student_name }}</h4>
                      <div class="flex items-center gap-2 mb-1">
                        <Badge :value="insight.group_name" severity="info" />
                      </div>
                      <p class="text-sm text-gray-500">{{ formatDate(insight.created_at) }}</p>
                    </div>
                    <Badge :value="insight.type" severity="success" />
                  </div>
                  
                  <div class="bg-white bg-opacity-60 rounded-md p-3">
                    <p class="text-gray-700 leading-relaxed">{{ insight.insight_text }}</p>
                  </div>
                </div>
              </div>
            </TabPanel>
            
          </TabView>
        </template>
      </Card>
  
      <!-- Student Answers Modal -->
      <Dialog 
        v-model:visible="answerDialogVisible" 
        :header="`Responses from ${selectedStudent}`"
        class="w-full max-w-5xl"
        :breakpoints="{ '768px': '95vw' }"
        modal
      >
        <div v-if="selectedAnswers.length > 0" class="space-y-6">
          <div 
            v-for="(answer, index) in selectedAnswers" 
            :key="answer.question_id"
            class="bg-gray-50 rounded-xl p-6 border border-gray-200"
          >
            <!-- Question -->
            <div class="mb-4">
              <div class="flex items-start gap-3 mb-2">
                <div class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                  {{ index + 1 }}
                </div>
                <div class="flex-1">
                  <h5 class="font-semibold text-gray-800 text-base leading-relaxed">{{ answer.question_text }}</h5>
                </div>
              </div>
            </div>
            
            <!-- Answer -->
            <div class="bg-white rounded-lg p-4 border-l-4 border-l-green-400">
              <div class="flex items-start gap-3">
                <div class="bg-green-100 p-2 rounded-full">
                  <i class="pi pi-comment text-green-600"></i>
                </div>
                <div class="flex-1">
                  <p class="text-gray-800 leading-relaxed">{{ answer.answer_text }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div v-else class="text-center py-12">
          <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <i class="pi pi-info-circle text-gray-400 text-2xl"></i>
          </div>
          <h3 class="text-lg font-semibold text-gray-700 mb-2">No Responses Found</h3>
          <p class="text-gray-500">This student hasn't submitted any answers yet.</p>
        </div>
      </Dialog>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import { useToast } from 'primevue/usetoast';
  import { getCheckinFormById, getFormResponsesWithStudents } from '@/modules/EntretienIndividuel.module/service/CheckinForm.service';
  import { analyzeCheckinForm } from '@/modules/EntretienIndividuel.module/service/AIInsights.service';
  
  // PrimeVue Components
  import Button from 'primevue/button';
  import Card from 'primevue/card';
  import TabView from 'primevue/tabview';
  import TabPanel from 'primevue/tabpanel';
  import Badge from 'primevue/badge';
  import Dialog from 'primevue/dialog';
  import Skeleton from 'primevue/skeleton';
  
  // Composables
  const route = useRoute();
  const router = useRouter();
  const toast = useToast();
  
  // Reactive Data
  const form = ref(null);
  const responses = ref([]);
  const insights = ref([]);
  const loading = ref(true);
  const analyzingLoading = ref(false);
  
  // Dialog State
  const answerDialogVisible = ref(false);
  const selectedAnswers = ref([]);
  const selectedStudent = ref('');
  
  // Load data when component mounts
  onMounted(async () => {
    await loadFormData();
  });
  
  // Main data loading function
  async function loadFormData() {
    loading.value = true;
    try {
      const formId = route.params.formId;
      // Load form details
      const formResponse = await getCheckinFormById(formId);
      form.value = formResponse.data;
      // Load responses and insights
      const responsesData = await getFormResponsesWithStudents(formId);
      const data = responsesData?.data?.data || responsesData?.data;
      // Normalize items array from API
      const items = (data?.student_checkins && Array.isArray(data.student_checkins))
        ? data.student_checkins
        : Array.isArray(data)
          ? data
          : [];
      // Map responses with correct group fields
      responses.value = items.map(item => ({
        id: item.id,
        student_id: item.student_id,
        student_name: item.student?.name || item.student_name || 'Unknown Student',
        student_email: item.student_email || item.student?.email || '',
        group_name: item.student_group || item.group_name || 'No Group',
        promotion_year: item.student_promotion?.toString() || item.promotion_year || '',
        submitted_at: item.submitted_at || item.created_at,
        answers: item.answers || []
      }));
      // Flatten and map insights
      insights.value = items.flatMap(item =>
        (item.insights || item.ai_insights || []).map(insight => ({
          id: insight.id,
          student_name: insight.student_name || item.student_name || item.student?.name || 'Unknown Student',
          group_name: item.student_group || item.group_name || 'No Group',
          promotion_year: item.student_promotion?.toString() || item.promotion_year || '',
          type: insight.type,
          insight_text: insight.insight_text,
          created_at: insight.created_at
        }))
      );
    } catch (error) {
      showError('Failed to load form data');
      responses.value = [];
      insights.value = [];
    } finally {
      loading.value = false;
    }
  }
  
  // Generate AI analysis
  async function generateAnalysis() {
    if (!form.value?.id || responses.value.length === 0) {
      showError('No data available for analysis');
      return;
    }
  
    analyzingLoading.value = true;
    
    try {
      await analyzeCheckinForm(form.value.id);
      await loadFormData(); // Reload to get new insights
      
      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: 'AI analysis completed successfully',
        life: 3000
      });
    } catch (error) {
      showError('Failed to generate AI analysis');
    } finally {
      analyzingLoading.value = false;
    }
  }
  
  // View individual student response
  function viewStudentResponse(responseId) {
    const response = responses.value.find(r => r.id === responseId);
    
    if (!response) {
      showError('Response not found');
      return;
    }
    
    selectedAnswers.value = response.answers || [];
    selectedStudent.value = response.student_name || 'Student';
    answerDialogVisible.value = true;
  }
  
  // Navigation
  function goBack() {
    router.back();
  }
  
  // Utilities
  function formatDate(dateString) {
    if (!dateString) return 'No date';
    
    try {
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    } catch {
      return 'Invalid date';
    }
  }
  
  function showError(message) {
    toast.add({
      severity: 'error',
      summary: 'Error',
      detail: message,
      life: 3000
    });
  }
  </script>
  
  <style scoped>
  /* Only minimal custom styles if needed */
  .space-y-4 > * + * {
    margin-top: 1rem;
  }
  </style>