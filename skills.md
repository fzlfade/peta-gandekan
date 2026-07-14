# 📄 Technical Skills & Project Documentation

**Proyek:** Sistem Informasi Rumah Warga — KKN Gandekan  
**Author:** Faiza  
**Last Updated:** Juli 2026

---

## 1. Project Overview

**Sistem Informasi Rumah Warga** adalah aplikasi web berbasis peta interaktif yang dirancang untuk memvisualisasikan sebaran lokasi rumah warga di wilayah Gandekan. Sistem ini dibangun sebagai salah satu output program Kuliah Kerja Nyata (KKN) dengan tujuan:

- Menyediakan **peta digital interaktif** yang menampilkan posisi rumah setiap warga melalui pin/marker.
- Menampilkan **informasi kepemilikan rumah** secara langsung melalui popup marker dan sidebar navigasi.
- Memberikan akses **navigasi rute instan** ke lokasi rumah warga tertentu melalui integrasi Google Maps — tanpa biaya API berbayar.
- Menyajikan antarmuka yang **responsif dan ringan**, dapat diakses melalui perangkat desktop maupun mobile.

Secara arsitektural, sistem ini menganut pola **Server-Side Rendering (SSR)** menggunakan Laravel Blade sebagai template engine, diperkaya dengan interaktivitas client-side melalui Leaflet.js untuk rendering peta.

---

## 2. Tech Stack & Infrastructure

### 2.1 Technology Matrix

| Layer              | Teknologi                        | Versi   | Justifikasi Pemilihan                                                                 |
| ------------------ | -------------------------------- | ------- | ------------------------------------------------------------------------------------- |
| **Backend**        | Laravel                          | 13.x    | Full-featured PHP framework dengan Eloquent ORM, Blade templating, dan migration system yang mature. |
| **Database**       | PostgreSQL                       | 16+     | Skalabilitas superior untuk data spasial; native support untuk tipe data `DOUBLE PRECISION` dan ekstensi PostGIS di masa depan. |
| **Frontend**       | HTML5 + Tailwind CSS             | 3.x     | Utility-first CSS framework untuk rapid prototyping dengan hasil layout yang clean dan konsisten. |
| **Map Rendering**  | Leaflet.js + OpenStreetMap Tiles | 1.9.x   | Library peta open-source paling ringan (~42 KB gzipped); zero-cost tile rendering tanpa API key. |
| **Navigasi**       | Google Maps Intent URL           | —       | Universal link yang mendukung deep-link ke aplikasi Google Maps native tanpa memerlukan API key berbayar. |
| **Local Dev**      | Laragon                          | 6.x     | All-in-one development environment untuk Windows dengan manajemen service (PHP, PostgreSQL, Apache/Nginx) yang portable. |
| **Build Tool**     | Vite (via laravel-vite-plugin)   | 5.x     | Hot Module Replacement (HMR) untuk development frontend yang cepat dan efisien.       |

### 2.2 Arsitektur Keputusan Teknis

```
┌─────────────────────────────────────────────────────────┐
│                      CLIENT (Browser)                   │
│  ┌─────────────┐  ┌──────────────┐  ┌────────────────┐ │
│  │ Tailwind CSS │  │  Leaflet.js  │  │  Google Maps   │ │
│  │  (Layout)    │  │  (Map View)  │  │  (Navigation)  │ │
│  └──────┬──────┘  └──────┬───────┘  └───────┬────────┘ │
│         │                │                   │          │
│         └────────────────┼───────────────────┘          │
│                          │                              │
├──────────────────────────┼──────────────────────────────┤
│                   SERVER (Laravel 11)                   │
│  ┌───────────┐  ┌───────┴───────┐  ┌────────────────┐  │
│  │  Routes   │──│  Controller   │──│  Blade Views   │  │
│  └───────────┘  └───────┬───────┘  └────────────────┘  │
│                         │                               │
│                  ┌──────┴──────┐                        │
│                  │  Eloquent   │                        │
│                  │    Model    │                        │
│                  └──────┬──────┘                        │
│                         │                               │
├─────────────────────────┼───────────────────────────────┤
│                    DATA LAYER                           │
│                  ┌──────┴──────┐                        │
│                  │ PostgreSQL  │                        │
│                  │  Database   │                        │
│                  └─────────────┘                        │
└─────────────────────────────────────────────────────────┘
```

