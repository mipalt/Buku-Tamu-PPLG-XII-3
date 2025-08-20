import React, { useState } from "react";
import {
  Search,
  ChevronDown,
  Eye,
  ChevronLeft,
  ChevronRight,
} from "lucide-react";
import DeleteVisitor from "./DeleteVisitor";
import { useFetch } from "../../../hooks/useFetch";
import { FileSpreadsheet } from "lucide-react";

interface TableRow {
  id: number;
  name: string;
  institution: string;
  purposes: {
    id: number;
    purpose: string;
    visitor_id: number;
    guest_type: string;
    created_at?: string;
    updated_at?: string;
  };
  phone: string;
  // email: string;
  signature_path?: string;
  created_at: string;
  updated_at: string;
}

const DataTable: React.FC = () => {
  const { data, error, isLoading, mutate } = useFetch<{ data: TableRow[] }>(
    "http://127.0.0.1:8000/api/guest-visitors"
  );

  const [searchTerm, setSearchTerm] = useState("");
  const [currentPage, setCurrentPage] = useState(1);
  const [rowsPerPage, setRowsPerPage] = useState(10);
  const [selectedIds, setSelectedIds] = useState<number[]>([]);

  // kalau API belum siap, kasih default []
  const rows = Array.isArray(data?.data) ? data!.data : [];

  const filteredData = rows.filter(
    (row) =>
      (row.name || "").toLowerCase().includes(searchTerm.toLowerCase()) ||
      (row.institution || "")
        .toLowerCase()
        .includes(searchTerm.toLowerCase()) ||
      (row.phone || "").toLowerCase().includes(searchTerm.toLowerCase())
      // (row.email || "").toLowerCase().includes(searchTerm.toLowerCase())
  );

  const totalPages = Math.max(1, Math.ceil(filteredData.length / rowsPerPage));
  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const currentData = filteredData.slice(startIndex, endIndex);

  // handle select all
  const handleSelectAll = (checked: boolean) => {
    if (checked) {
      setSelectedIds(currentData.map((row) => row.id));
    } else {
      setSelectedIds([]);
    }
  };

  // handle per row
  const handleSelectRow = (id: number, checked: boolean) => {
    if (checked) {
      setSelectedIds((prev) => [...prev, id]);
    } else {
      setSelectedIds((prev) => prev.filter((item) => item !== id));
    }
  };

  // warna label berdasarkan purpose
const getStatusColor = (purpose?: string) => {
  switch (purpose?.toLowerCase()) {
    case "LAINNYA":
      return "bg-blue-100 text-blue-800 border-blue-300";
    case "RAPOT":
      return "bg-green-100 text-green-800 border-green-300";
    case "MEETING":
      return "bg-yellow-100 text-yellow-800 border-yellow-300";
    case "lainnya":
      return "bg-gray-100 text-gray-800 border-gray-300";
    default:
      return "bg-gray-100 text-gray-800 border-gray-300";
  }
};

  return (
    <div className="w-full max-w-7xl mx-auto p-6 bg-white shadow rounded-xl">
      {/* Search */}
      <div className="flex items-center justify-between mb-6">
        <div className="flex items-center space-x-4">
          <button className="flex items-center space-x-2 px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
            <ChevronDown className="w-4 h-4" />
          </button>
          <div className="relative">
            <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
            <input
              type="text"
              placeholder="Cari..."
              value={searchTerm}
              onChange={(e) => {
                setSearchTerm(e.target.value);
                setCurrentPage(1);
              }}
              className="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>
        {/* eksport */}
<button className="flex items-center gap-1 bg-green-700 hover:bg-green-800 text-white text-xs font-medium px-3 py-2 rounded-full shadow-md transition">
  <FileSpreadsheet className="w-4 h-4" />
  EXPORT
</button>
      </div>

      {/* Error */}
      {error && (
        <div className="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
          {error.message}
        </div>
      )}

      {/* Table */}
      <div className="overflow-x-auto border border-gray-200 rounded-lg">
        {isLoading ? (
          <div className="p-6 text-center text-gray-500">Loading...</div>
        ) : currentData.length === 0 ? (
          <div className="p-6 text-center text-gray-500">Tidak ada data</div>
        ) : (
          <table className="min-w-full divide-y divide-gray-200">
            <thead className="bg-gray-50">
              <tr>
                <th className="px-4 py-3">
                  <input
                    type="checkbox"
                    checked={
                      selectedIds.length === currentData.length &&
                      currentData.length > 0
                    }
                    onChange={(e) => handleSelectAll(e.target.checked)}
                  />
                </th>
                {[
                  "#",
                  "NAMA",
                  "INSTANSI",
                  "KEPERLUAN",
                  "NO. TELEPON",
                  // "EMAIL",
                  "TANGGAL",
                  "AKSI",
                ].map((head) => (
                  <th
                    key={head}
                    className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    {head}
                  </th>
                ))}
              </tr>
            </thead>
            <tbody className="bg-white divide-y divide-gray-200">
              {currentData.map((row) => (
                <tr key={row.id} className="hover:bg-gray-50">
                  <td className="px-4 py-4">
                    <input
                      type="checkbox"
                      checked={selectedIds.includes(row.id)}
                      onChange={(e) =>
                        handleSelectRow(row.id, e.target.checked)
                      }
                    />
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {row.id}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {row.name}
                  </td>
                  <td className="px-6 py-4 text-sm text-gray-900 break-words max-w-xs">
                    {row.institution}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span
                      className={`inline-flex px-3 py-1 rounded-full text-xs font-medium border ${getStatusColor(
                        row.purposes?.purpose
                      )}`}
                    >
                      {row.purposes?.purpose || "-"}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {row.phone}
                  </td>
                  {/* <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {row.email}
                  </td> */}
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {new Date(row.created_at).toLocaleDateString("id-ID", {
                      day: "2-digit",
                      month: "2-digit",
                      year: "numeric",
                    })}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div className="flex items-center space-x-2">
                      {/* Hapus pakai komponen DeleteVisitor */}
                      <DeleteVisitor id={row.id} mutate={mutate} />

                      {/* Detail */}
                      <button className="text-gray-600 hover:text-gray-900 p-1">
                        <Eye className="w-4 h-4" />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </div>

      {/* Pagination */}
      <div className="flex items-center justify-between mt-6">
        <div className="text-sm text-gray-700">
          {startIndex + 1}-{Math.min(endIndex, filteredData.length)} of{" "}
          {filteredData.length}
        </div>
        <div className="flex items-center space-x-2">
          <select
            value={rowsPerPage}
            onChange={(e) => {
              setRowsPerPage(Number(e.target.value));
              setCurrentPage(1);
            }}
            className="border border-gray-300 rounded px-2 py-1 text-sm"
          >
            {[10, 25, 50].map((n) => (
              <option key={n} value={n}>
                {n}
              </option>
            ))}
          </select>
          <div className="flex items-center space-x-1 ml-4">
            <span className="text-sm text-gray-700">
              {currentPage}/{totalPages}
            </span>
            <button
              onClick={() => setCurrentPage(Math.max(1, currentPage - 1))}
              disabled={currentPage === 1}
              className="p-1 text-gray-600 hover:text-gray-900 disabled:text-gray-400"
            >
              <ChevronLeft className="w-4 h-4" />
            </button>
            <button
              onClick={() =>
                setCurrentPage(Math.min(totalPages, currentPage + 1))
              }
              disabled={currentPage === totalPages}
              className="p-1 text-gray-600 hover:text-gray-900 disabled:text-gray-400"
            >
              <ChevronRight className="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DataTable;
