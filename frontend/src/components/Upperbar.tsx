import { useFetch } from "../hooks/useFetch";
import OrangTuaIcon from "../assets/orangtua-after.png";
import KunjunganIcon from "../assets/kunjungan-after.png";
import AlumniIcon from "../assets/alumni-after.png";
import PerusahaanIcon from "../assets/perusahaan-after.png";

// Asumsi base URL untuk API
const API_BASE_URL = "http://localhost:8000/api"; // Ganti dengan URL API Anda
// Asumsi token disimpan di localStorage
const token = localStorage.getItem("token") || ""; // Ganti dengan cara Anda mengelola token

export default function Upperbar() {
  // Mengambil data dari masing-masing endpoint
  const { data: parentsData, isLoading: parentsLoading, error: parentsError } = useFetch<{ data: any[] }>(
    `${API_BASE_URL}/guest-parents`,
    token
  );
  const { data: visitorsData, isLoading: visitorsLoading, error: visitorsError } = useFetch<{ data: any[] }>(
    `${API_BASE_URL}/guest-visitors`,
    token
  );
  const { data: alumniData, isLoading: alumniLoading, error: alumniError } = useFetch<{ data: any[] }>(
    `${API_BASE_URL}/guest-alumni`,
    token
  );
  const { data: companiesData, isLoading: companiesLoading, error: companiesError } = useFetch<{ data: any[] }>(
    `${API_BASE_URL}/guest-companies`,
    token
  );

  // Membuat array stats berdasarkan data dari API
  const stats = [
  {
    name: "Orang Tua",
    value: parentsLoading
      ? "Loading..."
      : parentsError
        ? "Error"
        : parentsData?.meta?.pagination?.total_data?.toString() || "0",
    icon: OrangTuaIcon,
  },
  {
    name: "Kunjungan",
    value: visitorsLoading
      ? "Loading..."
      : visitorsError
        ? "Error"
        : visitorsData?.meta?.pagination?.total_data?.toString() || "0",
    icon: KunjunganIcon,
  },
  {
    name: "Alumni",
    value: alumniLoading
      ? "Loading..."
      : alumniError
        ? "Error"
        : alumniData?.meta?.pagination?.total_data?.toString() || "0",
    icon: AlumniIcon,
  },
  {
    name: "Perusahaan",
    value: companiesLoading
      ? "Loading..."
      : companiesError
        ? "Error"
        : companiesData?.meta?.pagination?.total_data?.toString() || "0",
    icon: PerusahaanIcon,
  },
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
              className="bg-[#FAFAFA] shadow rounded-xl p-4 flex items-center gap-4 transition-all duration-300 ease-out transform hover:scale-105 hover:shadow-lg hover:shadow-gray-200 cursor-pointer"
            >
              <div className="bg-[#001E42] p-3 rounded-lg transition-all duration-300 ease-out group-hover:bg-[#002855]">
                <img src={item.icon} alt={item.name} className="w-6 h-6 transition-all duration-200" />
              </div>
              <div>
                <p className="text-sm font-bold transition-colors duration-200">{item.name}</p>
                <p className="text-lg font-bold transition-colors duration-200">{item.value}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </>
  );
}