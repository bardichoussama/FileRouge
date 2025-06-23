//StudentCheckin.service.js
import api from '@/axios/axios';


export const submitCheckin = (data) => {
  return api.post('/student-checkins', data);
};

export const getMyCheckins = () => {
  return api.get('/student-checkins/my-checkins');
};