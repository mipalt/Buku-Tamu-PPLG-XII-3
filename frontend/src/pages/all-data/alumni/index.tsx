import React from "react";
import { Trash2, Eye, Search, Download } from "lucide-react";

const alumniData = [
  {
    id: 1,
    nama: "Ann Culhane",
    telp: "081234567",
    lulusan: 2020,
    keperluan: "RAPOT",
    jurusan: "PPLG",
    tanggal: "1/1/2008",
  },
  {
    id: 2,
    nama: "Ahmad Rosser",
    telp: "081234567",
    lulusan: 2000,
    keperluan: "MEETING",
    jurusan: "MPLB",
    tanggal: "1/2/3213",
  },
  {
    id: 3,
    nama: "pedrik",
    telp: "0812345678",
    lulusan: 2001,
    keperluan: "RAPOT",
    jurusan: "PPLG",
    tanggal: "2/1/2007",
  },
  {
    id: 4,
    nama: "Leo Stanton",
    telp: "0812345678",
    lulusan: 2010,
    keperluan: "MEETING",
    jurusan: "TJKT",
    tanggal: "1/1/1999",
  },
  {
    id: 5,
    nama: "Kaiya Vetrovs",
    telp: "081234567",
    lulusan: 2022,
    keperluan: "RAPOT",
    jurusan: "DKV",
    tanggal: "9/10/1221",
  },
];

function Alumni() {
  return (
    <div className="p-6 bg-white min-h-screen">
      {/* Header filter + export */}
      <div className="flex justify-between items-center mb-4">
        <div className="relative">
          <Search className="absolute left-3 top-2.5 text-gray-400 w-4 h-4" />
          <input
            type="text"
            placeholder="Cari..."
            className="border rounded-lg pl-9 pr-3 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <button className="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
          <Download className="w-4 h-4" />
          EXPORT
        </button>
      </div>

      {/* Tabel */}
      <div className="overflow-x-auto bg-white rounded-lg shadow">
        <table className="w-full border-collapse">
          <thead className="bg-gray-100 text-gray-600 text-sm uppercase">
            <tr>
              <th className="p-3 text-left">
                <input type="checkbox" />
              </th>
              <th className="p-3 text-left">#</th>
              <th className="p-3 text-left">Nama</th>
              <th className="p-3 text-left">Lulusan Tahun</th>
              <th className="p-3 text-left">Keperluan</th>
              <th className="p-3 text-left">Jurusan</th>
              <th className="p-3 text-left">Tanggal</th>
              <th className="p-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody className="text-gray-700">
            {alumniData.map((alumni, index) => (
              <tr
                key={alumni.id}
                className=" hover:bg-gray-50 transition"
              >
                <td className="p-3">
                  <input type="checkbox" />
                </td>
                <td className="p-3">{index + 1}</td>
                <td className="p-3">
                  <div className="font-medium">{alumni.nama}</div>
                  <div className="text-sm text-gray-500">{alumni.telp}</div>
                </td>
                <td className="p-3">{alumni.lulusan}</td>
                <td className="p-3">
                  <span
                    className={`px-2 py-1 text-xs font-semibold rounded-md ${
                      alumni.keperluan === "RAPOT"
                        ? "bg-blue-100 text-blue-600"
                        : "bg-green-100 text-green-600"
                    }`}
                  >
                    {alumni.keperluan}
                  </span>
                </td>
                <td className="p-3">{alumni.jurusan}</td>
                <td
                  className={`p-3 ${
                    alumni.tanggal.includes("202") || alumni.tanggal.includes("3213")
                      ? "text-green-600"
                      : "text-red-500"
                  }`}
                >
                  {alumni.tanggal}
                </td>
                <td className="p-3 flex gap-3">
                  <button className="text-red-500 hover:text-red-700">
                    <Trash2 className="w-5 h-5" />
                  </button>
                  <button className="text-gray-600 hover:text-black">
                    <Eye className="w-5 h-5" />
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      {/* Footer pagination */}
      <div className="flex justify-between items-center mt-4 text-sm text-gray-600">
        <div>1-10 of 97</div>
        <div className="flex items-center gap-2">
          <span>Rows per page: 10</span>
          <button className="px-2 py-1 border rounded">{"<"}</button>
          <span>1/10</span>
          <button className="px-2 py-1 border rounded">{">"}</button>
        </div>
      </div>
    </div>
  );
}

export default Alumni;
