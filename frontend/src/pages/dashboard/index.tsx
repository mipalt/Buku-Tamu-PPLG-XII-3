import Sidebar from "./components/Sidebar";
import Upperbar from "./components/Upperbar";

export default function Dashboard() {
  return (
    <div className="flex min-h-screen">
      <Sidebar />
      <div className="flex-1 flex flex-col">
        <Upperbar />
      </div>
    </div>
  );
}
