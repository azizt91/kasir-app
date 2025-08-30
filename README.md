# Kasir App - Aplikasi Kasir Berbasis Web

Kasir App adalah aplikasi Point of Sale (POS) berbasis web yang modern dan ramah pengguna, dirancang untuk membantu mengelola transaksi penjualan, produk, dan stok dengan efisien. Aplikasi ini dibangun menggunakan teknologi terkini dan menyediakan antarmuka yang intuitif untuk pengalaman pengguna yang lebih baik.

## Fitur Utama

  - **Manajemen Produk:** Kelola produk dengan mudah, termasuk menambah, mengubah, dan menghapus data produk.
  - **Manajemen Kategori:** Kategorikan produk untuk organisasi yang lebih baik.
  - **Sistem Kasir (POS):** Antarmuka kasir yang cepat dan mudah digunakan untuk memproses transaksi.
  - **Manajemen Pengguna:** Kelola pengguna dengan peran yang berbeda (Admin dan Kasir).
  - **Laporan:** Hasilkan laporan penjualan, stok, dan produk untuk wawasan bisnis.
  - **Cetak Struk & Barcode:** Cetak struk transaksi dan label barcode untuk produk.
  - **Pengaturan Aplikasi:** Sesuaikan pengaturan dasar aplikasi seperti nama toko, alamat, dan lainnya.

## Teknologi yang Digunakan

  - **Backend:** Laravel
  - **Frontend:** Vue.js (digunakan dengan Inertia.js), Tailwind CSS
  - **Database:** MySQL (default, dapat dikonfigurasi)
  - **Web Server:** Nginx (untuk production dengan Docker)

## Instalasi

### Prasyarat

  - PHP \>= 8.2
  - Composer
  - Node.js & NPM
  - Database (MySQL, PostgreSQL, dll.)

### Langkah-langkah Instalasi

1.  **Clone repositori:**

    ```bash
    git clone https://github.com/azizt91/kasir-app.git
    cd kasir-app
    ```

2.  **Install dependensi:**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan:**

      - Salin file `.env.example` menjadi `.env`.
        ```bash
        cp .env.example .env
        ```
      - Buat *app key* baru.
        ```bash
        php artisan key:generate
        ```
      - Konfigurasi koneksi database Anda di file `.env`.

4.  **Migrasi dan Seeding Database:**

      - Jalankan migrasi untuk membuat tabel-tabel yang diperlukan.
        ```bash
        php artisan migrate
        ```
      - (Opsional) Jalankan *seeder* untuk mengisi data awal.
        ```bash
        php artisan db:seed
        ```

5.  **Build Aset Frontend:**

    ```bash
    npm run build
    ```

6.  **Jalankan Server:**

    ```bash
    php artisan serve
    ```

    Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.

## Akun Demo

Anda dapat menggunakan akun demo berikut untuk mencoba aplikasi:

  - **Admin:**
      - **Email:** `admin@minimarket.com`
      - **Password:** `password`
  - **Kasir:**
      - **Email:** `kasir1@minimarket.com`
      - **Password:** `password`

-----
