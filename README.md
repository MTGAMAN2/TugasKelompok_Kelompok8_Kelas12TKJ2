MoneyWise — Personal Finance Management Web App (Laravel)

MoneyWise adalah aplikasi web berbasis Laravel untuk membantu pengguna mengelola dan memonitor keuangan pribadi secara efisien. Aplikasi ini menyediakan fitur seperti pencatatan transaksi, pengelolaan kategori, pembuatan tujuan keuangan, manajemen anggaran (budgeting), serta dashboard ringkas untuk memantau kondisi finansial.

---

* Fitur Utama

🔹 1. **Manajemen Akun & Autentikasi**
- Registrasi akun
- Login & Logout
- Setiap pengguna memiliki data transaksi, kategori, goals, dan budget masing-masing (sistem multi-user)


🔹 2. **Manajemen Kategori**
- Tambah, edit, hapus kategori
- Setiap kategori otomatis muncul pada form transaksi dan budgeting
- Dibuat per user (isolasi data antar pengguna)

🔹 3. **Pencatatan Transaksi**
- Input pemasukan (*income*) dan pengeluaran (*expense*)
- Pilih kategori
- Tambahkan tanggal dan catatan
- Transaksi otomatis terhubung dengan budget (jika kategori terkait ada budget aktif)


🔹 4. **Tujuan Keuangan (Goals)**
- Membuat target tabungan seperti: “Beli Laptop”, “Dana Darurat”, “Liburan”
- Masukkan target nominal dan progres akan dihitung berdasarkan transaksi penyimpanan (income)
- Setiap goal menampilkan progress bar

🔹 5. **Fitur Budgeting (Baru)**
Memungkinkan pengguna mengatur batas pengeluaran berdasarkan kategori.

Fitur budgeting mencakup:

- Membuat anggaran berdasarkan kategori  
- Menentukan batas pengeluaran (`limit_amount`)  
- Menentukan periode (`start_date` – `end_date`)  
- Threshold notifikasi (`alert_threshold`)  
- Catatan penggunaan budget  
- Progress otomatis berdasarkan transaksi  
- Indikator:
  - 🟢 Aman (0–79%)
  - 🟡 Mendekati limit (80–99%)
  - 🔴 Over budget (100%+)


🔹 6. **Dashboard Ringkasan**
- Total income dan expense
- Grafik pemasukan/pengeluaran
- 5 transaksi terbaru
- Status budget aktif
- Rangkuman goals


Teknologi yang Digunakan

**Backend**
- Laravel (PHP 8.1)
- Authentication Laravel Breeze / Traditional Auth
- Eloquent ORM
- Middleware multi-user

**Frontend**
- Blade Template Engine
- HTML5, CSS3
- Bootstrap / Tailwind (opsional sesuai implementasi)

**Database**
- MySQL dengan migrasi Laravel

**Server Lokal**
- Laragon


Instalasi & Cara Menjalankan:

Clone Repository
bash
git clone https://github.com/MTGAMAN2/TugasKelompok_Kelompok8_Kelas12TKJ2.git
cd MoneyWise
composer install
npm install
cp .env.example .env
DB_DATABASE=moneywise
DB_USERNAME=root
DB_PASSWORD=
php artisan key:generate
php artisan migrate
php artisan serve

**Kontributor**
~ Brian Gautama Atmaja Soebandi (Lead Developer)
~ Fernando Porsche
~ Juang Alexander Budianto

**LISENSI**
Proyek ini dikembangkan untuk keperluan pembelajaran dan tidak memiliki lisensi komersial.

**Notes**
MoneyWise masih terus dikembangkan untuk menambahkan fitur seperti:
- Export laporan ke PDF/Excel
- Notifikasi pengingat budget
- Analisis keuangan berbasis AI
