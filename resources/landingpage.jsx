import React from "react";
import { Link } from "react-router-dom";

export default function LandingPage() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-[#0f172a] via-[#1e1b4b] to-[#701a75] text-white flex flex-col">
      {/* Navbar */}
      <nav className="w-full fixed top-0 bg-black/40 backdrop-blur-md shadow-md z-50">
        <div className="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
          <h1 className="text-2xl font-bold tracking-wide text-purple-400">
            MoneyWise
          </h1>
          <ul className="hidden md:flex space-x-8 text-gray-200 font-medium">
            <li><a href="#features" className="hover:text-purple-400">Features</a></li>
            <li><a href="#about" className="hover:text-purple-400">About</a></li>
            <li><a href="#contact" className="hover:text-purple-400">Contact</a></li>
          </ul>
          <div className="flex space-x-4">
            <Link
              to="/login"
              className="px-4 py-2 rounded-md bg-gradient-to-r from-purple-500 to-pink-500 hover:opacity-90"
            >
              Login
            </Link>
            <Link
              to="/register"
              className="px-4 py-2 rounded-md border border-purple-400 hover:bg-purple-600/30"
            >
              Register
            </Link>
          </div>
        </div>
      </nav>

      {/* Hero Section */}
      <main className="flex-1 flex flex-col justify-center items-center text-center px-6 mt-20">
        <h1 className="text-4xl md:text-6xl font-extrabold leading-tight">
          Kelola Keuangan <span className="text-pink-400">Lebih Mudah 🚀</span>
        </h1>
        <p className="mt-6 max-w-2xl text-gray-300">
          MoneyWise membantu kamu mencatat pemasukan, pengeluaran, membuat
          anggaran, dan melacak tujuan finansialmu dengan tampilan modern &
          futuristik.
        </p>
        <div className="mt-8 flex space-x-4">
          <Link
            to="/register"
            className="px-6 py-3 rounded-lg bg-gradient-to-r from-pink-500 to-purple-600 font-semibold shadow-lg hover:opacity-90"
          >
            Mulai Gratis
          </Link>
          <Link
            to="/login"
            className="px-6 py-3 rounded-lg border border-purple-400 hover:bg-purple-600/30"
          >
            Sudah Punya Akun?
          </Link>
        </div>
      </main>

      {/* Footer */}
      <footer className="text-center py-6 text-gray-400 text-sm border-t border-gray-700/50">
        © 2025 MoneyWise. All rights reserved.
      </footer>
    </div>
  );
}
