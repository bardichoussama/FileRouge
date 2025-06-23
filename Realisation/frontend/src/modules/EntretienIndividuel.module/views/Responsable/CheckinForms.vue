<script setup>
import { getAllCheckinForms, deleteFormQuestions, create, update, getCheckinFormById, getFormWithQuestions } from '@/modules/EntretienIndividuel.module/service/CheckinForm.service';
import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref, nextTick, reactive } from 'vue';
import { useRouter } from 'vue-router';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Toolbar from 'primevue/toolbar';
import Select from 'primevue/select';
import Card from 'primevue/card';
import DatePicker from 'primevue/datepicker';
import ToggleSwitch from 'primevue/toggleswitch';
import Badge from 'primevue/badge';
import Tag from 'primevue/tag';
import api from '@/axios/axios';

const promotions = ref([]);
const fetchPromotions = async () => {
    try {
        const response = await api.get('/promotions');
        promotions.value = response.data;
    } catch (error) {
        console.error('Error fetching promotions:', error);
        toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to load promotions', life: 5000 });
    }
};

onMounted(() => {
    fetchPromotions();
    loadCheckinForms();
});

const toast = useToast();
const router = useRouter();
const dt = ref();
const checkinForms = ref([]);
const formDialog = ref(false);
const deleteFormDialog = ref(false);
const deleteFormsDialog = ref(false);
const selectedForms = ref();
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS }
});
const submitted = ref(false);
const loading = ref(false);
const isEditing = ref(false);

// Use reactive for better form handling
const checkinForm = reactive({
    id: null,
    title: '',
    description: '',
    start_date: null,
    end_date: null,
    is_active: false,
    questions: []
});

// Store original form data for comparison
const originalFormData = ref(null);

// Question types with better options
const questionTypes = ref([
    { label: 'Short Text', value: 'text' },
 
]);

async function loadCheckinForms() {
    loading.value = true;
    try {
        const response = await getAllCheckinForms();
        checkinForms.value = response.data || [];
    } catch (error) {
        console.error('Error loading check-in forms:', error);
        toast.add({ 
            severity: 'error', 
            summary: 'Error', 
            detail: 'Failed to load check-in forms. Please try again.', 
            life: 5000 
        });
    } finally {
        loading.value = false;
    }
}

function resetForm() {
    Object.assign(checkinForm, {
        id: null,
        title: '',
        description: '',
        start_date: new Date(),
        end_date: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000),
        is_active: 1, // Change from false to 1
        questions: [{
            id: null,
            question_text: '',
            question_type: 'text'
        }]
    });
    originalFormData.value = null;
}

function openNew() {
    resetForm();
    submitted.value = false;
    isEditing.value = false;
    formDialog.value = true;
}

function hideDialog() {
    formDialog.value = false;
    submitted.value = false;
    isEditing.value = false;
    resetForm();
}

function validateForm() {
    const errors = [];

    
    if (!checkinForm.title?.trim()) {
        errors.push('Title is required');
    }
    
    if (!checkinForm.start_date) {
        errors.push('Start date is required');
    }
    
    if (!checkinForm.end_date) {
        errors.push('End date is required');
    }
    
    if (checkinForm.start_date && checkinForm.end_date && 
        new Date(checkinForm.start_date) > new Date(checkinForm.end_date)) {
        errors.push('End date must be after start date');
    }
    
    if (!checkinForm.questions || checkinForm.questions.length === 0) {
        errors.push('At least one question is required');
    } else {
        const invalidQuestions = checkinForm.questions.filter(q => !q.question_text?.trim());
        if (invalidQuestions.length > 0) {
            errors.push('All questions must have text');
        }
    }
    
    return errors;
}

