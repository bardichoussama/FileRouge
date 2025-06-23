// AIInsights.service.js

import api from '@/axios/axios'; // Use your existing axios instance

export const analyzeCheckinForm = async (checkinFormId) => {
    try {
        const response = await api.post(`/ai-insights/analyze/checkin-form/${checkinFormId}`);
        return response.data;
    } catch (error) {
        console.error('Error analyzing checkin form:', error);
        throw error;
    }
};

