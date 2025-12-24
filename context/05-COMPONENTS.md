# Livewire Components

## Page Components

### 1. **HomePage** (`pages.home-page`)

**Location**: `app/Livewire/Pages/HomePage.php`

Displays featured foods and categories.

**Properties**:

- `$categories`: All categories
- `$foods`: Featured/popular foods
- `$favoriteFood`: Top selling items

**Methods**:

- `mount()`: Load initial data
- `render()`: Render view

---

### 2. **DetailPage** (`pages.detail-page`)

**Location**: `app/Livewire/Pages/DetailPage.php`

Shows individual food item details.

**Properties**:

- `$food`: Selected food item
- `$matchedCategory`: Food's category
- `$categories`: All categories

**Methods**:

- `mount($id)`: Load food details
- `addToCart()`: Add item to cart
- `orderNow()`: Quick order (add to cart + redirect)

---

### 3. **CartPage** (`pages.cart-page`)

**Location**: `app/Livewire/Pages/CartPage.php`

Manages shopping cart.

**Properties**:

- `$cartItems`: Items in cart (from session)
- `$selectAll`: Select all checkbox state
- `$selectedItems`: Currently selected items
- `$totalPrice`: Total of selected items

**Methods**:

- `increment($index)`: Increase quantity
- `decrement($index)`: Decrease quantity
- `updateSelectedItems()`: Recalculate totals
- `checkout()`: Navigate to checkout

**Traits**: `CartManagement`

---

### 4. **CheckoutPage** (`pages.checkout-page`)

**Location**: `app/Livewire/Pages/CheckoutPage.php`

Handles order checkout and payment.

**Properties**:

- `$cartItems`: Selected items from cart
- `$totalPrice`: Order total
- `$customerName`: Customer's name
- `$customerPhone`: Customer's phone
- `$tableNumber`: Table from QR scan
- `$paymentMethod`: Selected payment (cash/qris/transfer)

**Methods**:

- `processCheckout()`: Create transaction
- `redirectToPayment()`: Midtrans integration

---

### 5. **AllFoodPage** (`pages.all-food-page`)

**Location**: `app/Livewire/Pages/AllFoodPage.php`

Lists all foods with category filtering.

**Properties**:

- `$foods`: All available foods
- `$categories`: Category list
- `$selectedCategory`: Active filter

**Methods**:

- `filterByCategory($categoryId)`: Apply filter

**Traits**: `CategoryFilterTrait`

---

### 6. **FavoritePage** (`pages.favorite-page`)

Most sold/popular items.

---

### 7. **PromoPage** (`pages.promo-page`)

Items with active promotions.

---

### 8. **ScanPage** (`pages.scan-page`)

QR code scanner interface.

---

## Reusable Components

### 1. **FoodCard** (`components.food-card`)

**Location**: `app/Livewire/Components/FoodCard.php`

Displays food item in card format.

**Props**:

- `$data`: Food object
- `$index`: Card index

**Features**:

- Image display (external URL support)
- Price with discount
- Add to cart button
- Promo badge

---

### 2. **MenuItemList** (`components.menu-item-list`)

**Location**: `app/Livewire/Components/MenuItemList.php`

Renders list of cart items with controls.

**Props**:

- `$items`: Array of food items
- `$withCheckbox`: Show selection checkboxes

**Features**:

- Quantity controls
- Checkbox selection
- Price display with discounts

---

### 3. **PageTitleNav** (`components.page-title-nav`)

Page header with navigation.

**Props**:

- `$title`: Page title
- `$hasBack`: Show back button
- `$hasFilter`: Show filter button

---

### 4. **Toast** (`components.toast`)

Notification toast component.

**Events**:

- Listens to `toast` event
- Shows success/error messages

---

### 5. **FilterModal** (`components.filter-modal`)

Category filter modal.

### 6. **MainMenu** (`components.main-menu`)

Bottom navigation menu.

## Component Communication

### Event System

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

### Parent-Child Communication

```blade
{{-- Parent passes data to child --}}
<livewire:components.food-card :data="$food" :index="$i" />

{{-- Child calls parent method --}}
wire:click="$parent.methodName()"
```
