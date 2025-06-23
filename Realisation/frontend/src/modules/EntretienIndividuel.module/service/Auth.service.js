// src/services/Auth.service.js
import axios from '@/axios/axios'; // Adjust if you're using a custom Axios instance

export default {
  async login(credentials) {
    try {
      const response = await axios.post('/auth/login', credentials);
      return response.data;
    } catch (error) {
      throw error.response?.data || { error: 'Login failed' };
    }
  },
  async logout() {
    try {
      await axios.post('/auth/logout');
    } catch (error) {
      throw error.response?.data || { error: 'Logout failed' };
    }
  },
};
