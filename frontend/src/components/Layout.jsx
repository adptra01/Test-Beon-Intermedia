import React from 'react';
import { Outlet, Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const Layout = () => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  return (
    <>
      <nav className="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div className="container-fluid">
          <Link className="navbar-brand" to="/">Iuran RT</Link>
          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarNav">
            <ul className="navbar-nav me-auto mb-2 mb-lg-0">
              <li className="nav-item">
                <Link className="nav-link" to="/dashboard">Dashboard</Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/residents">Residents</Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/houses">Houses</Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/house-residents">House Residents</Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/payments">Payments</Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/expenses">Expenses</Link>
              </li>
            </ul>
            <span className="navbar-text me-3">
              {user ? `Hello, ${user.name}` : ''}
            </span>
            <button className="btn btn-outline-danger" onClick={handleLogout}>Logout</button>
          </div>
        </div>
      </nav>
      <div className="container">
        <Outlet />
      </div>
    </>
  );
};

export default Layout;
