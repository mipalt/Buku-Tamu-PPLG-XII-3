import { useState } from "react";
import { FaRegUser } from "react-icons/fa";
import { FaEye, FaEyeSlash } from "react-icons/fa";
import authService from "../../services/authService";
import { useNavigate } from "react-router-dom";
import { toast } from "sonner";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [showPassword, setShowPassword] = useState(false);
    const [loading, setLoading] = useState(false);
    const [, setErrorMsg] = useState("");
    const navigate = useNavigate();

    const handleLogin = async (e: React.FormEvent) => {
        e.preventDefault();
        setErrorMsg("");
        setLoading(true);

        try {
            await authService.login({ email, password });

            toast.success("Login berhasil!"); // <-- toast success login

            navigate("/tes-logout", { replace: true });
        } catch (err: any) {
            const message = err?.message || "Login gagal. Coba lagi.";
            setErrorMsg(message);

            toast.error(message); // <-- toast error login
        } finally {
            setLoading(false);
        }
    };


    return (
        <div className="relative flex items-center justify-center h-screen bg-white overflow-hidden">
            <header className="absolute top-0 left-0 w-full flex items-center h-24 px-10 z-20">
                <img
                    src="/images/logo/logo.png"
                    alt="Logo"
                    className="h-12 w-auto"
                />
            </header>
            {/* SVG Background 1 */}
            <svg
                width="100%"
                height="auto"
                viewBox="0 0 1440 1022"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                className="absolute left-0 bottom-0 z-0 w-full h-auto"
                style={{ minWidth: "auto", minHeight: "auto" }}
            >
                <path
                    opacity="0.6"
                    d="M1446.15 1027.46C1442.52 1058.88 97.6472 1017.46 -0.852862 1027.46C-141.353 443.459 423.647 625.459 735.647 409.959C992.647 85.4588 1274.15 13.9586 1446.15 0.458649C1457.65 165.459 1456.15 859.959 1446.15 1027.46Z"
                    fill="#001E42"
                />
            </svg>
            {/* SVG Background 2 */}
            <svg
                width="100%"
                height="auto"
                viewBox="0 0 1399 772"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                className="absolute right-0 top-0 z-0 w-full h-auto"
                style={{ minWidth: "auto", minHeight: "1000px" }}
            >
                <path
                    d="M1485.1 926.612C1471.41 953.094 29.5954 935.111 5.09542 926.611C-56.905 484.612 555.158 580.112 769.157 333.112C972.328 98.6124 1423.22 -112.04 1538.66 68.1124C1538.66 141.112 1494.6 772.113 1485.1 926.612Z"
                    fill="#001E42"
                />
            </svg>
            {/* Login Form */}
            <div
                className="relative z-10 w-2xl max-w-2xl bg-white shadow-2xl shadow-black/30 p-12 py-16 rounded-xl"
                style={{ boxShadow: "0 8px 32px 0 rgba(0,0,0,0.2)" }}
            >
                <h2 className="text-4xl font-semibold mb-10 text-center text-[#001E42]">Log in</h2>
                <form onSubmit={handleLogin} className="space-y-8">
                    {/* Email */}
                    <div className="mx-8">
                        <div className="relative">
                            <label className="absolute left-4 -top-1 bg-white px-2 text-black font-semibold text-base">
                                Email
                            </label>
                            <input
                                type="email"
                                placeholder="Masukan Email..."
                                className="w-full px-6 py-5 pr-16 text-black border rounded-xl text-lg mt-3"
                                style={{ borderColor: "#27374D" }}
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                required
                            />
                            <span className="absolute right-1 top-[58%] -translate-y-1/2 bg-[#F3F3F3] rounded-xl w-16 h-16 flex items-center justify-center text-gray-400 text-3xl">
                                <FaRegUser />
                            </span>
                        </div>
                    </div>

                    {/* Password */}
                    <div className="mx-8 mt-8">
                        <div className="relative">
                            <label className="absolute left-4 -top-1 bg-white px-2 text-black font-semibold text-base">
                                Kata Sandi
                            </label>
                            <input
                                type={showPassword ? "text" : "password"}
                                placeholder="Masukkan Kata Sandi..."
                                className="w-full px-6 py-5 pr-16 text-black border rounded-xl text-lg mt-3"
                                style={{ borderColor: "#27374D" }}
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                                minLength={6}
                            />
                            <button
                                type="button"
                                className="absolute cursor-pointer right-1 top-[58%] -translate-y-1/2 bg-[#F3F3F3] rounded-xl w-16 h-16 flex items-center justify-center text-gray-400 text-3xl"
                                onClick={() => setShowPassword((prev) => !prev)}
                                tabIndex={-1}
                            >
                                {showPassword ? <FaEyeSlash /> : <FaEye />}
                            </button>
                        </div>
                    </div>

                    {/* Submit */}
                    <div className="flex justify-center">
                        <button
                            type="submit"
                            disabled={loading}
                            className="w-96 justify-center items-center flex bg-[#001E42] text-white py-4 rounded-xl text-xl font-semibold hover:bg-[#27374D] transition disabled:opacity-60 disabled:cursor-not-allowed"
                        >
                            {loading ? "Masuk..." : "Masuk"}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Login;