async function saveForm() {
    submitted.value = true;
    
    const validationErrors = validateForm();
    if (validationErrors.length > 0) {
        toast.add({ 
            severity: 'warn', 
            summary: 'Validation Error', 
            detail: validationErrors.join(', '), 
            life: 5000 
        });
        return;
    }

    try {
        const formData = {
            title: checkinForm.title.trim(),
            description: checkinForm.description?.trim() || null,
           
            start_date: checkinForm.start_date ? new Date(checkinForm.start_date).toISOString().split('T')[0] : null,
            end_date: checkinForm.end_date ? new Date(checkinForm.end_date).toISOString().split('T')[0] : null,
            is_active: checkinForm.is_active,
            questions: checkinForm.questions.map(q => ({
                id: q.id || undefined,
                question_text: q.question_text.trim(),
                question_type: q.question_type
            }))
        };

        if (isEditing.value && checkinForm.id) {
            await update(checkinForm.id, formData);
            toast.add({ 
                severity: 'success', 
                summary: 'Success', 
                detail: 'Check-in form updated successfully', 
                life: 3000 
            });
        } else {
            await create(formData);
            toast.add({ 
                severity: 'success', 
                summary: 'Success', 
                detail: 'Check-in form created successfully', 
                life: 3000 
            });
        }

        await loadCheckinForms();
        hideDialog();
        
    } catch (error) {
        console.error('Error saving form:', error);
        const action = isEditing.value ? 'updating' : 'creating';
        toast.add({ 
            severity: 'error', 
            summary: 'Error', 
            detail: `Failed ${action} check-in form. Please try again.`, 
            life: 5000 
        });
    }
}

// Fixed edit function to properly load form data with questions
async function editForm(form) {
    try {
        loading.value = true;
        
        // Reset form first
        resetForm();
        await nextTick();
        
        // Try to get full form data with questions if not already loaded
        let formData = form;
        if (!form.questions || form.questions.length === 0) {
            try {
                const response = await getFormWithQuestions(form.id);
                formData = response.data || form;
            } catch (error) {
                console.warn('Could not load full form data, using available data:', error);
                formData = form;
            }
        }
        
        // Store original data for comparison
        originalFormData.value = JSON.parse(JSON.stringify(formData));
        
        // Populate form
        Object.assign(checkinForm, {
            id: formData.id,
            title: formData.title || '',
            description: formData.description || '',
            promotion_id: formData.promotion_id || null,
            start_date: formData.start_date ? new Date(formData.start_date) : new Date(),
            end_date: formData.end_date ? new Date(formData.end_date) : new Date(Date.now() + 30 * 24 * 60 * 60 * 1000),
            is_active: formData.is_active ? 1 : 0,
            questions: formData.questions && formData.questions.length > 0 
                ? formData.questions.map(q => ({
                    id: q.id || null,
                    question_text: q.question_text || '',
                    question_type: q.question_type || 'text'
                }))
                : [{
                    id: null,
                    question_text: '',
                    question_type: 'text'
                }]
        });
        
        submitted.value = false;
        isEditing.value = true;
        formDialog.value = true;
        
    } catch (error) {
        console.error('Error loading form for editing:', error);
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to load form data for editing. Please try again.',
            life: 5000
        });
    } finally {
        loading.value = false;
    }
}

function confirmDeleteForm(form) {
    Object.assign(checkinForm, form);
    deleteFormDialog.value = true;
}

// Fixed delete function with better error handling
async function deleteForm() {
    if (!checkinForm.id) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'No form selected for deletion',
            life: 3000
        });
        return;
    }

    try {
        console.log('Deleting form with ID:', checkinForm.id);
        
        // Call the delete API
        await deleteFormQuestions(checkinForm.id);
        
        // Reload the forms list
        await loadCheckinForms();
        
        // Close dialog and reset
        deleteFormDialog.value = false;
        resetForm();
        
        toast.add({ 
            severity: 'success', 
            summary: 'Success', 
            detail: 'Check-in form deleted successfully', 
            life: 3000 
        });
        
    } catch (error) {
        console.error('Error deleting form:', error);
        
        // Show specific error message if available
        const errorMessage = error.response?.data?.message || error.message || 'An unknown error occurred';
        
        toast.add({ 
            severity: 'error', 
            summary: 'Delete Failed', 
            detail: `Failed to delete check-in form: ${errorMessage}`, 
            life: 5000 
        });
    }
}

function exportCSV() {
    dt.value.exportCSV();
}

function confirmDeleteSelected() {
    if (!selectedForms.value || selectedForms.value.length === 0) {
        toast.add({ 
            severity: 'warn', 
            summary: 'Warning', 
            detail: 'Please select forms to delete', 
            life: 3000 
        });
        return;
    }
    deleteFormsDialog.value = true;
}

