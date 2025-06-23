<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from 'primevue/usetoast';
import { getCheckinFormById } from '@/modules/EntretienIndividuel.module/service/CheckinForm.service';
import { getQuestionsByFormId } from '@/modules/EntretienIndividuel.module/service/Question.service';

import Button from 'primevue/button';
import Card from 'primevue/card';
import Chip from 'primevue/chip';
import Divider from 'primevue/divider';
import Skeleton from 'primevue/skeleton';
import Badge from 'primevue/badge';
import Dialog from 'primevue/dialog';
import ProgressSpinner from 'primevue/progressspinner';

const route = useRoute();
const router = useRouter();
const toast = useToast();

const form = ref(null);
const questions = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
    await loadFormDetails();
});

async function loadFormDetails() {
    loading.value = true;
    error.value = null;
    
    try {
        const formId = route.params.id;
        
        const formResponse = await getCheckinFormById(formId);
        form.value = formResponse.data;
        
        const questionsResponse = await getQuestionsByFormId(formId);
        questions.value = questionsResponse.data;
        
        loading.value = false;
    } catch (err) {
        console.error('Error loading form details:', err);
        error.value = err.message || 'Failed to load form details';
        loading.value = false;
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to load form details',
            life: 3000
        });
    }
}


const questionTypeLabels = computed(() => ({
    'text': { label: 'Short Text', icon: 'pi-align-left', color: 'blue' },
    'textarea': { label: 'Long Text', icon: 'pi-align-justify', color: 'green' },
    'multiple_choice': { label: 'Multiple Choice', icon: 'pi-list', color: 'purple' },
    'rating': { label: 'Rating Scale', icon: 'pi-star', color: 'orange' },
    'boolean': { label: 'Yes/No', icon: 'pi-check-circle', color: 'teal' }
}));

function getQuestionTypeInfo(type) {
    return questionTypeLabels.value[type] || { label: type, icon: 'pi-question', color: 'gray' };
}

function formatDate(dateString) {
    if (!dateString) return '—';
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function goBack() {
    router.back();
}

function editForm() {
    router.push({ name: 'checkin-forms', query: { edit: form.value.id } });
}

function viewResponses() {
    router.push({ 
        name: 'form-responses', 
        params: { formId: form.value.id } 
    });
}

function getCreatorName(createdBy) {
    if (typeof createdBy === 'object' && createdBy?.name) {
        return createdBy.name;
    }
    return `User ID: ${createdBy}` || '—';
}
</script>

<template>
    <div class="checkin-form-details">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <Button 
                    icon="pi pi-arrow-left" 
                    outlined 
                    @click="goBack"
                    v-tooltip.bottom="'Go Back'"
                />
                <h1 class="text-2xl font-bold text-gray-800">Form Details</h1>
            </div>
            
            <div v-if="form" class="flex gap-2">
                <Button 
                    label="Edit" 
                    icon="pi pi-pencil" 
                    @click="editForm"
                />
                <Button 
                    label="View Responses" 
                    icon="pi pi-chart-bar" 
                    severity="secondary"
                    @click="viewResponses"
                />
                
            </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="space-y-4">
            <Card>
                <template #content>
                    <Skeleton height="2rem" class="mb-4"></Skeleton>
                    <Skeleton height="1rem" class="mb-2"></Skeleton>
                    <Skeleton height="1rem" width="70%"></Skeleton>
                </template>
            </Card>
        </div>

        <!-- Error State -->
        <Card v-else-if="error" class="text-center">
            <template #content>
                <i class="pi pi-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Error Loading Form</h3>
                <p class="text-gray-600 mb-4">{{ error }}</p>
                <Button label="Try Again" @click="loadFormDetails" />
            </template>
        </Card>

        <!-- Form Details -->
        <div v-else-if="form" class="space-y-6">
            <!-- Form Information Card -->
            <Card>
                <template #header>
                    <div class="p-6 pb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ form.title }}</h2>
                                <p class="text-gray-600" v-if="form.description">{{ form.description }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <Badge 
                                    :value="form.is_active ? 'Active' : 'Inactive'" 
                                    :severity="form.is_active ? 'success' : 'secondary'"
                                />
                            </div>
                        </div>
                    </div>
                </template>
                
                <template #content>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Created Date</h4>
                            <div class="flex items-center gap-2">
                                <i class="pi pi-calendar text-green-500"></i>
                                <span>{{ formatDate(form.created_at) }}</span>
                            </div>
                        </div>
                        
                        <div v-if="form.updated_at && form.updated_at !== form.created_at">
                            <h4 class="font-semibold text-gray-700 mb-2">Last Updated</h4>
                            <div class="flex items-center gap-2">
                                <i class="pi pi-clock text-orange-500"></i>
                                <span>{{ formatDate(form.updated_at) }}</span>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- Questions Card -->
            <Card>
                <template #header>
                    <div class="p-6 pb-0">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Questions ({{ questions.length }})</h3>
                            <Chip 
                                :label="`${questions.length} Questions`" 
                                class="bg-blue-100 text-blue-800" 
                            />
                        </div>
                    </div>
                </template>
                
                <template #content>
                    <div v-if="questions.length > 0" class="space-y-4">
                        <div 
                            v-for="(question, index) in questions" 
                            :key="question.id" 
                            class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors"
                        >
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold">
                                            {{ index + 1 }}
                                        </span>
                                        <h4 class="font-medium text-gray-800">{{ question.question_text }}</h4>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <Chip 
                                        :label="getQuestionTypeInfo(question.question_type).label"
                                        :class="`bg-${getQuestionTypeInfo(question.question_type).color}-100 text-${getQuestionTypeInfo(question.question_type).color}-800`"
                                    >
                                        <template #icon>
                                            <i :class="`pi ${getQuestionTypeInfo(question.question_type).icon}`"></i>
                                        </template>
                                    </Chip>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else class="text-center py-8 text-gray-500">
                        <i class="pi pi-question-circle text-4xl mb-4"></i>
                        <p>No questions found for this form.</p>
                    </div>
                </template>
            </Card>
        </div>

        <!-- AI Analysis Dialog -->
        <Dialog 
            v-model:visible="aiAnalysisVisible" 
            modal 
            header="AI Analysis Results" 
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        >
            <div v-if="aiAnalysisLoading" class="text-center py-8">
                <ProgressSpinner />
                <p class="mt-4 text-gray-600">Analyzing student responses...</p>
            </div>
            
            <div v-else-if="aiInsights && aiInsights.length > 0" class="space-y-4">
                <div v-for="insight in aiInsights" :key="insight.id" class="border-l-4 border-blue-500 pl-4">
                    <div class="flex items-center gap-2 mb-2">
                        <Badge :value="insight.type || 'Analysis'" severity="info" />
                        <small class="text-gray-500">{{ formatDate(insight.created_at) }}</small>
                    </div>
                    <p class="text-gray-700">{{ insight.insight_text || insight.message || 'No insight text available' }}</p>
                </div>
            </div>
            
            <div v-else-if="aiInsights" class="text-center py-8">
                <i class="pi pi-info-circle text-4xl text-blue-500 mb-4"></i>
                <p class="text-gray-600">No insights generated yet. Make sure there are student responses to analyze.</p>
            </div>
        </Dialog>
    </div>
</template>

<style scoped>
.checkin-form-details {
    padding: 1.5rem;
    background-color: #f8fafc;
    min-height: 100vh;
}

.space-y-4 > * + * {
    margin-top: 1rem;
}

.space-y-6 > * + * {
    margin-top: 1.5rem;
}
</style>