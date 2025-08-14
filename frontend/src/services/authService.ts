import axios from "axios";
import type { LoginPayload, LoginResponse } from "../types/auth";
import { setAuthToken, getAuthToken, removeAuthToken } from "../utils/cookie";

const API_URL = import.meta.env.API_URL || "http://127.0.0.1:8000/api";

// axios instance untuk auth
const authApi = axios.create({
    baseURL: API_URL,
    headers: {
        "Content-Type": "application/json",
    },
});

// Interceptor untuk inject token jika ada
authApi.interceptors.request.use((config) => {
    const token = getAuthToken();
    if (token && config.headers) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export const login = async (payload: LoginPayload): Promise<LoginResponse> => {
    try {
        const { data } = await authApi.post<LoginResponse>("/login", payload);
        setAuthToken(data.data.token);
        return data;
    } catch (error: any) {
        throw new Error(
            error.response?.data?.message || "Login failed, please try again."
        );
    }
};

export const logout = async (): Promise<void> => {
    try {
        await authApi.post("/logout");
    } catch (error: any) {
        console.error("Logout API error:", error.response?.data || error.message);
    } finally {
        removeAuthToken();
    }
};

export const getProfile = async () => {
    try {
        const { data } = await authApi.get("/me");
        return data;
    } catch (error: any) {
        throw new Error(error.response?.data?.message || "Failed to fetch profile.");
    }
};

export default {
    login,
    logout,
    getProfile,
};
