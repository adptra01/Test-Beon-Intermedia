import React, { useState, useRef, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import api from "../lib/axios";

export default function Header() {
  const [dropdownOpen, setDropdownOpen] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const dropdownRef = useRef(null);
  const navigate = useNavigate();

  const logout = async () => {
    try {
      await api.post("/logout");
      navigate("/login");
    } catch (error) {
      console.error("Logout failed:", error);
    }
  };

  const toggleDropdown = (e) => {
    e.stopPropagation();
    setDropdownOpen((prev) => !prev);
  };

  useEffect(() => {
    function handleClickOutside(event) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setDropdownOpen(false);
      }
    }
    document.addEventListener("click", handleClickOutside);
    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, []);

  return (
    <nav className="bg-gray-800">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="flex h-16 items-center justify-between">
          <div className="flex items-center">
            <div className="shrink-0">
              <img
                className="h-8 w-auto"
                src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                alt="Your Company"
              />
            </div>
            <div className="hidden md:block">
              <div className="ml-10 flex items-baseline space-x-4">
                <Link to="/dashboard" className="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">
                  Dashboard
                </Link>
                <Link to="/residents" className="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">
                  Penduduk
                </Link>
                <Link to="/houses" className="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                  Rumah
                </Link>
                <Link to="/house_resident" className="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                  Penghuni Rumah
                </Link>
                <Link to="/expenses" className="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                  Biaya
                </Link>
                <Link to="/payments" className="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                  Pembayaran
                </Link>
              </div>
            </div>
          </div>
          <div className="hidden md:block">
            <div className="ml-4 flex items-center md:ml-6">
              <button
                type="button"
                className="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                aria-label="View notifications"
              >
                <span className="absolute -inset-1.5"></span>
                <span className="sr-only">View notifications</span>
                <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022 23.848 23.848 0 005.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
              </button>

              {/* Profile dropdown */}
              <div className="relative ml-3" ref={dropdownRef}>
                <button
                  type="button"
                  onClick={toggleDropdown}
                  className="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                >
                  <span className="sr-only">Open user menu</span>
                  <img
                    className="h-8 w-8 rounded-full"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt=""
                  />
                </button>

                {dropdownOpen && (
                  <div className="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5">

                    <button
                      onClick={logout}
                      className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    >
                      Keluar
                    </button>
                  </div>
                )}
              </div>
            </div>
          </div>

          {/* Mobile menu button */}
          <div className="-mr-2 flex md:hidden">
            <button
              onClick={() => setMobileMenuOpen((prev) => !prev)}
              type="button"
              className="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
            >
              <span className="sr-only">Open main menu</span>
              {mobileMenuOpen ? (
                <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              ) : (
                <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
              )}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu dropdown */}
      {mobileMenuOpen && (
        <div className="md:hidden" id="mobile-menu">
          <div className="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <Link to="/dashboard" className="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white">
              Dashboard
            </Link>
            <Link to="/residents" className="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white">
              Penduduk
            </Link>
            <Link to="/houses" className="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Rumah
            </Link>
            <Link to="/house_resident" className="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Penghuni Rumah
            </Link>
            <Link to="/expenses" className="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Biaya
            </Link>
            <Link to="/payments" className="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Pembayaran
            </Link>
            <button
              onClick={logout}
              className="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
            >
              Keluar
            </button>
          </div>
        </div>
      )}
    </nav>
  );
}
