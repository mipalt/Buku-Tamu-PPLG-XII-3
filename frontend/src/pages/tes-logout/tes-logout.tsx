import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import authService from "../../services/authService";
import { toast } from "sonner";

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
}

const TesLogout: React.FC = () => {
    const navigate = useNavigate();
    const [user, setUser] = useState<User | null>(null);

    useEffect(() => {
        const fetchProfile = async () => {
            try {
                const response = await authService.getProfile();
                setUser(response.data);
            } catch (err) {
                console.error("Gagal ambil profil:", err);
            }
        };

        fetchProfile();
    }, []);

    const handleLogout = async () => {
        try {
            await authService.logout();
            toast.success("Logout berhasil!"); // <-- toast success logout
            navigate("/login");
        } catch (error: any) {
            console.error("Logout gagal:", error.message || error);
            toast.error(error.message || "Logout gagal, silakan coba lagi."); // <-- toast error logout
        }
    };

    return (
        <nav className="flex items-center justify-between px-6 py-4 bg-gray-800 text-white">
            <button
                onClick={handleLogout}
                className="px-4 py-2 bg-red-500 rounded hover:bg-red-600"
            >
                Logout
            </button>
            <div className="flex flex-col items-end">
                <span className="font-semibold">{user?.name || "Loading..."}</span>
                <span className="text-sm text-gray-300">{user?.email || ""}</span>
            </div>
        </nav>
    );
};

export default TesLogout;
