import { Routes, Route, Navigate } from "react-router-dom";
import Login from "../pages/auth/login";
import NotFoundPage from "../pages/not-found/NotFound";

const AppRouter = () => {
    return (
        //ini untuk atur routes nya 
        <Routes>
            <Route path="/login" element={<Login />} />
            <Route path="/" element={<Navigate to="/login" />} />


            {/* component yang akan di render ketika tidak ada route yang cocok */}
            <Route path="*" element={<NotFoundPage />} />
        </Routes>
    );
};

export default AppRouter;
