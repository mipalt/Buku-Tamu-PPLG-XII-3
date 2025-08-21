import { useState, useEffect } from "react";
import { NavLink, useLocation } from "react-router-dom";

import Logo from "../assets/logo.png";
import DashboardAfter from "../assets/dashboard-after.png";
import DashboardBefore from "../assets/dashboard-before.png";
import AllDataAfter from "../assets/all-data-after.png";
import AllDataBefore from "../assets/all-data-before.png";
import OrangTuaAfter from "../assets/orangtua-after.png";
import OrangTuaBefore from "../assets/orangtua-before.png";
import AlumniAfter from "../assets/alumni-after.png";
import AlumniBefore from "../assets/alumni-before.png";
import KunjunganAfter from "../assets/kunjungan-after.png";
import KunjunganBefore from "../assets/kunjungan-before.png";
import PerusahaanAfter from "../assets/perusahaan-after.png";
import PerusahaanBefore from "../assets/perusahaan-before.png";
import LogoutIcon from "../assets/Logout.png";
import Loader from "./Loader";


const Sidebar: React.FC = () => {
  const location = useLocation();
  const [isAllDataOpen, setAllDataOpen] = useState(false);

  const allDataSubMenu = [
    {
      name: "Orang Tua",
      path: "/parent",
      after: OrangTuaAfter,
      before: OrangTuaBefore,
    },
    {
      name: "Alumni",
      path: "/alumni",
      after: AlumniAfter,
      before: AlumniBefore,
    },
    {
      name: "Kunjungan",
      path: "/visitor",
      after: KunjunganAfter,
      before: KunjunganBefore,
    },
    {
      name: "Perusahaan",
      path: "/company",
      after: PerusahaanAfter,
      before: PerusahaanBefore,
    },
  ];

  // cek apakah salah satu submenu aktif
  const isSubmenuActive = allDataSubMenu.some((item) =>
    location.pathname.startsWith(item.path)
  );

  // Auto-expand submenu jika ada item yang aktif
  useEffect(() => {
    if (isSubmenuActive) {
      setAllDataOpen(true);
    }
  }, [isSubmenuActive]);

  const getMenuClass = (isActive: boolean, isSubmenu = false) =>
    isActive
      ? "flex items-center w-full p-3 rounded-lg mb-2 transition-all duration-300 ease-out transform bg-[#001E42] text-white shadow-md"
      : `flex items-center w-full p-3 rounded-lg mb-2 transition-all duration-300 ease-out transform hover:scale-[1.02] hover:shadow-sm ${isSubmenu
        ? "bg-[#CBD5E1] text-black hover:bg-[#BFD1EA] ml-4"
        : "bg-[#E2E8F0] text-black hover:bg-[#BFD1EA]"
      }`;

  return (
    <aside
      className="bg-[#F3F3F3] h-screen w-64 flex flex-col border-r transition-all duration-300 flex-shrink-0"
      style={{ borderColor: "#D9D9D9" }}
    >
      {/* Logo */}
      <div
        className="flex items-center justify-start h-20 px-4 border-b transition-all duration-300"
        style={{ borderColor: "#D9D9D9" }}
      >
        <img src={Logo} alt="Logo" className="w-10 h-10 mr-2" />
        <h1 className="text-xl font-bold text-black">BukuTamu</h1>
      </div>

      {/* Menu */}
      <nav className="flex-1 p-4">
        {/* Dashboard */}
        <NavLink
          to="/"
          className={({ isActive }) => getMenuClass(isActive)}
        >
          {({ isActive }) => (
            <>
              <img
                src={isActive ? DashboardAfter : DashboardBefore}
                alt="Dashboard"
                className="w-5 h-5 transition-all duration-200"
              />
              <span className="ml-3 font-medium">Dashboard</span>
            </>
          )}
        </NavLink>

        {/* All Data */}
        <div className="relative">
          <button
            onClick={() => setAllDataOpen((prev) => !prev)}
            className={`flex items-center w-full p-3 rounded-lg mb-2 justify-between transition-all duration-300 ease-out cursor-pointer transform hover:scale-[1.02] hover:shadow-sm ${isSubmenuActive
                ? "bg-[#05254B] text-white shadow-md"
                : "bg-[#E2E8F0] text-black hover:bg-[#BFD1EA]"
              }`}
          >
            <div className="flex items-center">
              <img
                src={isSubmenuActive ? AllDataAfter : AllDataBefore}
                alt="All Data"
                className="w-5 h-5 transition-all duration-200"
              />
              <span className="ml-3 font-medium">All Data</span>
            </div>
            <span className={`transition-transform duration-300 ease-out ${isAllDataOpen ? "rotate-90" : "rotate-0"
              }`}>
              ▸
            </span>
          </button>

          {/* Submenu dengan smooth animation */}
          <div className={`overflow-hidden transition-all duration-500 ease-out ${isAllDataOpen ? "max-h-96 opacity-100" : "max-h-0 opacity-0"
            }`}>
            <div className="space-y-1 pb-2">
              {allDataSubMenu.map((item, index) => (
                <div
                  key={item.name}
                  className={`transform transition-all duration-300 ease-out ${isAllDataOpen
                      ? "translate-y-0 opacity-100"
                      : "-translate-y-2 opacity-0"
                    }`}
                  style={{
                    transitionDelay: isAllDataOpen ? `${index * 75}ms` : "0ms"
                  }}
                >
                  <NavLink
                    to={item.path}
                    className={({ isActive }) => getMenuClass(isActive, true)}
                  >
                    {({ isActive }) => (
                      <>
                        <img
                          src={isActive ? item.after : item.before}
                          alt={item.name}
                          className="w-5 h-5 transition-all duration-200"
                        />
                        <span className="ml-3 font-medium text-sm">{item.name}</span>
                      </>
                    )}
                  </NavLink>
                </div>
              ))}
            </div>
          </div>
        </div>
      </nav>

      {/* Logout */}
      <div className="p-4">
        <button className="flex items-center w-full p-3 rounded-lg bg-[#DCE4F2] hover:bg-[#BFD1EA] text-black transition-all duration-300 ease-out transform hover:scale-[1.02] hover:shadow-sm">
          <img src={LogoutIcon} alt="Logout" className="w-5 h-5 transition-all duration-200" />
          <span className="ml-3 font-medium">Logout</span>
        </button>
      </div>
    </aside>
  );
};

export default Sidebar;