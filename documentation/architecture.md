# Jajan Bang - System Architecture

> **Last Updated**: December 25, 2025

---

## Application Architecture

Jajan Bang follows a **Livewire Component-Based Architecture** with Filament for admin management.

```
┌─────────────────────────────────────────┐
│          Customer Side (Web)            │
├─────────────────────────────────────────┤
│  Livewire Components (Pages)            │
│  - HomePage                             │
│  - DetailPage                           │
│  - CartPage                             │
│  - CheckoutPage                         │
│  - ScanPage                             │
└──────────────┬──────────────────────────┘
               │
       ┌───────▼──────────┐
       │   Laravel Core   │
       │   - Routing      │
       │   - Middleware   │
       │   - ORM          │
       └───────┬──────────┘
               │
   ┌───────────▼────────────────┐
   │      Database (MySQL)      │
   │  - foods                   │
   │  - categories              │
   │  - transactions            │
   │  - transaction_items       │
   │  - barcodes                │
   │  - users                   │
   └────────────────────────────┘

┌─────────────────────────────────────────┐
│         Admin Side (Filament)           │
├─────────────────────────────────────────┤
│  Filament Resources                     │
│  - FoodsResource                        │
│  - CategoryResource                     │
│  - BarcodeResource                      │
│  - TransactionResource                  │
└─────────────────────────────────────────┘
```

---

## Design Patterns

- **MVC**: Model-View-Controller for core structure
- **Component-Based**: Livewire for reactive UI
- **Repository Pattern**: Models handle data logic
- **Service Layer**: Payment processing (Midtrans)
- **Trait Composition**: CartManagement, CategoryFilterTrait

---

## Data Flow

### Customer Flow

```
Scan QR → ScanPage → Browse Menu → HomePage/AllFoodPage → Add to Cart → CartPage (session) → Checkout → Payment Gateway → PaymentSuccessPage
```

### Admin Flow

```
Login → Filament Dashboard → Manage Resources (CRUD) → View Reports → Generate QR Codes
```

---

## External Integrations

| Service                      | Purpose                   |
| ---------------------------- | ------------------------- |
| **Midtrans**                 | Payment gateway           |
| **Unsplash**                 | Food images (placeholder) |
| **SimpleSoftwareIO QR Code** | QR generation             |

---

## Database Schema

### Tables Overview

#### 1. **users**

Admin/staff accounts for management

| Column     | Type            | Description            |
| ---------- | --------------- | ---------------------- |
| id         | bigint (PK)     | Primary key            |
| name       | string          | User name              |
| email      | string (unique) | Login email            |
| password   | string          | Hashed password        |
| role       | enum            | admin, staff           |
| timestamps | -               | created_at, updated_at |

---

#### 2. **categories**

Food categories for organization

| Column      | Type              | Description            |
| ----------- | ----------------- | ---------------------- |
| id          | bigint (PK)       | Primary key            |
| name        | string            | Category name          |
| description | text (nullable)   | Category description   |
| icon        | string (nullable) | Icon identifier        |
| timestamps  | -                 | created_at, updated_at |

**Seeded Values**: Makanan Berat, Makanan Ringan, Minuman, Dessert, Paket Hemat

---

#### 3. **foods**

Menu items available for order

| Column              | Type                     | Description            |
| ------------------- | ------------------------ | ---------------------- |
| id                  | bigint (PK)              | Primary key            |
| name                | string                   | Food name              |
| description         | text                     | Food description       |
| image               | string                   | URL or path            |
| price               | decimal(10,2)            | Original price         |
| price_afterdiscount | decimal(10,2) (nullable) | Discounted price       |
| percent             | integer (nullable)       | Discount percentage    |
| is_promo            | boolean                  | Default: false         |
| categories_id       | bigint (FK)              | → categories.id        |
| timestamps          | -                        | created_at, updated_at |

---

#### 4. **barcodes**

QR codes for table identification

| Column       | Type            | Description            |
| ------------ | --------------- | ---------------------- |
| id           | bigint (PK)     | Primary key            |
| table_number | string          | Table identifier       |
| token        | string (unique) | Unique token           |
| image        | string          | SVG path               |
| is_active    | boolean         | Active status          |
| timestamps   | -               | created_at, updated_at |

---

#### 5. **transactions**

Customer order transactions

| Column            | Type              | Description                               |
| ----------------- | ----------------- | ----------------------------------------- |
| id                | bigint (PK)       | Primary key                               |
| invoice_number    | string (unique)   | Invoice ID                                |
| customer_name     | string            | Customer name                             |
| customer_phone    | string            | Phone number                              |
| table_number      | string            | Table from QR scan                        |
| total_price       | decimal(10,2)     | Order total                               |
| payment_method    | enum              | cash, qris, transfer                      |
| payment_status    | enum              | pending, paid, failed                     |
| order_status      | enum              | pending, processing, completed, cancelled |
| midtrans_order_id | string (nullable) | Midtrans reference                        |
| timestamps        | -                 | created_at, updated_at                    |

---

#### 6. **transaction_items**

Individual items in each transaction

| Column         | Type          | Description            |
| -------------- | ------------- | ---------------------- |
| id             | bigint (PK)   | Primary key            |
| transaction_id | bigint (FK)   | → transactions.id      |
| foods_id       | bigint (FK)   | → foods.id             |
| quantity       | integer       | Item quantity          |
| price          | decimal(10,2) | Price per item         |
| subtotal       | decimal(10,2) | quantity × price       |
| timestamps     | -             | created_at, updated_at |

---

## Entity Relationships

```
categories ────┬───→ foods (1:N)
               │
foods ─────────┬───→ transaction_items (1:N)
               │
transactions ──┬───→ transaction_items (1:N)
```

---

## Database Indexes

| Table             | Column         | Type              |
| ----------------- | -------------- | ----------------- |
| foods             | categories_id  | Foreign key index |
| transaction_items | transaction_id | Foreign key index |
| transaction_items | foods_id       | Foreign key index |
| transactions      | invoice_number | Unique index      |
| barcodes          | token          | Unique index      |

---

## Seeded Data

- **5 Categories**: Makanan Berat, Makanan Ringan, Minuman, Dessert, Paket Hemat
- **15 Foods**: Sample menu items with Unsplash images
- **10 Barcodes**: QR codes for tables 1-10
