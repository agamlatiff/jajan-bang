# Jajan Bang - Pages Overview

Daftar semua halaman dan komponen untuk redesign.

---

## 📱 Customer-Facing Pages

### 1. Home Page (`/`)

**View:** `resources/views/home.blade.php`

| Section                 | Deskripsi                                                             |
| ----------------------- | --------------------------------------------------------------------- |
| **A. Header**           | Logo JajanBang, nomor meja (rounded card), background pattern         |
| **B. Search Bar**       | Input pencarian dengan icon, judul "Mau Pesan Apa hari ini?"          |
| **C. Promo Slider**     | Horizontal scroll food cards, "Today's promo" dengan See More link    |
| **D. Banner CTA**       | Banner promosi "Cita Rasa Lokal", tombol "Lihat Semua Menu"           |
| **E. Favorite Section** | Horizontal scroll food cards favorit, "Favorite Food" dengan See More |
| **F. Search Results**   | Grid 2 kolom hasil pencarian (tampil saat ada search term)            |
| **G. Customer Modal**   | Form nama & telepon (wajib diisi)                                     |

---

### 2. All Food Page (`/food`)

**View:** `resources/views/product/all-food.blade.php`

| Section               | Deskripsi                                       |
| --------------------- | ----------------------------------------------- |
| **A. Page Title Nav** | Judul "All Foods" dengan tombol back dan filter |
| **B. Food Grid**      | Grid 2 kolom food cards                         |
| **C. Filter Modal**   | Modal filter kategori                           |

---

### 3. Promo Page (`/food/promo`)

**View:** `resources/views/product/promo.blade.php`

| Section               | Deskripsi                                 |
| --------------------- | ----------------------------------------- |
| **A. Page Title Nav** | Judul "Promo" dengan back button          |
| **B. Promo Grid**     | Grid 2 kolom food cards yang sedang promo |

---

  ### 4. Favorite Page (`/food/favorite`)

  **View:** `resources/views/product/favorite.blade.php`

  | Section               | Deskripsi                           |
  | --------------------- | ----------------------------------- |
  | **A. Page Title Nav** | Judul "Favorite" dengan back button |
  | **B. Favorite Grid**  | Grid 2 kolom food cards terlaris    |

  ---

### 5. Detail Page (`/food/{id}`)

**View:** `resources/views/product/details.blade.php`

| Section                | Deskripsi                                                                       |
| ---------------------- | ------------------------------------------------------------------------------- |
| **A. Page Title Nav**  | Back button, judul "Food Detail"                                                |
| **B. Food Image**      | Gambar makanan full-width dengan rounded corners                                |
| **C. Food Info Card**  | Badge terjual, diskon badge, nama, harga (normal & diskon), kategori, deskripsi |
| **D. Action Buttons**  | "Tambah ke Keranjang" (secondary) dan "Pesan Sekarang" (primary)                |
| **E. Toast Component** | Notifikasi sukses/error                                                         |

---

### 6. Cart Page (`/cart`)

**View:** `resources/views/payment/cart.blade.php`

| Section                | Deskripsi                                                                 |
| ---------------------- | ------------------------------------------------------------------------- |
| **A. Page Title Nav**  | Back button, judul "Keranjang"                                            |
| **B. Cart Items List** | List item dengan checkbox, quantity, harga (via menu-item-list component) |
| **C. Action Buttons**  | "Hapus (n)" button dan "Pesan Sekarang" button                            |
| **D. Empty State**     | Ilustrasi keranjang kosong dengan CTA "Lihat Menu"                        |
| **E. Delete Modal**    | Konfirmasi hapus item                                                     |

---

### 7. Checkout Page (`/checkout`)

**View:** `resources/views/payment/checkout.blade.php`