// Fixed bulk delete function
async function deleteSelectedForms() {
    if (!selectedForms.value || selectedForms.value.length === 0) {
        return;
    }

    try {
        console.log('Deleting forms:', selectedForms.value.map(f => f.id));
        
        // Delete each form individually with error handling
        const deletePromises = selectedForms.value.map(async (form) => {
            try {
                await deleteFormQuestions(form.id);
                return { success: true, id: form.id, title: form.title };
            } catch (error) {
                console.error(`Failed to delete form ${form.id}:`, error);
                return { success: false, id: form.id, title: form.title, error };
            }
        });
        
        const results = await Promise.all(deletePromises);
        
        // Check results
        const successful = results.filter(r => r.success);
        const failed = results.filter(r => !r.success);
        
        if (successful.length > 0) {
            toast.add({ 
                severity: 'success', 
                summary: 'Success', 
                detail: `${successful.length} form(s) deleted successfully`, 
                life: 3000 
            });
        }
        
        if (failed.length > 0) {
            toast.add({ 
                severity: 'error', 
                summary: 'Partial Failure', 
                detail: `Failed to delete ${failed.length} form(s). Please try again.`, 
                life: 5000 
            });
        }
        
        // Reload forms and close dialog
        await loadCheckinForms();
        deleteFormsDialog.value = false;
        selectedForms.value = null;
        
    } catch (error) {
        console.error('Error in bulk delete:', error);
        toast.add({ 
            severity: 'error', 
            summary: 'Error', 
            detail: 'Failed to delete selected forms. Please try again.', 
            life: 5000 
        });
    }
}

function formatDate(dateString) {
    if (!dateString) return '—';
    try {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } catch {
        return '—';
    }
}

function getFormStatus(form) {
    return form.is_active 
        ? { label: 'Active', severity: 'success' }
        : { label: 'Inactive', severity: 'secondary' };
}

function viewForm(form) {
    router.push({ name: 'checkin-form-details', params: { id: form.id } });
}

function addQuestion() {
    checkinForm.questions.push({
        id: null,
        question_text: '',
        question_type: 'text'
    });
}

function removeQuestion(index) {
    if (checkinForm.questions.length > 1) {
        checkinForm.questions.splice(index, 1);
    } else {
        toast.add({
            severity: 'warn',
            summary: 'Warning',
            detail: 'At least one question is required',
            life: 3000
        });
    }
}

function duplicateQuestion(index) {
    const originalQuestion = checkinForm.questions[index];
    const newQuestion = {
        id: null,
        question_text: originalQuestion.question_text + ' (Copy)',
        question_type: originalQuestion.question_type
    };
    checkinForm.questions.splice(index + 1, 0, newQuestion);
}

function moveQuestionUp(index) {
    if (index > 0) {
        const temp = checkinForm.questions[index];
        checkinForm.questions[index] = checkinForm.questions[index - 1];
        checkinForm.questions[index - 1] = temp;
    }
}

function moveQuestionDown(index) {
    if (index < checkinForm.questions.length - 1) {
        const temp = checkinForm.questions[index];
        checkinForm.questions[index] = checkinForm.questions[index + 1];
        checkinForm.questions[index + 1] = temp;
    }
}

// Quick toggle for form status
async function toggleFormStatus(form) {
    try {
        const updatedData = {
            title: form.title,
            description: form.description,
            start_date: form.start_date,
            end_date: form.end_date,
            is_active: !form.is_active
        };
        
        await update(form.id, updatedData);
        
        toast.add({
            severity: 'success',
            summary: 'Success',
            detail: `Form ${updatedData.is_active ? 'activated' : 'deactivated'} successfully`,
            life: 3000
        });
        
        await loadCheckinForms();
        
    } catch (error) {
        console.error('Error toggling form status:', error);
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Failed to update form status. Please try again.',
            life: 5000
        });
    }
}
</script>

