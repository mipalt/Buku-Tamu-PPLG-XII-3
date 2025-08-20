import React from "react";
import { Trash2 } from "lucide-react";

interface DeleteVisitorProps {
  id: number;
  mutate: () => void;
}

const DeleteVisitor: React.FC<DeleteVisitorProps> = ({ id, mutate }) => {
  const handleDelete = async () => {
    if (!confirm("Yakin hapus data ini?")) return;

    try {
      await fetch(`http://127.0.0.1:8000/api/guest-visitors/${id}`, {
        method: "DELETE",
      });
      mutate(); // refresh data
    } catch (error) {
      console.error("Gagal hapus data", error);
    }
  };

  return (
    <button
      onClick={handleDelete}
      className="text-red-600 hover:text-red-800 p-1"
    >
      <Trash2 className="w-4 h-4" />
    </button>
  );
};

export default DeleteVisitor;
