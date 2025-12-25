# Jajan Bang - Technical Specifications

> **Last Updated**: December 25, 2025

---

## Project Overview

**Jajan Bang** is a modern, QR code-based food ordering system built with Laravel 11 and Livewire. The application allows customers to scan QR codes at tables to browse menus, place orders, and make payments seamlessly.

### Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Livewire 3, Alpine.js, TailwindCSS
- **Admin Panel**: Filament v4
- **Database**: MySQL/MariaDB
- **QR Code**: SimpleSoftwareIO/simple-qrcode
- **Image Storage**: Laravel Storage (local/cloud)

### Key Features

- 📱 QR Code table scanning
- 🍔 Digital menu browsing with categories
- 🛒 Shopping cart management
- 💳 Integrated payment processing (Midtrans)
- 📊 Admin dashboard for management
- 📈 Real-time order tracking
- ⭐ Favorites and promotions system

### User Roles

1. **Customer**: Browse menu, place orders, make payments
2. **Admin**: Manage foods, categories, transactions, generate QR codes

### Project Structure

```
jajan-bang/
├── app/
│   ├── Filament/         # Admin panel resources
│   ├── Http/Controllers/ # API & web controllers
│   ├── Livewire/         # Livewire components
│   └── Models/           # Eloquent models
├── database/
│   ├── migrations/       # Database schema
│   └── seeders/          # Sample data
├── resources/
│   └── views/            # Blade templates
└── routes/              # Web & API routes
```

---

## Authentication System

### Admin Authentication

#### Login Flow

```
/admin/login → Filament Auth → Dashboard
```

#### Features

- Email + Password authentication
- Remember me functionality
- Session-based auth
- CSRF protection
- Password hashing (bcrypt)

#### Default Admin Account

```
Email: admin@example.com
Password: password
```

#### Middleware

- `auth`: Protects admin routes
- `filament`: Filament-specific middleware

### Customer Flow (Session-Based)

Customers **do not require authentication**. Instead, we use:

#### Session Management

```php
// Cart stored in session
session(['cart_items' => $items]);

// Table information from QR scan
session(['table_number' => $table]);
```

#### Session Data Structure

```php
[
    'cart_items' => [
        [
            'id' => 1,
            'name' => 'Nasi Goreng',
            'price' => 25000,
            'quantity' => 2,
            'selected' => true
        ],
        // ...
    ],
    'table_number' => 'Table-1',
    'has_unpaid_transaction' => false
]
```

### Security Measures

- **CSRF Protection**: All forms include `@csrf` directive
- **XSS Prevention**: Blade automatic escaping `{{ $data }}`
- **SQL Injection Prevention**: Eloquent ORM parameterized queries
- **Session Security**: Secure cookies, http_only, same_site

---

## API Endpoints & Routes

### Web Routes (Customer-Facing)

#### Public Routes

```php
GET  /                      // Redirect to /scan
GET  /scan                  // QR scan page
GET  /menu                  // Homepage with featured items
GET  /all-food              // All foods listing with categories
GET  /food/{id}             // Food detail page
GET  /favorite              // Favorite/popular foods
GET  /promo                 // Promotional items
GET  /cart                  // Shopping cart
GET  /checkout              // Checkout page
```

#### Payment Routes

```php
POST /payment/checkout           // Process checkout
GET  /payment/success            // Payment success callback
GET  /payment/failure            // Payment failure callback
POST /payment/midtrans/callback  // Midtrans webhook
```

#### QR Controller

```php
GET  /download-qr/{barcode_id}   // Download QR code
```

### Admin Routes (Filament)

#### Authentication

```php
GET  /admin/login          // Admin login page
POST /admin/login          // Login submission
POST /admin/logout         // Logout
```

#### Resource Management

```php
// Foods Management
GET  /admin/foods                    // List all foods
GET  /admin/foods/create             // Create food form
POST /admin/foods                    // Store new food
GET  /admin/foods/{id}/edit          // Edit food form
PUT  /admin/foods/{id}               // Update food
DELETE /admin/foods/{id}             // Delete food

// Categories Management
GET  /admin/categories               // List all categories
...

// Barcodes (QR Codes)
GET  /admin/barcodes                 // List QR codes
...

// Transactions
GET  /admin/transactions             // List transactions
GET  /admin/transactions/{id}        // View transaction details
```

### Livewire Component Endpoints

#### Active Components

- `pages.home-page`
- `pages.detail-page`
- `pages.cart-page`
- `pages.checkout-page`
- `pages.all-food-page`
- `pages.favorite-page`
- `pages.promo-page`
- `components.food-card`
- `components.menu-item-list`

### Middleware Groups

- **Web Middleware**: `web` - Session, CSRF, cookies
- **Admin Middleware**: `auth`, `filament`

---

## Livewire Components

### Page Components

