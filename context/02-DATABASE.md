# Database Schema

## Tables Overview

### 1. **users**

Admin/staff accounts for management

```
- id: bigint (PK)
- name: string
- email: string (unique)
- password: string (hashed)
- role: enum (admin, staff)
- timestamps
```

### 2. **categories**

Food categories for organization

```
- id: bigint (PK)
- name: string (Makanan Berat, Snack, Minuman, Dessert, Paket)
- description: text (nullable)
- icon: string (nullable)
- timestamps
```

### 3. **foods**

Menu items available for order

```
- id: bigint (PK)
- name: string
- description: text
- image: string (URL or path)
- price: decimal(10,2)
- price_afterdiscount: decimal(10,2) (nullable)
- percent: integer (nullable)
- is_promo: boolean (default: false)
- categories_id: bigint (FK → categories.id)
- timestamps
```

### 4. **barcodes**

QR codes for table identification

```
- id: bigint (PK)
- table_number: string
- token: string (unique)
- image: string (SVG path)
- is_active: boolean
- timestamps
```

### 5. **transactions**

Customer order transactions

```
- id: bigint (PK)
- invoice_number: string (unique)
- customer_name: string
- customer_phone: string
- table_number: string
- total_price: decimal(10,2)
- payment_method: enum (cash, qris, transfer)
- payment_status: enum (pending, paid, failed)
- order_status: enum (pending, processing, completed, cancelled)
- midtrans_order_id: string (nullable)
- timestamps
```

### 6. **transaction_items**

Individual items in each transaction

```
- id: bigint (PK)
- transaction_id: bigint (FK → transactions.id)
- foods_id: bigint (FK → foods.id)
- quantity: integer
- price: decimal(10,2)
- subtotal: decimal(10,2)
- timestamps
```

## Relationships

```
categories ──┬─→ foods
             │
             └─→ (1:N)

foods ───────┬─→ transaction_items
             │
             └─→ (1:N)

transactions ─┬─→ transaction_items
              │
              └─→ (1:N)
```

## Indexes

- `foods.categories_id` (foreign key index)
- `transaction_items.transaction_id` (foreign key index)
- `transaction_items.foods_id` (foreign key index)
- `transactions.invoice_number` (unique index)
- `barcodes.token` (unique index)

## Seeded Data

- **5 Categories**: Makanan Berat, Makanan Ringan, Minuman, Dessert, Paket Hemat
- **15 Foods**: Sample menu items with Unsplash images
- **10 Barcodes**: QR codes for tables 1-10
