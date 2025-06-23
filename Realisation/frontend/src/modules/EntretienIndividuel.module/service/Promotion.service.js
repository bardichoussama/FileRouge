import api from '@/axios/axios';
export const getPromotions = () => {
    return api.get('/promotions');
}