| Component        | Location              | Description                       |
| ---------------- | --------------------- | --------------------------------- |
| **HomePage**     | `pages.home-page`     | Featured foods and categories     |
| **DetailPage**   | `pages.detail-page`   | Individual food item details      |
| **CartPage**     | `pages.cart-page`     | Shopping cart management          |
| **CheckoutPage** | `pages.checkout-page` | Order checkout and payment        |
| **AllFoodPage**  | `pages.all-food-page` | All foods with category filtering |
| **FavoritePage** | `pages.favorite-page` | Most sold/popular items           |
| **PromoPage**    | `pages.promo-page`    | Items with active promotions      |
| **ScanPage**     | `pages.scan-page`     | QR code scanner interface         |

### Reusable Components

| Component        | Description                                                |
| ---------------- | ---------------------------------------------------------- |
| **FoodCard**     | Food item in card format with image, price, discount badge |
| **MenuItemList** | List of cart items with quantity controls                  |
| **PageTitleNav** | Page header with navigation                                |
| **Toast**        | Notification toast component                               |
| **FilterModal**  | Category filter modal                                      |
| **MainMenu**     | Bottom navigation menu                                     |

### Component Communication

```php
// Dispatch event
$this->dispatch('toast', data: [
    'message1' => 'Success!',
    'message2' => 'Item added',
    'type' => 'success'
]);

// Listen for event
#[On('toast')]
public function showToast($data) { ... }
```

---

## Features

### Core Features

#### 1. QR Code Table System

- **QR Generation**: Automatic QR code creation for tables
- **Token-Based**: Unique tokens per table
- **SVG Format**: Scalable vector graphics for quality
- **Download**: Export QR codes for printing
- **Status Management**: Active/inactive table control

**Flow**: `Admin generates QR → Customer scans → Session stores table → Order linked to table`

#### 2. Digital Menu Browsing

- **Category Navigation**: 5 main categories (Makanan Berat, Makanan Ringan, Minuman, Dessert, Paket Hemat)
- **Search**: Find foods by name/description
- **Filtering**: Filter by category, promo status
- **Detail View**: Full food information with images

#### 3. Shopping Cart

- **Session-Based**: No login required
- **Multi-Item**: Add multiple foods
- **Quantity Control**: Increment/decrement
- **Selection**: Choose items for checkout
- **Price Calculation**: Auto-total with discounts
- **Persistence**: Cart saved in session

#### 4. Promotions & Discounts

- **Percentage Discounts**: 10%, 25%, 35%, 50%
- **Price Display**: Original + discounted price
- **Badge**: Visual promo indicator

#### 5. Payment Integration (Midtrans)

- **Payment Methods**: Cash, QRIS, Bank Transfer
- **Snap Integration**: Midtrans Snap popup
- **Webhook**: Server-side payment verification
- **Invoice Generation**: Unique invoice numbers

**Flow**: `Checkout → Create Transaction → Midtrans Token → Payment Page → Callback → Update Status`

#### 6. Transaction Management

- **Invoice System**: Unique invoice per order
- **Status Tracking**: Payment (pending, paid, failed) & Order (pending, processing, completed, cancelled)
- **Transaction Items**: Detailed breakdown

### UI/UX Features

- **Mobile-First Design**: Responsive layouts, touch-friendly controls
- **Visual Feedback**: Toast notifications, loading states, empty states
- **Accessibility**: Semantic HTML, alt text for images

### Planned Features

- [ ] Order status tracking (real-time)
- [ ] Kitchen dashboard
- [ ] Receipt printing
- [ ] Loyalty program
- [ ] Multi-language support
- [ ] Dark mode

---

## Admin Panel (Filament)

### Default Credentials

```
Email: admin@example.com
Password: password
```

### Resource Management

#### 1. Foods Resource

**Form Fields**:

- name, description (Rich editor), image (JPG/PNG/WEBP, max 2MB)
- price (Rp prefix), is_promo (toggle), percent (10/25/35/50%)
- price_afterdiscount (auto-calculated), categories_id

**Table Columns**: Name, Image, Price, Discounted Price, Promo Status, Category

#### 2. Categories Resource

**Form Fields**: name, description, icon

#### 3. Barcodes Resource (QR Codes)

**Form Fields**: table_number (unique), token (auto UUID), is_active
**Features**: QR code preview, download action

#### 4. Transactions Resource

**Table Columns**: Invoice, Customer Name/Phone, Table, Total Price, Payment/Order Status
**Filters**: Payment Status, Order Status, Date Range

### Navigation Structure

```
Admin Panel
├── Dashboard
├── Foods (List, Create, Edit)
├── Categories (List, Create, Edit)
├── Barcodes (List, Generate)
└── Transactions (List, View Details)
```

### Customizations

- **External URL Support**: ImageColumn handles both local and external URLs
- **Auto Price Calculation**: Discounted price auto-calculates when promo enabled
- **QR Download**: Custom action to download QR codes
