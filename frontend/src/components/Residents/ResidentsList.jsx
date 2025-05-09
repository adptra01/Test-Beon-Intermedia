// File: src/components/Residents/ResidentList.jsx

import React, { useEffect, useState } from 'react';
import api from '../../lib/axios';
import ResidentForm from './ResidentForm';

const ResidentList = () => {
  const [residents, setResidents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const [editingResident, setEditingResident] = useState(null);

  useEffect(() => {
    const fetchResidents = async () => {
      try {
        const response = await api.get('/residents');
        if (response.data.success) {
          setResidents(response.data.data);
        } else {
          setError('Failed to fetch residents data.');
        }
      } catch (err) {
        setError('An error occurred while fetching residents data.');
      } finally {
        setLoading(false);
      }
    };

    fetchResidents();
  }, []);

  const handleAddClick = () => {
    setEditingResident(null);
    setShowForm(true);
    setError(null);
  };

  const handleEditClick = (resident) => {
    setEditingResident(resident);
    setShowForm(true);
    setError(null);
  };

  const handleDeleteClick = async (residentId) => {
    if (!window.confirm('Are you sure you want to delete this resident?')) return;
    try {
      const response = await api.delete(`/residents/${residentId}`);
      if (response.data.success) {
        setResidents(prev => prev.filter(r => r.id !== residentId));
      } else {
        setError('Failed to delete resident.');
      }
    } catch (err) {
      setError('An error occurred while deleting resident.');
    }
  };

  const handleFormSubmit = async (formData) => {
    try {
      let response;
      if (editingResident) {
        formData.append('_method', 'PUT'); // Laravel method spoofing
        response = await api.post(`/residents/${editingResident.id}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
      } else {
        response = await api.post('/residents', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
      }

      if (response.data.success) {
        if (editingResident) {
          setResidents(prev =>
            prev.map(r => (r.id === editingResident.id ? response.data.data : r))
          );
        } else {
          setResidents(prev => [...prev, response.data.data]);
        }
        setShowForm(false);
        setEditingResident(null);
      } else {
        setError('Failed to save resident data.');
      }
    } catch (err) {
      setError('An error occurred while saving resident.');
    }
  };

  const handleFormCancel = () => {
    setShowForm(false);
    setEditingResident(null);
    setError(null);
  };

  if (loading) {
    return <p>Loading residents data...</p>;
  }

  return (
    <div className="p-4">
      <h2 className="text-xl font-semibold mb-4">Residents List</h2>

      {error && <p className="text-red-500 mb-4">{error}</p>}

      {!showForm && (
        <button
          onClick={handleAddClick}
          className="mb-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
        >
          Add New Resident
        </button>
      )}

      {showForm && (
        <ResidentForm
          initialData={editingResident}
          onSubmit={handleFormSubmit}
          onCancel={handleFormCancel}
        />
      )}

      {residents.length === 0 ? (
        <p className="text-gray-600">No residents data available.</p>
      ) : (
        <ul className="space-y-2 mt-4">
          {residents.map((resident) => (
            <li
              key={resident.id}
              className="border p-4 rounded flex justify-between items-center"
            >
              <div>
                <p className="font-medium">{resident.name}</p>
                <p className="text-sm text-gray-600">{resident.phone_number}</p>
              </div>
              <div className="space-x-2">
                <button
                  onClick={() => handleEditClick(resident)}
                  className="text-blue-600 hover:underline"
                >
                  Edit
                </button>
                <button
                  onClick={() => handleDeleteClick(resident.id)}
                  className="text-red-600 hover:underline"
                >
                  Delete
                </button>
              </div>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default ResidentList;
