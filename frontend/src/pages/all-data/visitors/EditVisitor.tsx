import React, { useState } from 'react';

interface Visitor {
  id: number;
  name: string;
  institution: string;
  phone: string;
  email: string;
}

interface EditVisitorProps {
  visitor: Visitor;
  onSuccess: () => void;
}

const EditVisitor: React.FC<EditVisitorProps> = ({ visitor, onSuccess }) => {
  const [form, setForm] = useState(visitor);
  const [loading, setLoading] = useState(false);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async () => {
    setLoading(true);
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/guest-visitors/${visitor.id}`, {
        method: 'PUT', // sesuai Route::apiResource
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer 2|CU89f1cBu9Od4g6w5IflwQzXs2p32Vl9RXel7FPOea57a91c'
        },
        body: JSON.stringify(form)
      });

      if (!response.ok) {
        const err = await response.json();
        alert(err.message || 'Gagal memperbarui data');
        return;
      }

      onSuccess();
    } catch (error) {
      alert('Terjadi kesalahan saat mengedit data');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="p-4 bg-white rounded shadow">
      <input
        name="name"
        value={form.name}
        onChange={handleChange}
        placeholder="Nama"
        className="border p-2 w-full mb-2"
      />
      <input
        name="institution"
        value={form.institution}
        onChange={handleChange}
        placeholder="Institusi"
        className="border p-2 w-full mb-2"
      />
      <input
        name="phone"
        value={form.phone}
        onChange={handleChange}
        placeholder="Telepon"
        className="border p-2 w-full mb-2"
      />
      <input
        name="email"
        value={form.email}
        onChange={handleChange}
        placeholder="Email"
        className="border p-2 w-full mb-2"
      />
      <button
        onClick={handleSubmit}
        disabled={loading}
        className="bg-blue-500 text-white px-4 py-2 rounded"
      >
        {loading ? 'Menyimpan...' : 'Simpan'}
      </button>
    </div>
  );
};

export default EditVisitor;
