# Features

## Core Features

### 1. QR Code Table System

- **QR Generation**: Automatic QR code creation for tables
- **Token-Based**: Unique tokens per table
- **SVG Format**: Scalable vector graphics for quality
- **Download**: Export QR codes for printing
- **Status Management**: Active/inactive table control

**Flow**:

```
Admin generates QR → Customer scans → Session stores table → Order linked to table
```

---

### 2. Digital Menu Browsing

- **Category Navigation**: 5 main categories
- **Search**: Find foods by name/description
- **Filtering**: Filter by category, promo status
- **Detail View**: Full food information with images
- **Image Support**: External URLs (Unsplash) + local storage

**Categories**:

- Makanan Berat
- Makanan Ringan
- Minuman
- Dessert
- Paket Hemat

---

### 3. Shopping Cart

- **Session-Based**: No login required
- **Multi-Item**: Add multiple foods
- **Quantity Control**: Increment/decrement
- **Selection**: Choose items for checkout
- **Price Calculation**: Auto-total with discounts
- **Persistence**: Cart saved in session

**Features**:

- Select all checkbox
- Individual item selection
- Real-time price updates
- Remove items

---

### 4. Promotions & Discounts

- **Percentage Discounts**: 10%, 25%, 35%, 50%
- **Price Display**: Original + discounted price
- **Badge**: Visual promo indicator
- **Auto-Calculate**: Discounted price in cart
- **Promo Page**: Dedicated promo listings

---

### 5. Favorite Foods

- **Sales Tracking**: Count total sold per item
- **Popularity Sorting**: Most sold items first
- **Homepage Feature**: Top items on homepage
- **Favorite Page**: Dedicated favorites view

**Query Logic**:

```sql
SELECT foods.*, SUM(transaction_items.quantity) as total_sold
FROM foods
LEFT JOIN transaction_items ON foods.id = transaction_items.foods_id
GROUP BY foods.id
ORDER BY total_sold DESC
```

---

### 6. Payment Integration (Midtrans)

- **Payment Methods**:
    - Cash
    - QRIS
    - Bank Transfer
- **Snap Integration**: Midtrans Snap popup
- **Callback Handling**: Success/failure redirection
- **Webhook**: Server-side payment verification
- **Invoice Generation**: Unique invoice numbers

**Payment Flow**:

```
Checkout → Create Transaction → Midtrans Token → Payment Page → Callback → Update Status
```

---

### 7. Transaction Management

- **Invoice System**: Unique invoice per order
- **Status Tracking**:
    - Payment: pending, paid, failed
    - Order: pending, processing, completed, cancelled
- **Transaction Items**: Detailed breakdown
- **Customer Info**: Name, phone, table
- **History**: Admin view all transactions

---

### 8. Admin Dashboard (Filament)

- **Resource Management**: CRUD for all entities
- **Table Views**: Sortable, searchable listings
- **Form Building**: Auto-generated forms
- **Image Upload**: Food images with validation
- **Statistics**: Transaction reports (future)

**Resources**:

- Foods: Menu items with categories
- Categories: Food groupings
- Barcodes: QR code management
- Transactions: Order history

---

## UI/UX Features

### Mobile-First Design

- Responsive layouts
- Touch-friendly controls
- Bottom navigation
- Smooth transitions

### Visual Feedback

- Toast notifications
- Loading states
- Empty states
- Error messages

### Accessibility

- Semantic HTML
- Alt text for images
- Keyboard navigation
- ARIA labels

---

## Planned Features (Roadmap)

### Coming Soon

- [ ] Order status tracking (real-time)
- [ ] Kitchen dashboard
- [ ] Receipt printing
- [ ] Customer order history
- [ ] Loyalty program
- [ ] Multi-language support
- [ ] Dark mode
- [ ] Push notifications
- [ ] Analytics dashboard
- [ ] Export reports (PDF/Excel)
