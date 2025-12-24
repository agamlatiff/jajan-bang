# Authentication System

## Overview

Jajan Bang uses **Filament's built-in authentication** for admin access and **session-based tracking** for customers.

## Admin Authentication

### Login Flow

```
/admin/login → Filament Auth → Dashboard
```

### Features

- Email + Password authentication
- Remember me functionality
- Session-based auth
- CSRF protection
- Password hashing (bcrypt)

### Default Admin Account

```
Email: admin@example.com
Password: password
```

### Middleware

- `auth`: Protects admin routes
- `filament`: Filament-specific middleware

## Customer Flow (Session-Based)

Customers **do not require authentication**. Instead, we use:

### Session Management

```php
// Cart stored in session
session(['cart_items' => $items]);

// Table information from QR scan
session(['table_number' => $table]);
```

### Session Data Structure

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

## Security Measures

### CSRF Protection

All forms include `@csrf` directive

```blade
<form method="POST">
    @csrf
    <!-- form fields -->
</form>
```

### XSS Prevention

- Blade automatic escaping: `{{ $data }}`
- Raw output only when safe: `{!! $trustedHtml !!}`

### SQL Injection Prevention

- Eloquent ORM parameterized queries
- Query Builder with bindings

### Session Security

```php
// config/session.php
'secure' => env('SESSION_SECURE_COOKIE', false),
'http_only' => true,
'same_site' => 'lax',
```

## User Roles (Future Enhancement)

Currently single role: **Admin**

Planned roles:

- Admin (full access)
- Staff (limited access)
- Kitchen (order management only)
