import api from '@/axios/axios';

export const getPromotions = () => {
    return api.get('/promotions');
}

export const getKPIs = (promotionId) => {
    return api.get(`/dashboard/kpis/${promotionId}`);
}

export const getGroupeStats = (promotionId) => {
    return api.get(`/dashboard/groupe-stats/${promotionId}`);
}

export const getCheckinsByPromotion = () => {
    return api.get('/dashboard/checkins-by-promotion');
}