<template>
    <div class="p-4">
        <div class="card">
            <Toolbar class="mb-6">
                <template #start>
                    <div class="flex gap-2">
                        <Button 
                            label="New Form" 
                            icon="pi pi-plus" 
                            severity="secondary" 
                            @click="openNew" 
                        />
                        <Button 
                            label="Delete Selected" 
                            icon="pi pi-trash" 
                            severity="danger" 
                            :disabled="!selectedForms || !selectedForms.length" 
                            @click="confirmDeleteSelected" 
                        />
                    </div>
                </template>

                <template #end>
                    <Button 
                        label="Export CSV" 
                        icon="pi pi-download" 
                        severity="secondary" 
                        @click="exportCSV" 
                    />
                </template>
            </Toolbar>

            <DataTable
                ref="dt"
                v-model:selection="selectedForms"
                :value="checkinForms"
                dataKey="id"
                :paginator="true"
                :rows="10"
                :filters="filters"
                :loading="loading"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 25]"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords} check-in forms"
                responsiveLayout="scroll"
            >
                <template #header>
                    <div class="flex flex-wrap gap-2 items-center justify-between">
                        <h4 class="m-0 text-xl font-semibold">📝 Check-in Forms</h4>
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText 
                                v-model="filters['global'].value" 
                                placeholder="Search forms..." 
                                class="w-64"
                            />
                        </IconField>
                    </div>
                </template>

                <template #empty>
                    <div class="text-center py-8">
                        <i class="pi pi-inbox text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 text-lg">No check-in forms found</p>
                        <Button 
                            label="Create Your First Form" 
                            icon="pi pi-plus" 
                            class="mt-4"
                            @click="openNew"
                        />
                    </div>
                </template>

                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                
                <Column field="title" header="Title" sortable style="min-width: 16rem">
                    <template #body="slotProps">
                        <div class="font-semibold text-gray-900">{{ slotProps.data.title || '—' }}</div>
                        <div class="text-sm text-gray-500 mt-1" v-if="slotProps.data.description">
                            {{ slotProps.data.description.substring(0, 60) }}{{ slotProps.data.description?.length > 60 ? '...' : '' }}
                        </div>
                    </template>
                </Column>
                
                <Column field="status" header="Status" sortable style="min-width: 8rem">
    <template #body="slotProps">
        <div class="flex justify-center">
            <Tag                                 
                :value="getFormStatus(slotProps.data).label"
                :severity="getFormStatus(slotProps.data).severity"
                class="text-xs"
            />
        </div>
    </template>
