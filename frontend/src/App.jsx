import React from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { useAuth } from './context/AuthContext';
import Layout from './components/Layout';
import LoginForm from './components/LoginForm';
import Residents from './pages/Residents';

function PrivateRoute({ children }) {
  const { user, loading } = useAuth();
  if (loading) return <div>Loading...</div>;
  return user ? children : <Navigate to="/login" replace />;
}

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/login" element={<LoginForm />} />
        <Route
          path="/"
          element={
            <PrivateRoute>
              <Layout />
            </PrivateRoute>
          }
        >
          <Route index element={<Navigate to="/dashboard" replace />} />
          <Route path="dashboard" element={<div>Dashboard (to be implemented)</div>} />
          <Route path="residents" element={<Residents />} />
          <Route path="houses" element={<div>Houses (to be implemented)</div>} />
          <Route path="house-residents" element={<div>House Residents (to be implemented)</div>} />
          <Route path="payments" element={<div>Payments (to be implemented)</div>} />
          <Route path="expenses" element={<div>Expenses (to be implemented)</div>} />
        </Route>
      </Routes>
    </Router>
  );
}

export default App;
