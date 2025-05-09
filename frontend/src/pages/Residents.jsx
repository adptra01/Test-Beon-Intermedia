// File: src/pages/Residents.jsx
import React, { useEffect, useState } from 'react';
import api from '../lib/axios';
import ResidentForm from '../components/Residents/ResidentForm';

export default function Residents() {
  const [residents, setResidents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [editing, setEditing] = useState(null);
  const [showForm, setShowForm] = useState(false);

  const fetchResidents = async () => {
    try {
      const res = await api.get('/residents');
      if (res.data.success) {
        setResidents(res.data.data);
      } else {
        setError('Gagal memuat daftar penghuni');
      }
    } catch {
      setError('Gagal memuat daftar penghuni');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => { fetchResidents(); }, []);

  const handleAdd = () => {
    setEditing(null);
    setShowForm(true);
  };

  const handleEdit = resident => {
    setEditing(resident);
    setShowForm(true);
  };

  const handleDelete = async id => {
    if (!confirm('Hapus data penghuni ini?')) return;
    try {
      const res = await api.delete(`/residents/${id}`);
      if (res.data.success) {
        setResidents(r => r.filter(x => x.id !== id));
      } else {
        alert('Gagal menghapus penghuni');
      }
    } catch {
      alert('Terjadi kesalahan saat menghapus penghuni');
    }
  };

  const handleSubmit = async data => {
    try {
      if (editing) {
        const res = await api.put(`/residents/${editing.id}`, data, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
        if (res.data.success) {
          setResidents(r => r.map(x => x.id === editing.id ? res.data.data : x));
        } else {
          alert('Gagal mengupdate penghuni');
        }
      } else {
        const res = await api.post('/residents', data, {
          headers: { 'Content-Type': 'multipart/form-data' },
        });
        if (res.data.success) {
          setResidents(r => [...r, res.data.data]);
        } else {
          alert('Gagal menambahkan penghuni');
        }
      }
      setShowForm(false);
    } catch {
      alert('Terjadi kesalahan saat menyimpan data penghuni');
    }
  };

  if (loading) return <p>Loading…</p>;
  if (error) return <p className="text-red-600">{error}</p>;

  return (
    <div className="p-6 space-y-4">
      <div className="flex justify-between items-center">
        <h1 className="text-2xl font-bold">Penghuni</h1>
        <button onClick={handleAdd} className="bg-green-600 text-white px-4 py-2 rounded">Tambah</button>
      </div>

      {showForm && (
        <ResidentForm
          initialData={editing}
          onSubmit={handleSubmit}
          onCancel={() => setShowForm(false)}
        />
      )}

      <table className="min-w-full table-auto border-collapse">
        <thead>
          <tr className="bg-gray-200">
            <th className="border px-3 py-2">Nama</th>
            <th className="border px-3 py-2">Status</th>
            <th className="border px-3 py-2">No. Telepon</th>
            <th className="border px-3 py-2">Menikah</th>
            <th className="border px-3 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          {residents.map(r => (
            <tr key={r.id} className="even:bg-gray-50">
              <td className="border px-3 py-2">{r.name}</td>
              <td className="border px-3 py-2">{r.status}</td>
              <td className="border px-3 py-2">{r.phone_number}</td>
              <td className="border px-3 py-2">{r.is_married ? 'Ya' : 'Tidak'}</td>
              <td className="border px-3 py-2 space-x-2">
                <button onClick={() => handleEdit(r)} className="text-blue-600">Edit</button>
                <button onClick={() => handleDelete(r.id)} className="text-red-600">Hapus</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
