# NOIRVÉ Fashion Store
> Laravel 12 + Bootstrap 5 — Minimalist Premium Fashion E-Commerce

---

## ⚡ Quick Start (Step by Step)

### 1. Buat Project Laravel
```bash
composer create-project laravel/laravel noirvé-store
cd noirvé-store
```

### 2. Install Laravel Breeze
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

### 3. Konfigurasi .env
```env
APP_NAME="NOIRVÉ"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=noirvé_store
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Buat Database
```sql
CREATE DATABASE `noirvé_store` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Copy semua file dari ZIP ini ke project
Salin file-file ini ke lokasi yang sesuai di project Laravel kamu:
- `app/Http/Controllers/*` → Controllers
- `app/Http/Middleware/AdminMiddleware.php` → Middleware
- `app/Models/*` → Models
- `app/Policies/CartPolicy.php` → Policy
- `resources/views/*` → Views
- `routes/web.php` → Routes
- `database/seeders/*` → Seeders

### 6. Buat Migrations

Jalankan command berikut satu per satu:

```bash
php artisan make:migration create_categories_table
php artisan make:migration create_products_table
php artisan make:migration create_carts_table
php artisan make:migration create_orders_table
php artisan make:migration create_order_items_table
php artisan make:migration add_is_admin_to_users_table
```

Lalu buka file `database/migrations/_ALL_MIGRATIONS_REFERENCE.php` dan copy schema masing-masing migration ke file yang baru dibuat.

### 7. Update `bootstrap/app.php`
Tambahkan admin middleware alias:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

### 8. Update `app/Models/User.php`
Tambahkan ke `$fillable`:
```php
'is_admin',
```
Tambahkan ke `$casts`:
```php
'is_admin' => 'boolean',
```
Tambahkan relasi:
```php
public function carts(): HasMany
{
    return $this->hasMany(\App\Models\Cart::class);
}

public function orders(): HasMany
{
    return $this->hasMany(\App\Models\Order::class);
}
```

### 9. Update `app/Providers/AppServiceProvider.php`
```php
use App\Models\Cart;
use App\Policies\CartPolicy;
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::policy(Cart::class, CartPolicy::class);
}
```

### 10. Storage Link
```bash
php artisan storage:link
```

### 11. Migrate & Seed
```bash
php artisan migrate:fresh --seed
```

### 12. Jalankan Server
```bash
php artisan serve
# Di terminal lain:
npm run dev
```

---

## 🔑 Akun Default

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@noirvé.com    | password |
| User  | Daftar sendiri via /register |

---

## 🌐 URL Penting

| Halaman         | URL                          |
|----------------|------------------------------|
| Storefront     | http://localhost:8000         |
| Login          | http://localhost:8000/login   |
| Register       | http://localhost:8000/register|
| Cart           | http://localhost:8000/cart    |
| Orders         | http://localhost:8000/orders  |
| Admin Dashboard| http://localhost:8000/admin/dashboard |
| Admin Produk   | http://localhost:8000/admin/products  |
| Admin Kategori | http://localhost:8000/admin/categories|
| Admin Orders   | http://localhost:8000/admin/orders    |

---

## 📁 Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AdminDashboardController.php
│   │   │   ├── AdminProductController.php
│   │   │   ├── AdminCategoryController.php
│   │   │   └── AdminOrderController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   └── OrderController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Product.php
│   ├── Cart.php
│   ├── Order.php
│   └── OrderItem.php
└── Policies/
    └── CartPolicy.php

resources/views/
├── layouts/
│   ├── app.blade.php          ← Main layout
│   └── admin.blade.php        ← Admin sidebar layout
├── home.blade.php             ← Homepage
├── products/
│   ├── index.blade.php        ← Product grid
│   └── show.blade.php         ← Product detail
├── cart/
│   └── index.blade.php        ← Shopping cart
├── checkout/
│   └── index.blade.php        ← Checkout form
├── orders/
│   ├── index.blade.php        ← Order history
│   └── show.blade.php         ← Order detail
└── admin/
    ├── dashboard.blade.php
    ├── products/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── _form.blade.php
    ├── categories/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── _form.blade.php
    └── orders/
        ├── index.blade.php
        └── show.blade.php
```

---

## 🎨 Design System

| Token       | Value     | Usage                     |
|------------|-----------|---------------------------|
| `--noir`   | `#0a0a0a` | Primary dark / text       |
| `--blanc`  | `#fafafa` | Background / light text   |
| `--accent` | `#c9a96e` | Gold accent / CTA         |
| `--muted`  | `#6b6b6b` | Secondary text            |
| Font Display| Cormorant Garamond | Headings, brand |
| Font Body  | Jost      | All body text             |

---

## 📦 Produk Seeder (12 items)

- **Wanita (5):** Linen Draped Midi Dress, Wide-Leg Crepe Trousers, Oversized Blazer Wool, Slip Satin Skirt, Cropped Knit Cardigan
- **Pria (4):** Relaxed Linen Shirt, Tapered Wool Trousers, Structured Coach Jacket, Organic Cotton Tee
- **Aksesoris (3):** Leather Mini Tote Bag, Merino Wool Scarf, Minimal Leather Belt

---

Made with ❤️ for NOIRVÉ Fashion Store