</Column>
                
                <Column field="duration" header="Duration" sortable style="min-width: 12rem">
                    <template #body="slotProps">
                        <div class="text-sm">
                            <div class="flex items-center gap-1 text-green-600">
                                <i class="pi pi-calendar-plus text-xs"></i>
                                {{ formatDate(slotProps.data.start_date) }}
                            </div>
                            <div class="flex items-center gap-1 text-red-600 mt-1">
                                <i class="pi pi-calendar-minus text-xs"></i>
                                {{ formatDate(slotProps.data.end_date) }}
                            </div>
                        </div>
                    </template>
                </Column>
                
                <Column field="questions_count" header="Questions" sortable style="min-width: 8rem">
                    <template #body="slotProps">
                        <div class="text-center">
                            <Badge 
                                :value="slotProps.data.questions_count || slotProps.data.questions?.length || 0"
                                severity="info"
                            />
                        </div>
                    </template>
                </Column>
                
                <Column field="created_at" header="Created" sortable style="min-width: 10rem">
                    <template #body="slotProps">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-calendar text-gray-400"></i>
                            {{ formatDate(slotProps.data.created_at) }}
                        </div>
                    </template>
                </Column>
                
                <Column :exportable="false" style="min-width: 12rem">
                    <template #body="slotProps">
                        <div class="flex gap-2">
                            <Button 
                                icon="pi pi-eye" 
                                size="small"
                                outlined 
                                v-tooltip.top="'View Details'"
                                @click="viewForm(slotProps.data)" 
                            />
                            <Button 
                                icon="pi pi-pencil" 
                                size="small"
                                outlined 
                                v-tooltip.top="'Edit Form'"
                                @click="editForm(slotProps.data)" 
                            />
                            <Button 
                                icon="pi pi-trash" 
                                size="small"
                                outlined 
                                severity="danger" 
                                v-tooltip.top="'Delete Form'"
                                @click="confirmDeleteForm(slotProps.data)" 
                            />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <!-- Create/Edit Form Dialog -->
        <Dialog 
            v-model:visible="formDialog" 
            :style="{ width: '900px' }" 
            :header="isEditing ? 'Edit Check-in Form' : 'Create New Check-in Form'" 
            :modal="true"
            :closable="true"
            class="form-dialog"
        >
            <div class="flex flex-col gap-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="title" class="block font-semibold mb-2 text-gray-700">
                            Form Title <span class="text-red-500">*</span>
                        </label>
                        <InputText 
                            id="title" 
                            v-model="checkinForm.title" 
                            :invalid="submitted && !checkinForm.title?.trim()" 
                            fluid 
                            placeholder="e.g., Weekly Team Check-In, Performance Review" 
                            class="w-full"
                        />
                        <small v-if="submitted && !checkinForm.title?.trim()" class="text-red-500 mt-1">
                            Title is required.
                        </small>
                    </div>
                    
                    <div>
                        <label for="description" class="block font-semibold mb-2 text-gray-700">
                            Description
                        </label>
                        <Textarea 
                            id="description" 
                            v-model="checkinForm.description" 
                            rows="3" 
                            fluid 
                            placeholder="Brief description of this check-in form's purpose..."
                            class="w-full"
                            :autoResize="true"
                        />
                    </div>
                </div>

                <!-- Date Range and Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="start_date" class="block font-semibold mb-2 text-gray-700">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <DatePicker 
                            id="start_date"
                            v-model="checkinForm.start_date" 
                            :invalid="submitted && !checkinForm.start_date"
                            dateFormat="yy-mm-dd"
                            fluid
                            showIcon
                            iconDisplay="input"
                        />
                        <small v-if="submitted && !checkinForm.start_date" class="text-red-500 mt-1">
                            Start date is required.
                        </small>
                    </div>
                    
                    <div>
                        <label for="end_date" class="block font-semibold mb-2 text-gray-700">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <DatePicker 
                            id="end_date"
                            v-model="checkinForm.end_date" 
                            :invalid="submitted && !checkinForm.end_date"
                            dateFormat="yy-mm-dd"
                            fluid
                            showIcon
                            iconDisplay="input"
                        />
                        <small v-if="submitted && !checkinForm.end_date" class="text-red-500 mt-1">
                            End date is required.
                        </small>
                    </div>
                    
                    <div>
    <label for="is_active" class="block font-semibold mb-2 text-gray-700">
        Form Status
    </label>
    <div class="flex items-center gap-3 mt-3">
        <ToggleSwitch 
            id="is_active"
            v-model="checkinForm.is_active"
            :true-value="1"
            :false-value="0"
        />
        <span class="text-sm" :class="checkinForm.is_active ? 'text-green-600' : 'text-gray-500'">
            {{ checkinForm.is_active ? 'Active & Visible' : 'Inactive & Hidden' }}
        </span>
    </div>
    <small class="text-gray-500 mt-1 block">
        Only active forms will be visible to users
    </small>
