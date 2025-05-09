import React, { useEffect, useState } from 'react';
import api from '../lib/axios';

const ResidentsList = () => {
  const [residents, setResidents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchResidents = async () => {
      try {
        const response = await api.get('/residents');
        if (response.data.success) {
          setResidents(response.data.data);
        } else {
          setError('Failed to fetch residents');
        }
      } catch (err) {
        setError('Error fetching residents');
      } finally {
        setLoading(false);
      }
    };

    fetchResidents();
  }, []);

  if (loading) {
    return <p>Loading residents...</p>;
  }

  if (error) {
    return <p className="text-red-500">{error}</p>;
  }

  return (
    <div>
      <h2 className="text-xl font-semibold mb-4">Residents List</h2>
      {residents.length === 0 ? (
        <p>No residents found.</p>
      ) : (
        <table className="min-w-full border border-gray-300">
          <thead>
            <tr className="bg-gray-100">
              <th className="border px-4 py-2">Name</th>
              <th className="border px-4 py-2">KTP Photo</th>
              <th className="border px-4 py-2">Status</th>
              <th className="border px-4 py-2">Phone Number</th>
              <th className="border px-4 py-2">Married</th>
              <th className="border px-4 py-2">Created At</th>
              <th className="border px-4 py-2">Updated At</th>
            </tr>
          </thead>
          <tbody>
            {residents.map((resident) => (
              <tr key={resident.id}>
                <td className="border px-4 py-2">{resident.name}</td>
                <td className="border px-4 py-2">
                  {resident.ktp_photo ? (
                    <img src={resident.ktp_photo} alt="KTP" className="h-12 w-16 object-cover" />
                  ) : (
                    'N/A'
                  )}
                </td>
                <td className="border px-4 py-2">{resident.status}</td>
                <td className="border px-4 py-2">{resident.phone_number || 'N/A'}</td>
                <td className="border px-4 py-2">{resident.is_married ? 'Yes' : 'No'}</td>
                <td className="border px-4 py-2">{new Date(resident.created_at).toLocaleString()}</td>
                <td className="border px-4 py-2">{new Date(resident.updated_at).toLocaleString()}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
};

export default ResidentsList;
