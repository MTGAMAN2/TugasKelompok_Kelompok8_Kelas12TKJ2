<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyWise - Smart Finance Manager</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-700 min-h-screen text-white flex flex-col">


    <nav class="flex justify-between items-center p-6 backdrop-blur-md bg-white/10 sticky top-0 z-50">
        <h1 class="text-2xl font-bold tracking-wide">MoneyWise</h1>
        <div class="space-x-4">
            <a href="#features" class="hover:text-pink-300 transition">Features</a>
            <a href="#about" class="hover:text-pink-300 transition">About</a>
            <a href="#contact" class="hover:text-pink-300 transition">Contact</a>
            <a href="{{ route('login') }}" 
               class="px-4 py-2 bg-pink-500 rounded-lg hover:bg-pink-600 transition">Login</a>
            <a href="{{ route('register') }}" 
               class="px-4 py-2 bg-purple-500 rounded-lg hover:bg-purple-600 transition">Register</a>
        </div>
    </nav>


    <section class="flex flex-col items-center justify-center flex-1 text-center px-6">
        <h2 class="text-5xl font-extrabold mb-6 leading-tight">
            Kelola Keuangan <span class="text-pink-400">Lebih Mudah</span> 
        </h2>
        <p class="text-lg text-gray-200 max-w-2xl mb-8">
            MoneyWise membantu kamu mencatat pemasukan, pengeluaran, membuat anggaran, 
            dan melacak tujuan finansialmu dengan tampilan modern & futuristik.
        </p>
        <div class="space-x-4">
            <a href="{{ route('register') }}" 
               class="px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg shadow-lg hover:scale-105 transform transition">
               Mulai Gratis
            </a>
            <a href="{{ route('login') }}" 
               class="px-6 py-3 bg-white/20 border border-white/30 rounded-lg shadow-lg hover:scale-105 transform transition">
               Sudah Punya Akun?
            </a>
        </div>
    </section>

    <footer class="py-6 text-center text-gray-400">
        &copy; {{ date('Y') }} MoneyWise. All rights reserved.
    </footer>
</body>
</html>
