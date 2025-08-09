import { useState } from "react";
import Logo from "../../../assets/logo.png";
import DashboardAfter from "../../../assets/dashboard-after.png";
import DashboardBefore from "../../../assets/dashboard-before.png";
import AllDataAfter from "../../../assets/all-data-after.png";
import AllDataBefore from "../../../assets/all-data-before.png";
import OrangTuaAfter from "../../../assets/orangtua-after.png";
import OrangTuaBefore from "../../../assets/orangtua-before.png";
import AlumniAfter from "../../../assets/alumni-after.png";
import AlumniBefore from "../../../assets/alumni-before.png";
import KunjunganAfter from "../../../assets/kunjungan-after.png";
import KunjunganBefore from "../../../assets/kunjungan-before.png";
import PerusahaanAfter from "../../../assets/perusahaan-after.png";
import PerusahaanBefore from "../../../assets/perusahaan-before.png";
import LogoutIcon from "../../../assets/Logout.png";

const Sidebar: React.FC = () => {
  const [isAllDataOpen, setIsAllDataOpen] = useState(true);
  const [activeMenu, setActiveMenu] = useState<string>("Dashboard");

  const allDataSubMenu = [
    { name: "Orang Tua", after: OrangTuaAfter, before: OrangTuaBefore },
    { name: "Alumni", after: AlumniAfter, before: AlumniBefore },
    { name: "Kunjungan", after: KunjunganAfter, before: KunjunganBefore },
    { name: "Perusahaan", after: PerusahaanAfter, before: PerusahaanBefore },
  ];

  const isSubmenuActive = allDataSubMenu.some(item => item.name === activeMenu);

  const getMenuClass = (name: string) =>
    `flex items-center w-full p-2 rounded mb-2 transition ${
      activeMenu === name
        ? "bg-[#001E42] text-white"
        : "bg-[#E2E8F0] text-black hover:bg-[#BFD1EA]"
    }`;

  const getIcon = (name: string, after: string, before: string) =>
    activeMenu === name ? after : before;

  return (
    <aside className="bg-[#F3F3F3] h-screen w-64 flex flex-col border-r" style={{ borderColor: "#D9D9D9" }}>
      <div className="flex items-center justify-start h-20 px-4 border-b" style={{ borderColor: "#D9D9D9" }}>
        <img src={Logo} alt="Logo" className="w-10 h-10 mr-2" />
        <h1 className="text-xl font-bold text-black">BukuTamu</h1>
      </div>

      <nav className="flex-1 p-4">
        <button
          onClick={() => {
            setActiveMenu("Dashboard");
            setIsAllDataOpen(false);
          }}
          className={getMenuClass("Dashboard")}
        >
          <img
            src={getIcon("Dashboard", DashboardAfter, DashboardBefore)}
            alt="Dashboard"
            className="w-5 h-5"
          />
          <span className="ml-2">Dashboard</span>
        </button>

        <div>
          <button
            onClick={() => {
              setActiveMenu("All Data");
              setIsAllDataOpen(!isAllDataOpen);
            }}
            className={`flex items-center w-full p-2 rounded mb-2 justify-between transition ${
              activeMenu === "All Data" || isSubmenuActive
                ? "bg-[#05254B] text-white"
                : "bg-[#DCE4F2] text-black hover:bg-[#BFD1EA]"
            }`}
          >
            <div className="flex items-center">
              <img
                src={
                  activeMenu === "All Data" || isSubmenuActive
                    ? AllDataAfter
                    : AllDataBefore
                }
                alt="All Data"
                className="w-5 h-5"
              />
              <span className="ml-2">All Data</span>
            </div>
            <span>{isAllDataOpen ? "▾" : "▸"}</span>
          </button>

          {isAllDataOpen && (
            <div className="ml-0 space-y-2">
              {allDataSubMenu.map((item) => (
                <button
                  key={item.name}
                  onClick={() => {
                    setActiveMenu(item.name);
                  }}
                  className={getMenuClass(item.name)}
                >
                  <img
                    src={getIcon(item.name, item.after, item.before)}
                    alt={item.name}
                    className="w-5 h-5"
                  />
                  <span className="ml-2">{item.name}</span>
                </button>
              ))}
            </div>
          )}
        </div>
      </nav>

      {isAllDataOpen && (
        <div className="p-4">
          <button className="flex items-center w-full p-2 rounded bg-[#DCE4F2] hover:bg-[#BFD1EA] text-black">
            <img src={LogoutIcon} alt="Logout" className="w-5 h-5" />
            <span className="ml-2">Logout</span>
          </button>
        </div>
      )}
    </aside>
  );
};

export default Sidebar;
