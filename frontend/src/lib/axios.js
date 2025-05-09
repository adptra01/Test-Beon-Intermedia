import axios from "axios";

// 1A. instance untuk CSRF (cookie‐based Sanctum)
export const getCsrfToken = () => {
  return axios.get("http://localhost:8000/sanctum/csrf-cookie", {
    withCredentials: true,
  });
};

// 1B. instance utama untuk semua endpoint /api/*
const api = axios.create({
  baseURL: "http://localhost:8000/api",   // ← note: "/api" di sini
  // we use token‐based auth header, so withCredentials not needed
});

// helper untuk set Authorization header
export const setAuthToken = (token) => {
  if (token) {
    api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  } else {
    delete api.defaults.headers.common["Authorization"];
  }
};

export default api;
