// File: src/components/Residents/ResidentForm.jsx
import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';

export default function ResidentForm({ initialData, onSubmit, onCancel }) {
    const [form, setForm] = useState({
        name: '',
        status: 'tetap',
        phone_number: '',
        is_married: false,
        ktp_photo: null,
    });
    const [errors, setErrors] = useState({});

    useEffect(() => {
        if (initialData) {
            setForm({
                name: initialData.name || '',
                status: initialData.status || 'tetap',
                phone_number: initialData.phone_number || '',
                is_married: initialData.is_married || false,
                ktp_photo: null,
            });
        }
    }, [initialData]);

    const validate = () => {
        const errs = {};
        if (!form.name) errs.name = 'Name is required.';
        if (!['tetap', 'kontrak'].includes(form.status)) errs.status = 'Status must be "tetap" or "kontrak".';
        if (form.phone_number && !/^\d{9,15}$/.test(form.phone_number)) {
            errs.phone_number = 'Phone number must be 9-15 digits.';
        }
        if (typeof form.is_married !== 'boolean') errs.is_married = 'Marital status must be selected.';
        return errs;
    };

    const handleChange = e => {
        const { name, value, type, checked, files } = e.target;
        if (name === 'ktp_photo') {
            setForm(f => ({ ...f, ktp_photo: files[0] }));
        } else if (type === 'checkbox') {
            setForm(f => ({ ...f, [name]: checked }));
        } else {
            setForm(f => ({ ...f, [name]: value }));
        }
    };

    const handleSubmit = e => {
        e.preventDefault();
        const errs = validate();
        if (Object.keys(errs).length) {
            setErrors(errs);
            return;
        }
        const payload = new FormData();
        payload.append('name', form.name);
        payload.append('status', form.status);
        payload.append('phone_number', form.phone_number);
        payload.append('is_married', form.is_married ? '1' : '0');
        if (form.ktp_photo) payload.append('ktp_photo', form.ktp_photo);
        onSubmit(payload);
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4 p-4 bg-white rounded shadow">
            <div>
                <label className="block text-sm font-medium">Name</label>
                <input name="name" value={form.name} onChange={handleChange}
                    className="mt-1 block w-full border rounded p-2" />
                {errors.name && <p className="text-red-600 text-sm">{errors.name}</p>}
            </div>
            <div>
                <label className="block text-sm font-medium">Status</label>
                <select name="status" value={form.status} onChange={handleChange}
                    className="mt-1 block w-full border rounded p-2">
                    <option value="tetap">Tetap</option>
                    <option value="kontrak">Kontrak</option>
                </select>
                {errors.status && <p className="text-red-600 text-sm">{errors.status}</p>}
            </div>
            <div>
                <label className="block text-sm font-medium">Phone Number</label>
                <input name="phone_number" value={form.phone_number} onChange={handleChange}
                    className="mt-1 block w-full border rounded p-2" />
                {errors.phone_number && <p className="text-red-600 text-sm">{errors.phone_number}</p>}
            </div>
            <div>
                <label className="inline-flex items-center">
                    <input type="checkbox" name="is_married" checked={form.is_married} onChange={handleChange}
                        className="mr-2" />
                    Married
                </label>
                {errors.is_married && <p className="text-red-600 text-sm">{errors.is_married}</p>}
            </div>
            <div>
                <label className="block text-sm font-medium">KTP Photo</label>
                <input type="file" name="ktp_photo" onChange={handleChange}
                    className="mt-1 block w-full" accept="image/*" />
            </div>
            <div className="flex space-x-2">
                <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <button type="button" onClick={onCancel} className="bg-gray-300 px-4 py-2 rounded">Cancel</button>
            </div>
        </form>
    );
}

ResidentForm.propTypes = {
    initialData: PropTypes.object,
    onSubmit: PropTypes.func.isRequired,
    onCancel: PropTypes.func.isRequired,
};
