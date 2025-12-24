# API Endpoints & Routes

## Web Routes (Customer-Facing)

### Public Routes

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

### Payment Routes

```php
POST /payment/checkout           // Process checkout
GET  /payment/success            // Payment success callback
GET  /payment/failure            // Payment failure callback
POST /payment/midtrans/callback  // Midtrans webhook
```

### QR Controller

```php
GET  /download-qr/{barcode_id}   // Download QR code
```

## Admin Routes (Filament)

### Authentication

```php
GET  /admin/login          // Admin login page
POST /admin/login          // Login submission
POST /admin/logout         // Logout
```

### Resource Management

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
GET  /admin/categories/create        // Create category
POST /admin/categories               // Store category
GET  /admin/categories/{id}/edit     // Edit category
PUT  /admin/categories/{id}          // Update category
DELETE /admin/categories/{id}        // Delete category

// Barcodes (QR Codes)
GET  /admin/barcodes                 // List QR codes
GET  /admin/barcodes/create          // Generate new QR
POST /admin/barcodes                 // Store QR code
GET  /admin/barcodes/{id}/edit       // Edit QR
PUT  /admin/barcodes/{id}            // Update QR
DELETE /admin/barcodes/{id}          // Delete QR

// Transactions
GET  /admin/transactions             // List transactions
GET  /admin/transactions/{id}        // View transaction details
```

## Livewire Component Endpoints

### Automatic Livewire Routes

```
POST /livewire/message/{component}   // Component updates
POST /livewire/upload-file           // File uploads
```

### Active Components

- `pages.home-page`
- `pages.detail-page`
- `pages.cart-page`
- `pages.checkout-page`
- `pages.all-food-page`
- `pages.favorite-page`
- `pages.promo-page`
- `components.food-card`
- `components.menu-item-list`

## Middleware Groups

### Web Middleware

- `web`: Session, CSRF, cookies
- Applied to all customer routes

### Admin Middleware

- `auth`: Require authentication
- `filament`: Filament-specific checks

## API Rate Limiting

Currently not implemented, but can be added:

```php
Route::middleware('throttle:60,1')->group(function () {
    // Limited to 60 requests per minute
});
```