**Mengapa PostgreSQL, bukan MySQL?**

PostgreSQL dipilih secara deliberate karena:
1. **Presisi numerik** — Tipe `DOUBLE PRECISION` (IEEE 754) memberikan presisi hingga 15 digit desimal, krusial untuk menyimpan koordinat geografis dengan akurasi sub-meter.
2. **Skalabilitas spasial** — Jika proyek berkembang, PostgreSQL mendukung ekstensi **PostGIS** secara native untuk operasi geospasial lanjutan (radius search, polygon containment, dll).
3. **ACID Compliance** — Integritas data transaksional yang lebih kuat dibanding MySQL untuk operasi write-heavy.

**Mengapa Leaflet.js + OSM, bukan Google Maps API?**

- **Zero cost** — Tidak ada billing API key, tidak ada batasan request quota.
- **Lightweight** — Bundle size Leaflet hanya ~42 KB (gzipped), jauh lebih ringan dari Google Maps JS API (~200+ KB).
- **Customizable** — Full control terhadap styling marker, popup, dan tile layer tanpa batasan branding.

---

## 3. Core Technical Implementation

### 3.1 Interactive Map Rendering dengan Leaflet.js

Peta interaktif dirender menggunakan Leaflet.js dengan tile dari OpenStreetMap. Data warga di-pass dari server (Laravel) ke client (JavaScript) menggunakan directive Blade `@json`:

```blade
{{-- resources/views/peta.blade.php --}}

<div id="map" class="w-full h-screen"></div>

<script>
    // Inisialisasi peta dengan center point wilayah Gandekan
    const map = L.map('map').setView([-7.5755, 110.8243], 16);

    // Tile layer dari OpenStreetMap (gratis, tanpa API key)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Data warga di-pass dari Controller via Blade @json directive
    const residents = @json($residents);

    // Looping untuk membuat marker pada setiap koordinat rumah warga
    residents.forEach(resident => {
        const marker = L.marker([resident.latitude, resident.longitude])
            .addTo(map)
            .bindPopup(`
                <strong>${resident.nama_pemilik}</strong><br>
                ${resident.alamat}<br>
                <a href="https://www.google.com/maps/dir/?api=1&destination=${resident.latitude},${resident.longitude}"
                   target="_blank" rel="noopener">
                   📍 Navigasi ke lokasi
                </a>
            `);
    });
</script>
```

**Poin teknis yang diterapkan:**

