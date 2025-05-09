// src/main.jsx (atau index.js)
import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';

import Layout from './components/Layout';           // dashboard layout
import LayoutLogin from './components/LayoutLogin'; // login layout
import Login from './pages/Login';
import Dashboard from './pages/Dashboard';
import Residents from './pages/Residents';

import PrivateRoute from './components/PrivateRoute';
import './app/globals.css';  // Import Tailwind CSS global styles


ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          {/* Public route: LOGIN */}
          <Route
            path="/login"
            element={
              <LayoutLogin>
                <Login />
              </LayoutLogin>
            }
          />

          {/* Protect all dashboard routes */}
          <Route
            path="/"
            element={
              <PrivateRoute>
                <Layout />
              </PrivateRoute>
            }
          >
            <Route index element={<Navigate to="dashboard" replace />} />
            <Route path="dashboard" element={<Dashboard />} />
            <Route path="residents" element={<Residents />} />   
          </Route>

          {/* fallback: kalau URL lain, redirect ke login */}
          <Route path="*" element={<Navigate to="/login" replace />} />
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  </React.StrictMode>
);