| Section               | Deskripsi                                                         |
| --------------------- | ----------------------------------------------------------------- |
| **A. Page Title Nav** | Back button, judul "Pemesanan"                                    |
| **B. Customer Info**  | Nomor meja, nama pemesan dengan edit button                       |
| **C. Order Items**    | List makanan yang dipesan (tanpa checkbox)                        |
| **D. Price Summary**  | Subtotal, PPN 11%, Total (dalam card dengan border)               |
| **E. Payment Button** | "Bayar Sekarang" atau "Lanjut Bayar" (jika ada transaksi pending) |
| **F. Customer Modal** | Form edit nama & telepon                                          |

---

### 8. Scan QR Page (`/scan`)

**View:** `resources/views/product/scan.blade.php`

| Section           | Deskripsi                                                    |
| ----------------- | ------------------------------------------------------------ |
| **A. QR Scanner** | Full-screen QR code scanner menggunakan html5-qrcode library |

---

## ✅ Payment Status Pages

### 9. Payment Success (`/payment/success`)

**View:** `resources/views/payment/success.blade.php`

| Section                   | Deskripsi                                     |
| ------------------------- | --------------------------------------------- |
| **A. Success Icon**       | Checkmark atau success illustration           |
| **B. Success Message**    | "Pembayaran Berhasil" dengan detail transaksi |
| **C. Track Order Button** | Link ke halaman lacak pesanan                 |
| **D. Home Button**        | Kembali ke home                               |

---

### 10. Payment Failure (`/payment/failure`)

**View:** `resources/views/payment/failure.blade.php`

| Section                | Deskripsi                      |
| ---------------------- | ------------------------------ |
| **A. Failure Icon**    | Error/warning illustration     |
| **B. Failure Message** | "Pembayaran Gagal" dengan info |
| **C. Retry Button**    | Coba lagi                      |
| **D. Home Button**     | Kembali ke home                |

---

## 📋 Order Management Pages

### 11. Order Tracking (`/track-order/{invoice?}`)

**View:** `resources/views/livewire/pages/order-tracking-page.blade.php`

| Section                   | Deskripsi                                                   |
| ------------------------- | ----------------------------------------------------------- |
| **A. Page Title Nav**     | Back to home, judul "Lacak Pesanan"                         |
| **B. Search Form**        | Input invoice number dengan tombol "Cari"                   |
| **C. Status Timeline**    | 5 step: Diterima → Dikonfirmasi → Diproses → Siap → Selesai |
| **D. Order Details Card** | Nama, telepon, meja, metode pembayaran, total               |
| **E. Order Items List**   | List item dengan quantity dan harga                         |
| **F. Not Found State**    | Ilustrasi dan pesan jika invoice tidak ditemukan            |
| **G. Initial State**      | Ilustrasi awal sebelum search                               |

---

  ### 12. Kitchen Dashboard (`/kitchen`)

  **View:** `resources/views/livewire/pages/kitchen-dashboard.blade.php`

  | Section               | Deskripsi                                                   |
  | --------------------- | ----------------------------------------------------------- |
  | **A. Header**         | Logo, judul "Dapur", refresh indicator                      |
  | **B. Stats Cards**    | Total pesanan aktif, pending, ready                         |
  | **C. Filter Tabs**    | All, Pending, Confirmed, Preparing, Ready                   |
  | **D. Order Cards**    | Card per order dengan meja, customer, items, status buttons |
  | **E. Action Buttons** | Update status per order (Konfirmasi, Proses, Siap, Antar)   |
  | **F. Empty State**    | Ilustrasi tidak ada pesanan aktif                           |

---

## 🎛️ Admin Panel (Filament)

**URL:** `/admin`

### Admin Dashboard (`/admin`)

| Section               | Widget                   | Deskripsi                                                                                         |
| --------------------- | ------------------------ | ------------------------------------------------------------------------------------------------- |
| **A. Stats Overview** | `StatsOverview.php`      | 4 stat cards: Pendapatan Hari Ini (+/-% trend), Pendapatan Bulan Ini, Pesanan Pending, Total Menu |
| **B. Revenue Chart**  | `RevenueChartWidget.php` | Line chart pendapatan 7 hari terakhir                                                             |
| **C. Recent Orders**  | `RecentOrdersWidget.php` | Tabel 10 pesanan terbaru (invoice, customer, total, status)                                       |
| **D. Best Sellers**   | `BestSellersWidget.php`  | Tabel 5 menu terlaris (image, name, price, sold count)                                            |

