# 📦 Inventory API – Laravel 10

Sebuah RESTful API sederhana untuk manajemen produk, kategori, dan stok menggunakan Laravel 10 dan autentikasi JWT.

---

## 🚀 Instalasi & Menjalankan Proyek

### 1. Clone dari GitHub
```bash
git clone https://github.com/NaufalArkananta/inventory-api.git
cd inventory-api
```

### 2. Install Dependency
```bash
composer install
```

### 3. Copy & Konfigurasi `.env`
```bash
cp .env.example .env
```

Edit `.env`:

```
DB_DATABASE=inventory_api_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Jalankan Migration dan Seeder
```bash
php artisan migrate:fresh --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

Akses API di:
📍 `http://127.0.0.1:8000/api`

---

## 🔐 Autentikasi (JWT)

### Install JWT
```bash
composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

### Register (Opsional)
`POST /api/register`
```json
{
  "name": "Admin",
  "email": "admin@mail.com",
  "password": "password",
  "role": "admin"
}
```

### Login
`POST /api/login`
```json
{
  "email": "admin@mail.com",
  "password": "password"
}
```

**Response:**
```json
{
  "access_token": "....",
  "token_type": "bearer"
}
```

💡 Gunakan di header:
```
Authorization: Bearer <access_token>
```

---

## 📘 Endpoint Utama

| Method | Endpoint                     | Deskripsi                      |
|--------|------------------------------|--------------------------------|
| POST   | /api/products                | Tambah produk                  |
| GET    | /api/products                | Lihat semua produk             |
| GET    | /api/products/{id}           | Lihat detail produk            |
| PUT    | /api/products/{id}           | Update produk                  |
| DELETE | /api/products/{id}           | Hapus produk                   |
| GET    | /api/products/search         | Cari produk berdasarkan nama/kategori |
| POST   | /api/products/update-stock   | Tambah/kurangi stok produk     |
| GET    | /api/inventory/value         | Total nilai inventaris         |
| POST   | /api/categories              | Tambah kategori                |
| GET    | /api/categories              | Lihat semua kategori           |

---

## 🔁 Format Response Standar

### ✅ Sukses
```json
{
  "status": 200,
  "message": "Product retrieved successfully",
  "data": {...}
}
```

### ❌ Validasi Gagal
```json
{
  "status": false,
  "message": "Validation error",
  "errors": {
    "name": ["The name field is required."]
  }
}
```

### ❌ Tidak Ditemukan
```json
{
  "status": 404,
  "message": "Product not found",
  "data": []
}
```

---

## 📦 Seeder Otomatis
Seeder akan membuat:
- 2 user (`admin@mail.com`, `user@mail.com`) – password: `password`
- 5 kategori acak
- 20 produk acak

---

## 🧪 Postman Collection
Import file: `Inventory API.postman_collection.json` (disediakan di project)

---

## ✍️ Author
Created with ❤️ by Naufal Arkananta
