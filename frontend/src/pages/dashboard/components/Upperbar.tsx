import OrangTuaIcon from "../../../assets/orangtua-after.png";
import KunjunganIcon from "../../../assets/kunjungan-after.png";
import AlumniIcon from "../../../assets/alumni-after.png";
import PerusahaanIcon from "../../../assets/perusahaan-after.png";

export default function Upperbar() {
  const stats = [
    { name: "Orang Tua", value: "200", icon: OrangTuaIcon },
    { name: "Kunjungan", value: "190.700", icon: KunjunganIcon },
    { name: "Alumni", value: "4.000", icon: AlumniIcon },
    { name: "Perusahaan", value: "4.000", icon: PerusahaanIcon },
  ];

  return (
    <>
      <header className="bg-[#001E42] text-white flex items-center justify-end h-20 px-6">
        <h1 className="text-lg font-bold">Admin</h1>
      </header>

      <div className="p-6">
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
      </div>
    </>
  );
}
