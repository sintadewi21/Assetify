# InLife Telkomsel - Web-Based Inventory Management System

Sistem Manajemen Inventaris dan Peminjaman Aset berbasis Web yang dikembangkan menggunakan **Laravel 11** dan **Tailwind CSS**. Aplikasi ini dibuat sebagai solusi terpadu untuk mengoptimalkan pengelolaan aset kantor di PT Telkomsel, mencegah kehilangan data aset, menghindari duplikasi pencatatan barang, memantau stok secara real-time, dan mempermudah pembuatan laporan transaksi peminjaman.

---

## 🚀 Fitur Utama & Keunggulan
1. **Authentication & Multi-Role Authorization**:
   - Sistem login, register, logout, dan reset password.
   - 3 Level Hak Akses:
     - **Admin**: Akses Penuh (CRUD Master Data, Transaksi, Approval, Ekspor Laporan).
     - **Staff**: Pengelolaan master data (Kategori & Produk), input peminjaman barang, dan proses pengembalian.
     - **Manager**: Pemantauan Dashboard, riwayat logs, dan approval/rejection transaksi peminjaman.
2. **Master Data Barang (Inventory)**:
   - CRUD Produk lengkap dengan pencarian real-time (by nama, kode, lokasi, kondisi) dan filter kategori.
   - Paginasi rapi (10 data per halaman).
   - Pengunggahan gambar barang/aset.
3. **Sistem Peminjaman Transaksional (Master-Detail)**:
   - Peminjaman barang bersifat multi-item dalam satu transaksi menggunakan integrasi Alpine.js.
   - Pengurangan stok otomatis saat peminjaman dibuat (berstatus `Pending`).
   - Fitur **Approval & Rejection** oleh Manager. Jika ditolak, stok otomatis dikembalikan ke gudang.
   - Fitur **Pengembalian Barang** (Return) oleh Staff. Jika dikembalikan, stok otomatis bertambah kembali dan mencatat tanggal kembali.
4. **Dashboard Interaktif**:
   - Total produk, total fisik stok gudang, jumlah barang yang dipinjam, dan barang tersedia.
   - Grafik interaktif peminjaman per bulan menggunakan **Chart.js**.
   - **Notifikasi Stok Menipis** (Alert banner jika stok < 5 unit).
5. **Ekspor & Cetak Laporan (Bonus)**:
   - Ekspor data log peminjaman ke Microsoft Excel / Google Sheets via **nativ CSV stream**.
   - Cetak Laporan PDF langsung melalui browser print styling yang rapi (`window.print()` layout).
6. **Aesthetics & Dark Mode Toggle (Bonus)**:
   - Antarmuka premium dengan kombinasi warna khas Telkomsel (Merah, Putih, Charcoal).
   - Tombol toggle mode gelap/terang interaktif yang tersimpan di `localStorage`.

---

## 🛠️ Panduan Instalasi & Menjalankan Project

Ikuti langkah-langkah di bawah untuk menjalankan project ini di komputer lokal Anda:

### Prerequisites:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (SQLite default / MySQL)

### Langkah Langkah:

1. **Clone & Masuk ke Folder Project**:
   ```bash
   cd e:/Inlife_Telkomsel/inventory-app
   ```

2. **Instal Dependensi PHP**:
   ```bash
   composer install
   ```

3. **Instal Dependensi JavaScript/CSS**:
   ```bash
   npm install
   ```

4. **Konfigurasi Environment File**:
   Salin berkas `.env.example` ke `.env`:
   ```bash
   cp .env.example .env
   ```
   *Secara default, Laravel 11 dikonfigurasi menggunakan SQLite. Jika menggunakan SQLite, pastikan direktori database memuat file `database.sqlite` (atau sistem akan otomatis membuatnya saat migrasi).*

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database & Seeding Awal**:
   Jalankan perintah ini untuk membuat tabel dan mengisi akun testing:
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Koneksikan Storage Link** (untuk pengunggahan gambar):
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Vite Dev Server (Frontend)**:
   ```bash
   npm run dev
   ```

9. **Jalankan Local Development Server (Backend)**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser di alamat: [http://localhost:8000](http://localhost:8000)

---

## 🔑 Akun Login Testing (Hasil Seeder)

Untuk kemudahan penilaian, database seeder telah menyiapkan 3 akun representatif untuk masing-masing role dengan kata sandi yang sama:

- **Admin**:
  - Email: `admin@telkomsel.com`
  - Password: `password123`
- **Staff Inventaris**:
  - Email: `staff@telkomsel.com`
  - Password: `password123`
- **Manager**:
  - Email: `manager@telkomsel.com`
  - Password: `password123`

*Catatan: Anda juga dapat mendaftarkan akun baru melalui menu Register dan memilih langsung role yang diinginkan.*

---

## 🗄️ File Database (.sql)
Berkas struktur database MySQL dan data seeder awal tersedia di dalam project pada path:
📂 `database/database.sql`

---

## 🌐 Dokumentasi REST API

REST API dapat diakses di bawah prefix `/api`. Format response selalu berupa JSON terstandar.

### 1. Endpoint Produk

#### **A. Mengambil Semua Produk**
- **URL**: `/api/products`
- **Method**: `GET`
- **Query Params (Optional)**: `search=kunci_pencarian`
- **Response (200 OK)**:
  ```json
  {
    "status": "success",
    "message": "Daftar produk berhasil diambil",
    "data": {
      "current_page": 1,
      "data": [
        {
          "id": 1,
          "category_id": 2,
          "code": "TSEL-LP-001",
          "name": "Laptop Lenovo ThinkPad",
          "stock": 10,
          "location": "Rak IT Lt. 2",
          "condition": "Bagus",
          "image": null,
          "category": { "id": 2, "name": "Elektronik" }
        }
      ]
    }
  }
  ```

#### **B. Mengambil Detail Produk**
- **URL**: `/api/products/{id}`
- **Method**: `GET`
- **Response (200 OK / 404 Not Found)**

#### **C. Menambahkan Produk Baru**
- **URL**: `/api/products`
- **Method**: `POST`
- **Body (Multipart/Form-Data)**:
  - `category_id` (required, integer)
  - `code` (required, string, unique)
  - `name` (required, string)
  - `stock` (required, integer)
  - `location` (required, string)
  - `condition` (required, in:Bagus,Rusak Ringan,Rusak Berat)
  - `image` (optional, file image)

#### **D. Mengupdate Produk**
- **URL**: `/api/products/{id}`
- **Method**: `PUT`

#### **E. Menghapus Produk**
- **URL**: `/api/products/{id}`
- **Method**: `DELETE`

---

### 2. Endpoint Kategori
- **URL**: `/api/categories`
- **Method**: `GET` (Mengambil semua kategori terdaftar)

---

### 3. Endpoint Peminjaman (Loans)

#### **A. Mengambil Riwayat Peminjaman**
- **URL**: `/api/loans`
- **Method**: `GET`
- **Response (200 OK)**

#### **B. Membuat Transaksi Peminjaman Baru**
- **URL**: `/api/loans`
- **Method**: `POST`
- **Headers**: `Content-Type: application/json`
- **Body (JSON)**:
  ```json
  {
    "user_id": 2,
    "borrower_name": "Andi Wijaya (IT Support)",
    "borrow_date": "2026-07-04",
    "products": [
      {
        "product_id": 1,
        "qty": 2
      },
      {
        "product_id": 2,
        "qty": 1
      }
    ]
  }
  ```
- **Response (210 Created / 400 Bad Request)**