---

### Admin Resources

| Resource              | Path                       | Sections                                                    |
| --------------------- | -------------------------- | ----------------------------------------------------------- |
| **Category**          | `/admin/categories`        | CRUD kategori menu (nama, icon)                             |
| **Foods**             | `/admin/foods`             | CRUD menu (nama, harga, deskripsi, gambar, kategori, promo) |
| **Transaction**       | `/admin/transactions`      | List transaksi, detail, update status                       |
| **Transaction Items** | `/admin/transaction-items` | Items dalam transaksi                                       |
| **Barcode**           | `/admin/barcodes`          | Manage QR codes per meja                                    |

---

### Barcode Resource Details (`/admin/barcodes`)

| Section                | Deskripsi                                         |
| ---------------------- | ------------------------------------------------- |
| **A. List Page**       | Tabel barcodes dengan image, table_number, status |
| **B. Create Page**     | Form generate QR code baru                        |
| **C. Download Action** | Download QR code sebagai SVG                      |

---

### Foods Resource Details (`/admin/foods`)

| Section                 | Deskripsi                                               |
| ----------------------- | ------------------------------------------------------- |
| **A. List Page**        | Tabel dengan image, nama, harga, kategori, promo status |
| **B. Create/Edit Form** | Form dengan tabs: Basic Info, Pricing, Media            |
| **C. Filters**          | Filter by kategori, promo status                        |
| **D. Bulk Actions**     | Bulk delete, bulk update promo                          |

---

### Transaction Resource Details (`/admin/transactions`)

| Section               | Deskripsi                                                           |
| --------------------- | ------------------------------------------------------------------- |
| **A. List Page**      | Tabel dengan invoice, customer, total, payment status, order status |
| **B. Detail Page**    | Info transaksi lengkap dengan items                                 |
| **C. Status Actions** | Update payment_status dan order_status                              |
| **D. Filters**        | Filter by status, date range                                        |

---

## 🧩 Shared Components

| Component          | File                                      | Digunakan Di                                    |
| ------------------ | ----------------------------------------- | ----------------------------------------------- |
| **Food Card**      | `livewire/food-card.blade.php`            | Home, All Food, Promo, Favorite, Search Results |
| **Main Menu**      | `livewire/main-menu.blade.php`            | Bottom navigation (all pages)                   |
| **Page Title Nav** | `livewire/page-title-nav.blade.php`       | All pages except Home                           |
| **Customer Modal** | `livewire/customer-modal.blade.php`       | Home, Checkout                                  |
| **Filter Modal**   | `livewire/filter-modal.blade.php`         | All Food, Promo, Favorite                       |
| **Menu Item List** | `livewire/menu-item-list.blade.php`       | Cart, Checkout                                  |
| **Delete Modal**   | `livewire/delete-confirm-modal.blade.php` | Cart                                            |
| **Toast**          | `livewire/toast.blade.php`                | Details, Checkout                               |
| **Modal**          | `components/modal.blade.php`              | Base modal component                            |
| **App Layout**     | `components/layouts/app.blade.php`        | All pages                                       |
| **Page Layout**    | `components/layouts/page.blade.php`       | Pages with bottom nav                           |

---

## 🎨 Untuk Redesign

Sediakan untuk setiap halaman:

1. **Referensi Design** - Screenshot/Figma link design baru
2. **Halaman yang diubah** - Sebutkan nomor halaman (1-12) atau admin resource
3. **Perubahan spesifik** - Section mana yang berubah (A, B, C, dll)

Contoh:

> "Redesign Home Page section A (Header) dan C (Promo Slider) sesuai referensi design ini..."
