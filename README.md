# FOGENZY Fashion Store

Laravel 12 + Bootstrap 5 e-commerce platform dengan desain premium fashion brand.

---

## Stack
- **Laravel 12**
- **Laravel Breeze** (Authentication)
- **Bootstrap 5** (UI)
- **MySQL / SQLite**
- **Eloquent ORM**

---

## Cara Instalasi (Step-by-Step)

### 1. Buat Project Laravel
```bash
composer create-project laravel/laravel fogenzy-store
cd fogenzy-store
```

### 2. Install Laravel Breeze
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install 
npm run build
```

### 3. Copy semua file dari package ini ke root project

Salin semua file sesuai struktur folder yang ada di package ini.

### 4. Setup Database
Edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fogenzy_store
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration & Seeder
```bash
php artisan migrate:fresh --seed
```

### 6. Link Storage
```bash
php artisan storage:link
```

### 7. Jalankan Server
```bash
php artisan serve
```

Buka: **http://localhost:8000**

---

## Akun Default

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@gmail.com    | password |
| User  | customer@gmail.com     | password |

---

## Fitur

### Customer
- Register / Login / Logout
- Browse produk dengan filter kategori
- Halaman detail produk
- Tambah ke keranjang (add, remove, update qty)
- Checkout dengan form alamat & metode pembayaran
- Riwayat order

### Admin (`/admin`)
- Dashboard dengan stats
- CRUD Produk (dengan gambar)
- CRUD Kategori
- Manajemen Order & update status
