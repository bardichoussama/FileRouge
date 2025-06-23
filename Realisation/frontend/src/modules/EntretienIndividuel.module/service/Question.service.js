// Question.service.js
import api from '@/axios/axios';
export const getQuestionsByFormId = (formId) => {
    return api.get(`/questions/form/${formId}`);
};