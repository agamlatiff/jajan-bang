# Admin Panel (Filament)

## Overview

Jajan Bang uses **Filament v4** for admin panel management. Admin panel is accessible at `/admin`.

## Default Credentials

```
Email: admin@example.com
Password: password
```

---

## Resource Management

### 1. Foods Resource

**Path**: `app/Filament/Resources/FoodsResource.php`

#### Form Fields

- **name**: Text input (required)
- **description**: Rich editor (required)
- **image**: File upload
    - Formats: JPG, PNG, WEBP
    - Max size: 2MB
    - Storage: `public/foods`
- **price**: Numeric input with "Rp" prefix
- **is_promo**: Toggle switch
- **percent**: Select (10%, 25%, 35%, 50%)
    - Visible only when `is_promo` is true
- **price_afterdiscount**: Auto-calculated, read-only
- **categories_id**: Relationship select

#### Table Columns

- Name (searchable)
- Image (with external URL support)
- Price (formatted as IDR)
- Discounted Price
- Discount Percentage
- Promo Status (icon)
- Category Name
- Timestamps (toggleable)

#### Actions

- Edit
- Delete (bulk)

---

### 2. Categories Resource

**Path**: `app/Filament/Resources/CategoryResource.php`

#### Form Fields

- **name**: Text input (required)
- **description**: Textarea (optional)
- **icon**: Text input (optional)

#### Table Columns

- Name
- Description
- Icon
- Foods Count (relationship count)
- Timestamps

---

### 3. Barcodes Resource (QR Codes)

**Path**: `app/Filament/Resources/BarcodeResource.php`

#### Form Fields

- **table_number**: Text input (required, unique)
- **token**: Auto-generated UUID
- **is_active**: Toggle (default: true)
- QR code generated automatically on creation

#### Table Columns

- Table Number
- QR Code Preview (custom column with SVG rendering)
- Status (active/inactive)
- Download Action
- Timestamps

#### Custom Column: QR Image

**Path**: `resources/views/filament/tables/columns/qr-image.blade.php`

Renders QR code SVG inline in table:

```php
@php
    $imagePath = $getRecord()->image;
    $fullPath = storage_path('app/public/' . $imagePath);
    $svgContent = file_get_contents($fullPath);
@endphp

<div class="w-16 h-16">
    {!! $svgContent !!}
</div>
```

---

### 4. Transactions Resource

**Path**: `app/Filament/Resources/TransactionResource.php`

#### Table Columns

- Invoice Number
- Customer Name
- Customer Phone
- Table Number
- Total Price (formatted IDR)
- Payment Method
- Payment Status (badge)
- Order Status (badge)
- Created At

#### Filters

- Payment Status
- Order Status
- Date Range

#### View Page

Shows transaction details with items breakdown.

---

## Customizations

### Image Column External URL Support

Modified `FoodsResource` to handle both local and external image URLs:

```php
Tables\Columns\ImageColumn::make('image')
    ->getStateUsing(fn ($record) => str_starts_with($record->image, 'http')
        ? $record->image
        : Storage::url($record->image)
    ),
```

### Auto Price Calculation

When promo is enabled, discounted price auto-calculates:

```php
Forms\Components\Select::make('percent')
    ->afterStateUpdated(function ($set, $get, $state) {
        if ($get("is_promo") && $get("price") && $get("percent")) {
            $discount = ($get("price") * (int) $get("percent")) / 100;
            $set("price_afterdiscount", $get("price") - $discount);
        }
    })
```

### QR Code Download

Custom action to download QR codes:

```php
// In BarcodeResource
Tables\Actions\Action::make('download')
    ->url(fn ($record) => route('download-qr', $record->id))
    ->openUrlInNewTab()
    ->icon('heroicon-o-arrow-down-tray')
```

---

## Navigation Structure

```
Admin Panel
├── Dashboard (home)
├── Foods
│   ├── List Foods
│   ├── Create Food
│   └── Edit Food
├── Categories
│   ├── List Categories
│   ├── Create Category
│   └── Edit Category
├── Barcodes
│   ├── List QR Codes
│   └── Generate New QR
└── Transactions
    ├── List Transactions
    └── View Details
```

---

## Dashboard Widgets (Future)

Planned widgets:

- Total Revenue (today/week/month)
- Active Orders
- Most Sold Items
- Recent Transactions
- Quick Actions

---

## User Management

Currently managed through Filament's built-in user system. To create admin:

```bash
php artisan make:filament-user
```

Or via seeder:

```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
]);
```

---

## Theming

Default Filament theme with custom primary color (orange).

To customize further, publish Filament config:

```bash
php artisan vendor:publish --tag=filament-config
```

---

## Performance Optimizations

### Eager Loading

```php
// In Resources
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with('categories'); // Eager load relationships
}
```

### Pagination

Default: 10 items per page
Can be changed per resource:

```php
protected static ?int $recordsPerPage = 25;
```
