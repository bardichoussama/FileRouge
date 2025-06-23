// checkinForm.service.js
import api from '@/axios/axios';

export const getAllCheckinForms = () => {
    return api.get('/checkin-forms');
};

export const deleteFormQuestions = (id) => {
    return api.delete(`/checkin-forms/${id}`);
};

export const getCheckinFormById = (id) => {
    return api.get(`/checkin-forms/${id}`);
};

export const create = (data) => {
    return api.post('/checkin-forms', data);
};

export const update = (id, data) => {
    return api.put(`/checkin-forms/${id}`, data);
};

export const getAvailableFormsForStudent = (studentId) => {
    return api.get(`/checkin-forms/available-forms/${studentId}`);
};

export const getFormWithQuestions = (formId) => {
    return api.get(`/checkin-forms/form-with-questions/${formId}`);
};

// Fixed: Use the correct endpoint that matches your routes
export const getFormResponsesWithStudents = (formId) => {
    return api.get(`/checkin-forms/${formId}/responses-with-insights`);
};

