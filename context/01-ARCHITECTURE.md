# System Architecture

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

## Design Patterns

- **MVC**: Model-View-Controller for core structure
- **Component-Based**: Livewire for reactive UI
- **Repository Pattern**: Models handle data logic
- **Service Layer**: Payment processing (Midtrans)
- **Trait Composition**: CartManagement, CategoryFilterTrait

## Data Flow

1. **Customer Flow**:
    - Scan QR → ScanPage
    - Browse Menu → HomePage/AllFoodPage
    - Add to Cart → CartPage (session-based)
    - Checkout → Payment Gateway
    - Confirmation → PaymentSuccessPage

2. **Admin Flow**:
    - Login → Filament Dashboard
    - Manage Resources (CRUD)
    - View Reports
    - Generate QR Codes

## External Integrations

- **Midtrans**: Payment gateway
- **Unsplash**: Food images (placeholder)
- **SimpleSoftwareIO QR Code**: QR generation
