import { createContext, useContext, useEffect, useState } from "react";
import api, { getCsrfToken, setAuthToken } from "../lib/axios";

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  // ambil data user (must be after token header & CSRF)
  const getUser = async () => {
    try {
      const res = await api.get("/user");    // ← bukan "/api/user"
      setUser(res.data);
    } catch (err) {
      setUser(null);
    } finally {
      setLoading(false);
    }
  };

  const login = async (data) => {
    // step1: ambil CSRF cookie
    await getCsrfToken();
    // step2: panggil login, dapatkan token
    const response = await api.post("/login", data);
    const token = response.data.access_token;
    if (token) {
      localStorage.setItem("auth_token", token);
      setAuthToken(token);
      await getUser();
    }
  };

  const logout = async () => {
    // no CSRF needed for token‐based, but safe to call
    await getCsrfToken();
    await api.post("/logout");
    localStorage.removeItem("auth_token");
    setAuthToken(null);
    setUser(null);
  };

  useEffect(() => {
    // on mount: jika ada token, pasang header dan ambil user
    const token = localStorage.getItem("auth_token");
    if (token) {
      setAuthToken(token);
      getUser();
    } else {
      setLoading(false);
    }
  }, []);

  return (
    <AuthContext.Provider value={{ user, loading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
