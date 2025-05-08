// src/services/api.js
import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000', // sesuaikan dengan URL backend
  withCredentials: true,
});

export default apiClient;