// src/axios/axios.js
import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8000/api', // Adjust to your API base URL
  timeout: 10000,
});

// Request interceptor to add auth token
instance.interceptors.request.use(
  (config) => {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const token = user.token || localStorage.getItem('token');
    
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor to handle 401 errors
instance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token expired or invalid - redirect to login
      localStorage.removeItem('user');
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      
      // Redirect to login page
      window.location.href = '/auth/login';
    }
    
    return Promise.reject(error);
  }
);

export default instance;