</div>
</div>
                <!-- Questions Section -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-700 text-lg">
                            Questions <span class="text-red-500">*</span>
                        </h3>
                        <Button 
                            label="Add Question" 
                            icon="pi pi-plus" 
                            size="small" 
                            @click="addQuestion"
                        />
                    </div>
                    
                    <div class="space-y-4">
                        <Card 
                            v-for="(question, index) in checkinForm.questions" 
                            :key="`question-${index}-${question.id || 'new'}`"
                            class="question-card"
                        >
                            <template #content>
                                <div class="flex flex-col gap-4">
                                    <!-- Question Header -->
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-medium text-gray-800">
                                            Question {{ index + 1 }}
                                            <span v-if="question.id" class="text-xs text-gray-500 ml-2">(ID: {{ question.id }})</span>
                                        </h4>
                                        <div class="flex gap-1">
                                            <Button 
                                                icon="pi pi-arrow-up" 
                                                size="small"
                                                text
                                                :disabled="index === 0"
                                                v-tooltip.top="'Move Up'"
                                                @click="moveQuestionUp(index)"
                                            />
                                            <Button 
                                                icon="pi pi-arrow-down" 
                                                size="small"
                                                text
                                                :disabled="index === checkinForm.questions.length - 1"
                                                v-tooltip.top="'Move Down'"
                                                @click="moveQuestionDown(index)"
                                            />
                                            <Button 
                                                icon="pi pi-copy" 
                                                size="small"
                                                text
                                                v-tooltip.top="'Duplicate'"
                                                @click="duplicateQuestion(index)"
                                            />
                                            <Button 
                                                icon="pi pi-trash" 
                                                size="small"
                                                text
                                                severity="danger"
                                                :disabled="checkinForm.questions.length === 1"
                                                v-tooltip.top="'Remove'"
                                                @click="removeQuestion(index)"
                                            />
                                        </div>
                                    </div>
                                    
                                    <!-- Question Content -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium mb-2 text-gray-600">
                                                Question Text <span class="text-red-500">*</span>
                                            </label>
                                            <InputText 
                                                v-model="question.question_text"
                                                placeholder="Enter your question here..."
                                                :invalid="submitted && !question.question_text?.trim()"
                                                fluid
                                                class="w-full"
                                            />
                                            <small v-if="submitted && !question.question_text?.trim()" class="text-red-500 mt-1">
                                                Question text is required.
                                            </small>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium mb-2 text-gray-600">
                                                Answer Type
                                            </label>
                                            <Select 
                                                v-model="question.question_type"
                                                :options="questionTypes"
                                                optionLabel="label"
                                                optionValue="value"
                                                placeholder="Select type"
                                                fluid
                                            />
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Card>
                    </div>
                    
                    <small v-if="submitted && (!checkinForm.questions || checkinForm.questions.length === 0)" class="text-red-500">
                        At least one question is required.
                    </small>
                </div>
            </div>

            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button 
                        label="Cancel" 
                        icon="pi pi-times" 
                        text 
                        @click="hideDialog" 
                    />
                    <Button 
                        :label="isEditing ? 'Update Form' : 'Create Form'" 
                        icon="pi pi-check" 
                        @click="saveForm" 
                    />
                </div>
            </template>
        </Dialog>

        <!-- Delete Single Form Dialog -->
        <Dialog 
            v-model:visible="deleteFormDialog" 
            :style="{ width: '450px' }" 
            header="Confirm Deletion" 
            :modal="true"
        >
            <div class="flex items-center gap-4 p-4">
                <i class="pi pi-exclamation-triangle text-3xl text-red-500" />
                <div>
                    <p class="mb-2">
                        Are you sure you want to delete <strong>{{ checkinForm.title }}</strong>?
                    </p>
                    <small class="text-gray-500">
                        This will permanently delete the form and all associated questions and responses.
                    </small>
                </div>
            </div>
            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button 
                        label="Cancel" 
                        icon="pi pi-times" 
                        text 
                        @click="deleteFormDialog = false" 
                    />
                    <Button 
                        label="Delete" 
                        icon="pi pi-trash" 
                        severity="danger" 
                        @click="deleteForm" 
                    />
                </div>
            </template>
        </Dialog>

        <!-- Delete Multiple Forms Dialog -->
        <Dialog 
            v-model:visible="deleteFormsDialog" 
            :style="{ width: '450px' }" 
            header="Confirm Deletion" 
            :modal="true"
        >
            <div class="flex items-center gap-4 p-4">
                <i class="pi pi-exclamation-triangle text-3xl text-red-500" />
                <div>
                    <p class="mb-2">
                        Are you sure you want to delete {{ selectedForms?.length }} selected form(s)?
                    </p>
                    <small class="text-gray-500">
                        This will permanently delete all selected forms and their associated questions and responses.
                    </small>
                </div>
            </div>
            <template #footer>
                <div class="flex justify-end gap-2">
                    <Button 
                        label="Cancel" 
                        icon="pi pi-times" 
                        text 
                        @click="deleteFormsDialog = false" 
                    />
                    <Button 
                        label="Delete All" 
                        icon="pi pi-trash" 
                        severity="danger" 
                        @click="deleteSelectedForms" 
                    />
                </div>
            </template>
        </Dialog>
    </div>
</template>

<style scoped>
.card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
}

.question-card {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.question-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
}

.form-dialog :deep(.p-dialog-content) {
    padding: 1.5rem;
}

.form-dialog :deep(.p-dialog-header) {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
}

:deep(.p-datatable .p-datatable-thead > tr > th) {
    background: #f8fafc;
    color: #374151;
    font-weight: 600;
}

:deep(.p-button.p-button-outlined) {
    border-width: 1px;
}
</style>