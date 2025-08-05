import { useState } from "react";
import { FaRegUser } from "react-icons/fa";
import { FaEye, FaEyeSlash } from "react-icons/fa";

const Login = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [showPassword, setShowPassword] = useState(false);

    const handleLogin = (e: React.FormEvent) => {
        e.preventDefault();
        console.log("Login with", email, password);
    };

    return (
        <div className="flex items-center justify-center h-screen bg-white">
            <div className="w-full max-w-xl bg-white shadow-xl p-8 py-12 border rounded-xl">
                <h2 className="text-4xl font-bold mb-8 text-center text-[#001E42]">Log in</h2>
                <form onSubmit={handleLogin} className="space-y-6">
                    <div className="mx-8">
                        <label className="block mb-2 font-semibold text-black text-lg">Email</label>
                        <div className="relative">
                            <input
                                type="email"
                                placeholder="Email"
                                className="w-full px-4 py-4 pr-12 text-black border-2 rounded-xl text-base"
                                style={{ borderColor: "#27374D" }}
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                required
                            />
                            <span className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">
                                <FaRegUser />
                            </span>
                        </div>
                    </div>
                    <div className="mx-8">
                        <label className="block mb-2 text-black font-semibold text-lg">Kata Sandi</label>
                        <div className="relative">
                            <input
                                type={showPassword ? "text" : "password"}
                                placeholder="Kata Sandi"
                                className="w-full px-4 py-4 pr-12 text-black border-2 rounded-xl text-base"
                                style={{ borderColor: "#27374D" }}
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                            />
                            <button
                                type="button"
                                className="absolute cursor-pointer right-4 top-1/2 -translate-y-1/2 bg-[#F3F3F3] rounded- w-10 h-10 flex items-center justify-center text-gray-400 focus:outline-none text-2xl"
                                onClick={() => setShowPassword((prev) => !prev)}
                                tabIndex={-1}
                            >
                                {showPassword ? <FaEyeSlash /> : <FaEye />}
                            </button>
                        </div>
                    </div>
                    <div className="flex justify-center">
                        <button
                            type="submit"
                            className="w-80 justify-center items-center flex bg-[#001E42] text-white py-3 rounded-xl text-lg font-semibold hover:bg-[#27374D] transition"
                        >
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Login;