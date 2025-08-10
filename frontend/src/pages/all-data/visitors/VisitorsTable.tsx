export default function VisitorsTable() {
  const data = [
    {
      id: 1,
      nama: "Ann Culhane",
      instansi: "CIAWI 1",
      keperluan: "RAPOT",
      kontak: "082123221234",
      tanggal: "1/1/2008",
    },
    {
      id: 2,
      nama: "Ahmad Rosser",
      instansi: "TAJUR 6",
      keperluan: "MEETING",
      kontak: "08989001234",
      tanggal: "1/2/3213",
    },
  ];

  const badgeColor = (type: string) => {
    switch (type) {
      case "RAPOT":
        return "bg-blue-100 text-blue-600";
      case "MEETING":
        return "bg-green-100 text-green-600";
      default:
        return "bg-gray-100 text-gray-600";
    }
  };

  return (
    <div className="bg-white p-4 rounded-lg shadow">
      <div className="flex justify-between items-center mb-4">
        <input
          type="text"
          placeholder="Cari..."
          className="border rounded px-3 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>
      <table className="w-full border-collapse">
        <thead>
          <tr className="bg-gray-100 text-gray-700">
            <th className="py-2 px-3 text-left">#</th>
            <th className="py-2 px-3 text-left">Nama</th>
            <th className="py-2 px-3 text-left">Instansi</th>
            <th className="py-2 px-3 text-left">Keperluan</th>
            <th className="py-2 px-3 text-left">No. Telepon</th>
            <th className="py-2 px-3 text-left">Tanggal</th>
            <th className="py-2 px-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          {data.map((row, idx) => (
            <tr
              key={row.id}
              className="border-b hover:bg-gray-50 transition"
            >
              <td className="py-2 px-3">{idx + 1}</td>
              <td className="py-2 px-3">{row.nama}</td>
              <td className="py-2 px-3">{row.instansi}</td>
              <td className="py-2 px-3">
                <span
                  className={`px-2 py-1 rounded-full text-xs font-semibold ${badgeColor(
                    row.keperluan
                  )}`}
                >
                  {row.keperluan}
                </span>
              </td>
              <td className="py-2 px-3">{row.kontak || "-"}</td>
              <td className="py-2 px-3">{row.tanggal}</td>
              <td className="py-2 px-3 flex justify-center gap-2">
                <button className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                  Edit
                </button>
                <button className="text-red-500 hover:text-red-700">
                  hapus
                </button>
                <button className="text-gray-500 hover:text-gray-700">
                  view
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
