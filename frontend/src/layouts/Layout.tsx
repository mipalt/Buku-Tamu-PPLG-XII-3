import { Outlet } from "react-router-dom";
import Sidebar from "../components/Sidebar";
import Upperbar from "../components/Upperbar";

export default function Layout() {
  return (
    <div className="flex min-h-screen">
      <Sidebar />
      <div className="flex-1 flex flex-col">
        <Upperbar />
        <div className="p-4">
          <Outlet />
        </div>
      </div>
    </div>
  );
}
