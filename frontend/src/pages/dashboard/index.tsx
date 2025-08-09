import Sidebar from "../auth/components/Sidebar";

export default function Dashboard() {
  return (
    <div className="flex">
      <Sidebar />
      <div className="flex-1 p-6">
        <h1 className="text-2xl font-bold">Dashboard</h1>
      </div>
    </div>
  );
}
