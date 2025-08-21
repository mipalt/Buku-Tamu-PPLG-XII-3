import React, { useEffect, useState } from "react";
import { Search, Eye, Trash2, ChevronLeft, ChevronRight } from "lucide-react";
import { useFetch } from "../../../hooks/useFetch";
import Loader from "../../../components/Loader";

// Definisikan interface untuk respons API
interface GuestCompany {
  id: number;
  name: string; // Nama penanggung jawab
  company_name: string; // Nama perusahaan
  phone: string;
  email: string;
  signature_path?: string;
  created_at?: string;
  updated_at?: string;
  purposes: {
    id: number;
    purpose: string;
    visitor_id: number;
    guest_type: string;
    created_at?: string;
    updated_at?: string;
  };
  action?: string;
}

// Definisikan interface untuk respons API lengkap
interface ApiResponse {
  success: boolean;
  message: string;
  data: GuestCompany[];
  meta?: {
    pagination: {
      total_data: number;
      per_page: number;
      current_page: number;
      last_page: number;
      next_page?: string;
      prev_page?: string;
      has_more?: boolean;
    };
  };
}

const Company: React.FC = () => {
  const [token, setToken] = useState<string | null>(localStorage.getItem("token"));
  const [searchTerm, setSearchTerm] = useState("");
  const [currentPage, setCurrentPage] = useState(1);
  const [rowsPerPage, setRowsPerPage] = useState(10);
  const [sortColumn, setSortColumn] = useState<"id" | "company_name" | null>(null);
  const [sortDirection, setSortDirection] = useState<"asc" | "desc">("asc");
  const [selectAll, setSelectAll] = useState(false);
  const [selectedIds, setSelectedIds] = useState<number[]>([]);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [deleteId, setDeleteId] = useState<number | null>(null);
  const [exportFormat, setExportFormat] = useState<"Xlsx" | "Csv">("Xlsx");
  const [isModalVisible, setIsModalVisible] = useState(false);

  useEffect(() => {
    const storedToken = localStorage.getItem("token");
    if (storedToken && storedToken !== token) {
      setToken(storedToken);
    }
    // Hanya set rowsPerPage jika data sudah tersedia
    if (data && data.meta?.pagination?.per_page) {
      setRowsPerPage(data.meta.pagination.per_page);
    }
  }, [token]); // Hapus 'data' dari dependency array

  const { data, error, isLoading } = useFetch<ApiResponse>(
    `http://localhost:8000/api/guest-companies?page=${currentPage}&per_page=${rowsPerPage}`,
    token
  );

  // Function untuk mendapatkan warna status badge
  const getStatusColor = (purpose: string) => {
    if (purpose.toUpperCase().includes("BERTEMU")) {
      return "bg-blue-100 text-blue-700 border-blue-200";
    } else if (purpose.toUpperCase().includes("KERJA SAMA")) {
      return "bg-purple-100 text-purple-700 border-purple-200";
    } else {
      return "bg-gray-100 text-gray-700 border-gray-200";
    }
  };

  // Filter data berdasarkan search term jika data tersedia
  const filteredData = data?.data?.filter(company =>
    (company.company_name?.toLowerCase() || "").includes(searchTerm.toLowerCase()) ||
    (company.name?.toLowerCase() || "").includes(searchTerm.toLowerCase())
  ) || [];

  // Fungsi untuk mengurutkan data
  const sortedData = [...filteredData].sort((a, b) => {
    if (!sortColumn) return 0;
    const aValue = sortColumn === "id" ? a.id : a.company_name?.toLowerCase() || "";
    const bValue = sortColumn === "id" ? b.id : b.company_name?.toLowerCase() || "";
    if (sortDirection === "asc") {
      return aValue > bValue ? 1 : -1;
    } else {
      return aValue < bValue ? 1 : -1;
    }
  });

  // Logika pagination
  const indexOfLastRow = currentPage * rowsPerPage;
  const indexOfFirstRow = indexOfLastRow - rowsPerPage;
  const currentRows = sortedData.slice(indexOfFirstRow, indexOfLastRow);
  const totalPages = data?.meta?.pagination?.last_page || 1;
  const totalData = data?.meta?.pagination?.total_data || sortedData.length;

  const handleNextPage = () => {
    if (currentPage < totalPages) {
      setCurrentPage(currentPage + 1);
    }
  };

  const handlePrevPage = () => {
    if (currentPage > 1) {
      setCurrentPage(currentPage - 1);
    }
  };

  // Fungsi untuk menangani klik header untuk pengurutan
  const handleSort = (column: "id" | "company_name") => {
    if (sortColumn === column) {
      setSortDirection(sortDirection === "asc" ? "desc" : "asc");
    } else {
      setSortColumn(column);
      setSortDirection("asc");
    }
    setCurrentPage(1); // Reset ke halaman pertama saat mengurutkan
  };

  // Fungsi untuk select all checkbox
  const handleSelectAll = (e: React.ChangeEvent<HTMLInputElement>) => {
    const checked = e.target.checked;
    setSelectAll(checked);
    if (checked) {
      setSelectedIds(currentRows.map((company) => company.id));
    } else {
      setSelectedIds([]);
    }
  };

  // Fungsi untuk checkbox per baris
  const handleCheckboxChange = (id: number, checked: boolean) => {
    if (checked) {
      setSelectedIds([...selectedIds, id]);
    } else {
      setSelectedIds(selectedIds.filter((selectedId) => selectedId !== id));
    }
  };

  // Fungsi untuk tampilkan modal delete dengan animasi smooth
  const confirmDelete = (id: number) => {
    setDeleteId(id);
    setShowDeleteModal(true);
    // Delay sedikit untuk memastikan DOM sudah ter-render
    setTimeout(() => {
      setIsModalVisible(true);
    }, 10);
  };

  // Fungsi untuk menutup modal dengan animasi smooth
  const closeModal = () => {
    setIsModalVisible(false);
    // Tunggu animasi selesai sebelum menghilangkan modal dari DOM
    setTimeout(() => {
      setShowDeleteModal(false);
      setDeleteId(null);
    }, 300);
  };

  // Fungsi untuk hapus data via API
  const performDelete = async () => {
    if (!deleteId || !token) return;
    try {
      const response = await fetch(`http://localhost:8000/api/guest-companies/${deleteId}`, {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
        },
      });
      if (!response.ok) {
        throw new Error("Failed to delete");
      }
      // Update state lokal: Hapus item dari data
      const updatedData = filteredData.filter((company) => company.id !== deleteId);
      data.data = updatedData; // Update data dari useFetch (asumsi data mutable)
      closeModal();
      alert("Data berhasil dihapus");
    } catch (err) {
      console.error(err);
      alert("Gagal menghapus data");
    }
  };

  // Fungsi untuk export data
  const handleExport = async () => {
    if (!token) {
      alert("Token tidak ditemukan. Silakan login ulang.");
      return;
    }
    try {
      const params = new URLSearchParams({
        type: "companies",
        format: exportFormat,
      });
      const response = await fetch(`http://localhost:8000/api/export?${params.toString()}`, {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      if (!response.ok) {
        throw new Error("Failed to export data");
      }
      const blob = await response.blob();
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = `guest_companies.${exportFormat.toLowerCase()}`;
      document.body.appendChild(a);
      a.click();
      a.remove();
      window.URL.revokeObjectURL(url);
    } catch (err) {
      console.error(err);
      alert("Gagal mengekspor data");
    }
  };

  // Fungsi placeholder untuk view
  const handleView = (id: number) => {
    console.log(`View company with id: ${id}`);
  };

  if (isLoading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-lg">Loading...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-lg text-red-600">Error loading data</div>
      </div>
    );
  }

  if (!data || !data.data || !Array.isArray(data.data)) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-lg">No data available</div>
      </div>
    );
  }

  return (
    <div className="bg-white min-h-screen">
      <div className="overflow-x-auto">
        <table className="min-w-full table-auto lg:table-fixed">
          <thead className="bg-[#F4F7FC] border-b border-gray-200">
            <tr>
              <th colSpan={8} className="px-6 py-4 text-left">
                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-4">
                    <div className="w-8 h-8 bg-white rounded flex items-center justify-center border border-gray-300">
                      <svg
                        className="w-4 h-4 text-gray-700"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          strokeLinecap="round"
                          strokeLinejoin="round"
                          strokeWidth={2}
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"
                        />
                      </svg>
                    </div>
                    <div className="relative">
                      <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-700 w-4 h-4" />
                      <input
                        type="text"
                        placeholder="Cari..."
                        value={searchTerm}
                        onChange={(e) => {
                          setSearchTerm(e.target.value);
                          setCurrentPage(1);
                        }}
                        className="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-80 bg-white text-gray-700 placeholder-gray-400"
                      />
                    </div>
                  </div>
                  <div className="flex items-center space-x-4">
                    <select
                      value={exportFormat}
                      onChange={(e) => setExportFormat(e.target.value as "Xlsx" | "Csv")}
                      className="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-gray-700"
                    >
                      <option value="Xlsx">Xlsx</option>
                      <option value="Csv">Csv</option>
                    </select>
                    <button
                      className="bg-[#14804A] hover:bg-teal-700 text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition-colors"
                      onClick={handleExport}
                    >
                      <svg
                        className="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          strokeLinecap="round"
                          strokeLinejoin="round"
                          strokeWidth={2}
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                      </svg>
                      <span>EXPORT</span>
                    </button>
                  </div>
                </div>
              </th>
            </tr>
            <tr>
              <th className="px-6 py-4 text-left">
                <input
                  type="checkbox"
                  className="rounded border-gray-300"
                  checked={selectAll}
                  onChange={handleSelectAll}
                />
              </th>
              <th
                className="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                onClick={() => handleSort("id")}
                aria-sort={sortColumn === "id" ? sortDirection : "none"}
              >
                <div className="flex items-center space-x-1">
                  <span>#</span>
                  {sortColumn === "id" && (
                    <span className="text-gray-500 text-sm">
                      {sortDirection === "asc" ? "▲" : "▼"}
                    </span>
                  )}
                </div>
              </th>
              <th
                className="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                onClick={() => handleSort("company_name")}
                aria-sort={sortColumn === "company_name" ? sortDirection : "none"}
              >
                <div className="flex items-center space-x-1">
                  <span>NAMA PERUSAHAAN</span>
                  {sortColumn === "company_name" && (
                    <span className="text-gray-500 text-sm">
                      {sortDirection === "asc" ? "▲" : "▼"}
                    </span>
                  )}
                </div>
              </th>
              <th className="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                PENANGGUNG JAWAB
              </th>
              <th className="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                KEPERLUAN
              </th>
              <th className="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                NO. TELEPON
              </th>
              <th className="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                EMAIL
              </th>
              <th className="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                AKSI
              </th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-200">
            {currentRows.map((company, index) => (
              <tr key={company.id} className="even:bg-gray-50 hover:bg-gray-100">
                <td className="px-6 py-4 whitespace-nowrap">
                  <input
                    type="checkbox"
                    className="rounded border-gray-300"
                    checked={selectedIds.includes(company.id)}
                    onChange={(e) => handleCheckboxChange(company.id, e.target.checked)}
                  />
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {index + 1 + indexOfFirstRow}
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  {company.company_name || "-"}
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {company.name || "-"}
                </td>
                <td className="px-6 py-4 whitespace-nowrap">
                  <span
                    className={`inline-flex px-3 py-1 rounded-full text-xs font-medium border ${getStatusColor(
                      company.purposes?.purpose || "UNKNOWN"
                    )}`}
                  >
                    {company.purposes?.purpose || "-"}
                  </span>
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {company.phone || "-"}
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-blue-600">
                  {company.email && company.email !== "-" ? (
                    <a href={`mailto:${company.email}`} className="hover:text-blue-800">
                      {company.email}
                    </a>
                  ) : (
                    <span className="text-gray-400">-</span>
                  )}
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <button
                    className="text-red-600 hover:text-red-800 p-1 rounded"
                    onClick={() => confirmDelete(company.id)}
                    aria-label={`Hapus ${company.company_name || "perusahaan"}`}
                  >
                    <Trash2 className="w-4 h-4" />
                  </button>
                  <button
                    className="text-gray-600 hover:text-gray-800 p-1 rounded"
                    onClick={() => handleView(company.id)}
                    aria-label={`Lihat detail ${company.company_name || "perusahaan"}`}
                  >
                    <Eye className="w-4 h-4" />
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      {/* Pagination Section */}
      <div className="bg-[#F4F7FC] flex items-center justify-between px-6 py-4 border-t border-gray-200">
        <div className="flex items-center space-x-2 text-sm text-gray-500">
          <span>
            {indexOfFirstRow + 1}-{Math.min(indexOfLastRow, totalData)} of {totalData}
          </span>
        </div>
        <div className="flex items-center space-x-4">
          <div className="flex items-center space-x-2 text-sm text-gray-500">
            <span>Rows per page:</span>
            <select
              className="border border-gray-300 rounded px-2 py-1 text-sm"
              value={rowsPerPage}
              onChange={(e) => {
                setRowsPerPage(Number(e.target.value));
                setCurrentPage(1); // Reset ke halaman 1 saat rowsPerPage berubah
              }}
            >
              <option>10</option>
              <option>25</option>
              <option>50</option>
            </select>
          </div>
          <div className="flex items-center space-x-1">
            <span className="text-sm text-gray-500">{currentPage}/{totalPages}</span>
            <button
              className="p-1 rounded hover:bg-gray-100"
              onClick={handlePrevPage}
              disabled={currentPage === 1}
            >
              <ChevronLeft className="w-4 h-4 text-gray-400" />
            </button>
            <button
              className="p-1 rounded hover:bg-gray-100"
              onClick={handleNextPage}
              disabled={currentPage === totalPages}
            >
              <ChevronRight className="w-4 h-4 text-gray-400" />
            </button>
          </div>
        </div>
      </div>
      {/* Modal Konfirmasi Delete dengan Animasi Smooth */}
      {showDeleteModal && (
        <div
          className={`fixed inset-0 flex items-center justify-center z-50 transition-all duration-300 ${isModalVisible ? "bg-black bg-opacity-30 backdrop-blur-sm" : "bg-transparent"
            }`}
        >
          <div
            className={`bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 relative transform transition-all duration-300 ease-out ${isModalVisible
                ? "scale-100 opacity-100 translate-y-0"
                : "scale-95 opacity-0 translate-y-4"
              }`}
          >
            {/* Close Button */}
            <button
              className="absolute top-4 right-4 text-gray-400 hover:text-gray-600 w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors duration-200"
              onClick={closeModal}
            >
              <svg
                className="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>

            {/* Modal Content */}
            <div className="p-6">
              {/* Icon */}
              <div className="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full">
                <svg
                  className="w-8 h-8 text-red-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
              </div>
              {/* Title & Description */}
              <div className="text-center">
                <h3 className="text-xl font-semibold text-gray-900 mb-2">Hapus Data</h3>
                <p className="text-gray-600 mb-6">
                  Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat
                  dibatalkan.
                </p>
              </div>
              {/* Action Buttons */}
              <div className="flex justify-center space-x-3">
                <button
                  className="px-6 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200 transform hover:scale-105"
                  onClick={closeModal}
                >
                  Batal
                </button>
                <button
                  className="px-6 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg font-medium transition-colors duration-200 transform hover:scale-105 shadow-md"
                  onClick={performDelete}
                >
                  Hapus
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Company;