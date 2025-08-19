import { useState } from "react";
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

  const getMenuClass = (isActive: boolean, isSubmenu = false) =>
    isActive
      ? "flex items-center w-full p-2 rounded mb-2 transition bg-[#001E42] text-white"
      : `flex items-center w-full p-2 rounded mb-2 transition ${
          isSubmenu
            ? "bg-[#CBD5E1] text-black hover:bg-[#BFD1EA]"
            : "bg-[#E2E8F0] text-black hover:bg-[#BFD1EA]"
        }`;

  return (
    <aside
      className="bg-[#F3F3F3] h-screen w-64 flex flex-col border-r"
      style={{ borderColor: "#D9D9D9" }}
    >
      {/* Logo */}
      <div
        className="flex items-center justify-start h-20 px-4 border-b"
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
                className="w-5 h-5"
              />
              <span className="ml-2">Dashboard</span>
            </>
          )}
        </NavLink>

        {/* All Data */}
        <div>
          <button
            onClick={() => setAllDataOpen((prev) => !prev)}
            className={`flex items-center w-full p-2 rounded mb-2 justify-between transition cursor-pointer ${
              isSubmenuActive
                ? "bg-[#05254B] text-white"
                : "bg-[#E2E8F0] text-black hover:bg-[#BFD1EA]"
            }`}
          >
            <div className="flex items-center">
              <img
                src={isSubmenuActive ? AllDataAfter : AllDataBefore}
                alt="All Data"
                className="w-5 h-5"
              />
              <span className="ml-2">All Data</span>
            </div>
            <span>{isAllDataOpen ? "▾" : "▸"}</span>
          </button>

          {/* Submenu */}
          {isAllDataOpen && (
            <div className="ml-0 space-y-2">
              {allDataSubMenu.map((item) => (
                <NavLink
                  key={item.name}
                  to={item.path}
                  className={({ isActive }) => getMenuClass(isActive, true)}
                >
                  {({ isActive }) => (
                    <>
                      <img
                        src={isActive ? item.after : item.before}
                        alt={item.name}
                        className="w-5 h-5"
                      />
                      <span className="ml-2">{item.name}</span>
                    </>
                  )}
                </NavLink>
              ))}
            </div>
          )}
        </div>
      </nav>

      {/* Logout */}
      <div className="p-4">
        <button className="flex items-center w-full p-2 rounded bg-[#DCE4F2] hover:bg-[#BFD1EA] text-black">
          <img src={LogoutIcon} alt="Logout" className="w-5 h-5" />
          <span className="ml-2">Logout</span>
        </button>
      </div>
    </aside>
  );
};

export default Sidebar;
