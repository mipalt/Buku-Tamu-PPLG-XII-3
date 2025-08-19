import React, { useState } from 'react';

interface DeleteVisitorProps {
  id: number;
  onSuccess: () => void;
}

const DeleteVisitor: React.FC<DeleteVisitorProps> = ({ id, onSuccess }) => {
  const [loading, setLoading] = useState(false);

  const handleDelete = async () => {
    if (!confirm('Yakin mau menghapus data ini?')) return;
    setLoading(true);
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/guest-visitors/${id}`, {
        method: 'DELETE', // sesuai Route::apiResource
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer 1|8zyBAVvHRSeE8mwAeTmL7TuwjsDVbOMiEM10Exon3e29ec94'
        }
      });

      if (!response.ok) {
        const err = await response.json();
        alert(err.message || 'Gagal menghapus data');
        return;
      }

      onSuccess();
    } catch (error) {
      alert('Terjadi kesalahan saat menghapus data');
    } finally {
      setLoading(false);
    }
  };

  return (
    <button
      onClick={handleDelete}
      disabled={loading}
      className="bg-red-500 text-white px-4 py-2 rounded"
    >
      {loading ? 'Menghapus...' : 'Hapus'}
    </button>
  );
};

export default DeleteVisitor;
