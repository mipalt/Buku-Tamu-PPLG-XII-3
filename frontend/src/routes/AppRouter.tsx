import { Routes, Route, Navigate } from "react-router-dom";
import Login from "../pages/login";

const AppRouter = () => {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/" element={<Navigate to="/login" />} />
      <Route path="*" element={<h1 className="flex item-center justify-center">404 - Page Not Found</h1>} />
    </Routes>
  );
};

export default AppRouter;
