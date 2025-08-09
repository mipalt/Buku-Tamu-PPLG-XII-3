// src/pages/dashboard/index.tsx
import Sidebar from "../auth/components/Sidebar";

// *** Perbaikan: naik 2 level dari src/pages/dashboard ke src, lalu ke assets ***
import OrangTuaIcon from "../../assets/orangtua-after.png";
import KunjunganIcon from "../../assets/kunjungan-after.png";
import AlumniIcon from "../../assets/alumni-after.png";
import PerusahaanIcon from "../../assets/perusahaan-after.png";

export default function Dashboard() {
  const stats = [
    { name: "Orang Tua", value: "200", icon: OrangTuaIcon },
    { name: "Kunjungan", value: "190.700", icon: KunjunganIcon },
    { name: "Alumni", value: "4.000", icon: AlumniIcon },
    { name: "Perusahaan", value: "4.000", icon: PerusahaanIcon },
  ];

  return (
    <div className="flex min-h-screen">
      <Sidebar />
      <div className="flex-1 flex flex-col">
        {/* Header biru tua */}
        <header className="bg-[#001E42] text-white flex justify-end items-center h-16 px-6">
          <button className="bg-[#001E42] px-4 py-2 rounded text-white flex items-center">
            Admin
          </button>
        </header>

        {/* Stats */}
        <main className="p-6">
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {stats.map((item) => (
              <div
                key={item.name}
                className="bg-[#FAFAFA] shadow rounded-xl p-4 flex items-center gap-4"
              >
                <div className="bg-[#001E42] p-3 rounded-lg">
                  <img src={item.icon} alt={item.name} className="w-6 h-6" />
                </div>
                <div>
                  <p className="text-sm font-bold">{item.name}</p>
                  <p className="text-lg font-bold">{item.value}</p>
                </div>
              </div>
            ))}
          </div>

          {/* Tambahkan konten lain (chart, tabel) di sini */}
        </main>
      </div>
    </div>
  );
}
