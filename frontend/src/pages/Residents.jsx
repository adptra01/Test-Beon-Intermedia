import React, { useEffect, useState } from 'react';
import apiClient from '../services/api';

const Residents = () => {
  const [residents, setResidents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [search, setSearch] = useState('');
  const [form, setForm] = useState({
    id: null,
    full_name: '',
    ktp_photo: null,
    resident_status: 'permanent',
    phone_number: '',
    married_status: false,
  });
  const [formErrors, setFormErrors] = useState({});
  const [isEditing, setIsEditing] = useState(false);

  const fetchResidents = async () => {
    setLoading(true);
    try {
      const res = await apiClient.get('/api/residents', {
        params: { search },
      });
      setResidents(res.data.data || []);
    } catch (err) {
      setError('Failed to fetch residents');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchResidents();
  }, [search]);

  const validateForm = () => {
    const errors = {};
    if (!form.full_name) errors.full_name = 'Full name is required';
    if (!form.phone_number) errors.phone_number = 'Phone number is required';
    setFormErrors(errors);
    return Object.keys(errors).length === 0;
  };

  const handleInputChange = (e) => {
    const { name, value, type, checked, files } = e.target;
    if (type === 'checkbox') {
      setForm({ ...form, [name]: checked });
    } else if (type === 'file') {
      setForm({ ...form, [name]: files[0] });
    } else {
      setForm({ ...form, [name]: value });
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!validateForm()) return;

    const formData = new FormData();
    formData.append('full_name', form.full_name);
    formData.append('resident_status', form.resident_status);
    formData.append('phone_number', form.phone_number);
    formData.append('married_status', form.married_status ? 1 : 0);
    if (form.ktp_photo) {
      formData.append('ktp_photo', form.ktp_photo);
    }

    try {
      if (isEditing) {
        await apiClient.post(`/api/residents/${form.id}?_method=PUT`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
      } else {
        await apiClient.post('/api/residents', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
      }
      setForm({
        id: null,
        full_name: '',
        ktp_photo: null,
        resident_status: 'permanent',
        phone_number: '',
        married_status: false,
      });
      setIsEditing(false);
      fetchResidents();
      alert('Operation successful');
    } catch (err) {
      alert('Operation failed');
    }
  };

  const handleEdit = (resident) => {
    setForm({
      id: resident.id,
      full_name: resident.full_name,
      ktp_photo: null,
      resident_status: resident.resident_status,
      phone_number: resident.phone_number,
      married_status: resident.married_status,
    });
    setIsEditing(true);
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Are you sure you want to delete this resident?')) return;
    try {
      await apiClient.delete(`/api/residents/${id}`);
      fetchResidents();
      alert('Deleted successfully');
    } catch (err) {
      alert('Delete failed');
    }
  };

  return (
    <div>
      <h2>Residents</h2>
      <div className="mb-3">
        <input
          type="text"
          className="form-control"
          placeholder="Search residents..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />
      </div>
      {loading ? (
        <div>Loading...</div>
      ) : error ? (
        <div className="alert alert-danger">{error}</div>
      ) : (
        <table className="table table-striped">
          <thead>
            <tr>
              <th>Full Name</th>
              <th>Resident Status</th>
              <th>Phone Number</th>
              <th>Married Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {residents.map((resident) => (
              <tr key={resident.id}>
                <td>{resident.full_name}</td>
                <td>{resident.resident_status}</td>
                <td>{resident.phone_number}</td>
                <td>{resident.married_status ? 'Married' : 'Single'}</td>
                <td>
                  <button className="btn btn-sm btn-primary me-2" onClick={() => handleEdit(resident)}>Edit</button>
                  <button className="btn btn-sm btn-danger" onClick={() => handleDelete(resident.id)}>Delete</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
      <hr />
      <h3>{isEditing ? 'Edit Resident' : 'Add Resident'}</h3>
      <form onSubmit={handleSubmit} encType="multipart/form-data">
        <div className="mb-3">
          <label htmlFor="full_name" className="form-label">Full Name</label>
          <input
            type="text"
            id="full_name"
            name="full_name"
            className={`form-control ${formErrors.full_name ? 'is-invalid' : ''}`}
            value={form.full_name}
            onChange={handleInputChange}
          />
          {formErrors.full_name && <div className="invalid-feedback">{formErrors.full_name}</div>}
        </div>
        <div className="mb-3">
          <label htmlFor="ktp_photo" className="form-label">KTP Photo</label>
          <input
            type="file"
            id="ktp_photo"
            name="ktp_photo"
            className="form-control"
            onChange={handleInputChange}
            accept="image/*"
          />
        </div>
        <div className="mb-3">
          <label htmlFor="resident_status" className="form-label">Resident Status</label>
          <select
            id="resident_status"
            name="resident_status"
            className="form-select"
            value={form.resident_status}
            onChange={handleInputChange}
          >
            <option value="permanent">Permanent</option>
            <option value="contract">Contract</option>
          </select>
        </div>
        <div className="mb-3">
          <label htmlFor="phone_number" className="form-label">Phone Number</label>
          <input
            type="text"
            id="phone_number"
            name="phone_number"
            className={`form-control ${formErrors.phone_number ? 'is-invalid' : ''}`}
            value={form.phone_number}
            onChange={handleInputChange}
          />
          {formErrors.phone_number && <div className="invalid-feedback">{formErrors.phone_number}</div>}
        </div>
        <div className="form-check mb-3">
          <input
            type="checkbox"
            id="married_status"
            name="married_status"
            className="form-check-input"
            checked={form.married_status}
            onChange={handleInputChange}
          />
          <label htmlFor="married_status" className="form-check-label">Married</label>
        </div>
        <button type="submit" className="btn btn-primary">{isEditing ? 'Update' : 'Add'}</button>
        {isEditing && (
          <button
            type="button"
            className="btn btn-secondary ms-2"
            onClick={() => {
              setForm({
                id: null,
                full_name: '',
                ktp_photo: null,
                resident_status: 'permanent',
                phone_number: '',
                married_status: false,
              });
              setIsEditing(false);
              setFormErrors({});
            }}
          >
            Cancel
          </button>
        )}
      </form>
    </div>
  );
};

export default Residents;
