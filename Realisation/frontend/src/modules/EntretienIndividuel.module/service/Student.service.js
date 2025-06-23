import api from '@/axios/axios';
export const getStudents = () => {
    return api.get('/students');
};