| Teknik                      | Penjelasan                                                                                       |
| --------------------------- | ------------------------------------------------------------------------------------------------ |
| `@json($residents)`        | Blade directive untuk serialisasi data Eloquent Collection menjadi JSON yang aman (auto-escape). |
| `L.marker([lat, lng])`     | Membuat instance marker Leaflet dari koordinat yang di-loop dari data backend.                   |
| `.bindPopup()`             | Mengikat HTML popup informatif pada setiap marker dengan data dinamis.                           |
| Template Literal (`` ` ``) | ES6 string interpolation untuk menyisipkan data warga ke dalam HTML popup secara inline.         |

### 3.2 Dynamic Sidebar Focus & Interaksi Peta

Sidebar daftar warga dan peta utama saling terhubung secara interaktif:

```javascript
// Klik item di sidebar → peta terbang ke marker yang sesuai
function focusResident(lat, lng) {
    map.flyTo([lat, lng], 18, {
        animate: true,
        duration: 1.5
    });
}

// Binding event pada setiap item sidebar
document.querySelectorAll('.resident-item').forEach(item => {
    item.addEventListener('click', () => {
        const lat = parseFloat(item.dataset.lat);
        const lng = parseFloat(item.dataset.lng);
        focusResident(lat, lng);
    });
});
```

Interaksi ini menciptakan pengalaman **dual-panel navigation** di mana pengguna dapat menelusuri daftar warga pada sidebar, kemudian peta akan secara otomatis melakukan animasi *fly-to* ke koordinat marker yang relevan.

### 3.3 Google Maps Navigation Intent (Zero-Cost Routing)

Fitur navigasi rute memanfaatkan **Google Maps Universal Link** yang secara otomatis:
- Membuka aplikasi Google Maps native (jika tersedia di perangkat mobile).
- Fallback ke Google Maps web (jika dibuka di desktop browser).

```
https://www.google.com/maps/dir/?api=1&destination={latitude},{longitude}
```

| Parameter      | Nilai                  | Fungsi                                              |
| -------------- | ---------------------- | --------------------------------------------------- |
| `api`          | `1`                    | Versi URL scheme Google Maps.                       |
| `destination`  | `{lat},{lng}`          | Koordinat tujuan yang diambil dari database warga.  |

> **Keunggulan:** Tidak memerlukan Google Maps API Key, tidak ada biaya per-request, dan kompatibel dengan seluruh perangkat yang memiliki browser modern.

---

## 4. Database Schema Insights

### 4.1 Migration: Tabel Warga

```php
// database/migrations/xxxx_xx_xx_create_wargas_table.php

Schema::create('wargas', function (Blueprint $table) {
    $table->id();
    $table->string('nama_pemilik');
    $table->text('alamat');
    $table->double('latitude', 15, 10);   // Presisi: 15 digit total, 10 desimal
    $table->double('longitude', 15, 10);  // Presisi: 15 digit total, 10 desimal
    $table->timestamps();
});
```

### 4.2 Mengapa `double`, Bukan `float`?

| Tipe    | Presisi             | Resolusi Geografis         | Cocok Untuk                     |
| ------- | ------------------- | -------------------------- | ------------------------------- |
| `float` | ~7 digit desimal    | ~1.1 meter pada ekuator    | Aplikasi dengan toleransi kasar |
| `double`| ~15 digit desimal   | ~0.11 milimeter pada ekuator | Pemetaan presisi tinggi ✅     |

Koordinat geografis Indonesia berada di kisaran `-11.0` hingga `6.0` (latitude) dan `95.0` hingga `141.0` (longitude). Dengan tipe `double`, sistem mampu menyimpan posisi rumah warga hingga **presisi sub-milimeter** — jauh melampaui kebutuhan minimum identifikasi lokasi bangunan.

### 4.3 Eloquent Model

```php
// app/Models/Warga.php

class Warga extends Model
{
    protected $fillable = [
        'nama_pemilik',
        'alamat',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude'  => 'double',
        'longitude' => 'double',
    ];
}
```

Penggunaan `$casts` memastikan bahwa nilai koordinat selalu di-treat sebagai tipe `double` pada layer PHP, menghindari potensi *floating-point precision loss* saat serialisasi JSON.

---

## 5. Problem Solving Showcase

### 🔧 Studi Kasus: Mengatasi Error `"Could not find driver (Connection: pgsql)"`

#### Konteks Masalah

Saat menjalankan perintah `php artisan migrate` untuk pertama kalinya setelah konfigurasi database PostgreSQL di file `.env`, muncul error fatal:

```
Illuminate\Database\QueryException

  could not find driver (Connection: pgsql, SQL: ...)
```

Error ini mengindikasikan bahwa PHP tidak memuat ekstensi `pdo_pgsql` yang dibutuhkan oleh Laravel untuk berkomunikasi dengan PostgreSQL.

#### Root Cause Analysis

Setelah investigasi mendalam, ditemukan bahwa **Windows Environment PATH** memiliki konflik antara dua instalasi PHP:

```
# Kondisi PATH sebelum perbaikan (urutan kritis):
C:\xampp\php          ← PHP dari XAMPP (lama, tanpa pdo_pgsql)
C:\laragon\bin\php\php-8.3\  ← PHP dari Laragon (aktif, dengan pdo_pgsql)
```

Ketika `php artisan migrate` dijalankan dari terminal, sistem operasi Windows me-resolve binary `php` berdasarkan **urutan pertama** yang ditemukan di PATH. Karena XAMPP terdaftar lebih dulu, PHP yang dieksekusi adalah versi XAMPP — yang **tidak** memiliki ekstensi `pdo_pgsql` ter-enable.

#### Proses Diagnosis

```powershell
# 1. Verifikasi PHP mana yang sedang aktif
> where php
C:\xampp\php\php.exe          # ← Ini yang dipakai (salah!)
C:\laragon\bin\php\php-8.3\php.exe

# 2. Cek apakah ekstensi pdo_pgsql dimuat
> php -m | findstr pdo_pgsql
(tidak ada output — ekstensi tidak dimuat)

# 3. Verifikasi file php.ini yang digunakan
> php --ini
Configuration File (php.ini) Path:  C:\xampp\php
Loaded Configuration File:         C:\xampp\php\php.ini  # ← Bukan milik Laragon
```

#### Solusi yang Diterapkan

1. **Reorder Environment PATH** — Memindahkan path PHP Laragon agar berada di **atas** path XAMPP:

   ```
   # Kondisi PATH setelah perbaikan:
   C:\laragon\bin\php\php-8.3\  ← Sekarang prioritas pertama ✅
   C:\xampp\php                  ← Turun prioritas
   ```

2. **Enable ekstensi di `php.ini` Laragon** — Memastikan baris berikut tidak di-comment:

   ```ini
   ; C:\laragon\bin\php\php-8.3\php.ini
   extension=pdo_pgsql
   extension=pgsql
   ```

3. **Restart terminal session** — Environment PATH baru hanya berlaku setelah terminal di-restart.

#### Verifikasi

```powershell
# Konfirmasi PHP yang aktif sudah benar
> where php
C:\laragon\bin\php\php-8.3\php.exe  # ✅

# Konfirmasi ekstensi pdo_pgsql termuat
> php -m | findstr pdo_pgsql
pdo_pgsql  # ✅

# Migrasi berhasil
> php artisan migrate
INFO  Running migrations.

  2024_xx_xx_create_wargas_table ........... 32.15ms DONE  # ✅
```

#### Lessons Learned

| #  | Insight                                                                                           |
| -- | ------------------------------------------------------------------------------------------------- |
| 1  | Selalu verifikasi `where php` (Windows) atau `which php` (Unix) sebelum debugging driver issues.  |
| 2  | Multiple PHP installations di Windows adalah sumber konflik umum — PATH ordering adalah kunci.    |
| 3  | Laragon memiliki mekanisme PATH override internal, tetapi terminal eksternal tetap mengikuti System PATH. |
| 4  | Gunakan `php -m` untuk memverifikasi ekstensi yang dimuat secara runtime, bukan hanya membaca `php.ini`. |

---

## 6. Skills Summary

```
┌──────────────────────────────────────────────────────┐
│              TECHNICAL COMPETENCIES APPLIED           │
├──────────────────────────────────────────────────────┤
│                                                      │
│  ▸ Backend Development      — Laravel 11 (PHP 8.3)   │
│  ▸ Database Engineering     — PostgreSQL, Migrations  │
│  ▸ Frontend Development     — HTML5, Tailwind CSS     │
│  ▸ Geospatial Visualization — Leaflet.js + OSM        │
│  ▸ API Integration          — Google Maps Intent URL  │
│  ▸ Dev Environment          — Laragon, Vite, Windows  │
│  ▸ Troubleshooting          — PATH conflict debugging  │
│  ▸ Version Control          — Git                     │
│                                                      │
└──────────────────────────────────────────────────────┘
```

Proyek ini mendemonstrasikan kemampuan untuk **merancang, membangun, dan men-debug** sebuah aplikasi web full-stack yang mengintegrasikan data spasial dengan visualisasi peta interaktif — menggunakan seluruh teknologi open-source dengan **zero licensing cost**.

---

*Dokumen ini disusun sebagai bukti kompetensi teknis dalam rangka program KKN Gandekan.*
