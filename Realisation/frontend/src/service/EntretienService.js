import axios from '@/axios/axios';

const resource = '/entretien';

export default {
  getAll() {
    return axios.get(`/api${resource}`)
      .then(res => res.data);
  },
  create(data) {
    return axios.post(`/api${resource}`, data)
      .then(res => res.data);
  }
};
