# Jajan Bang - QR-Based Food Ordering System

## Project Overview

**Jajan Bang** is a modern, QR code-based food ordering system built with Laravel 11 and Livewire. The application allows customers to scan QR codes at tables to browse menus, place orders, and make payments seamlessly.

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Livewire 3, Alpine.js, TailwindCSS
- **Admin Panel**: Filament v4
- **Database**: MySQL/MariaDB
- **QR Code**: SimpleSoftwareIO/simple-qrcode
- **Image Storage**: Laravel Storage (local/cloud)

## Key Features

- 📱 QR Code table scanning
- 🍔 Digital menu browsing with categories
- 🛒 Shopping cart management
- 💳 Integrated payment processing (Midtrans)
- 📊 Admin dashboard for management
- 📈 Real-time order tracking
- ⭐ Favorites and promotions system

## User Roles

1. **Customer**: Browse menu, place orders, make payments
2. **Admin**: Manage foods, categories, transactions, generate QR codes

## Project Structure

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

## Development Status

✅ Core functionality complete
✅ Admin panel operational
✅ Payment integration active
🔄 Ongoing UI/UX improvements
