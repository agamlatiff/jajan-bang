# Deployment Guide

## Requirements

### Server Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB >= 5.7
- Web Server (Apache/Nginx)

### PHP Extensions

- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD or Imagick (for QR codes)

---

## Local Development

### 1. Clone & Install

```bash
# Clone repository
git clone <repo-url>
cd jajan-bang

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_DATABASE=jajan_bang
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed sample data
php artisan db:seed
```

### 4. Storage Link

```bash
# Create symbolic link
php artisan storage:link
```

### 5. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 6. Run Server

```bash
php artisan serve
```

Access at: `http://localhost:8000`

---

## Production Deployment

### Option 1: Shared Hosting

#### Upload Files

```
- Upload all files except .git, node_modules, vendor
- Set document root to /public
```

#### Run Commands via SSH

```bash
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

#### File Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

### Option 2: VPS (Ubuntu)

#### 1. Server Setup

```bash
# Update packages
sudo apt update && sudo apt upgrade

# Install PHP 8.2
sudo apt install php8.2-fpm php8.2-mysql php8.2-mbstring \
  php8.2-xml php8.2-gd php8.2-curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs
```

#### 2. Nginx Configuration

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/jajan-bang/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 3. SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com
```

---

### Option 3: Docker

#### Dockerfile

```dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

CMD php artisan serve --host=0.0.0.0 --port=8000
```

---

## Environment Variables

### Essential Settings

```env
APP_NAME="Jajan Bang"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jajan_bang
DB_USERNAME=root
DB_PASSWORD=your_password

# Midtrans Configuration
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

---

## Post-Deployment Checklist

- [ ] Environment file configured
- [ ] Database migrated
- [ ] Storage linked
- [ ] Caches cleared
- [ ] Assets built
- [ ] File permissions set
- [ ] SSL certificate installed
- [ ] Firewall configured
- [ ] Backup strategy in place
- [ ] Monitoring setup
- [ ] Error logging enabled

---

## Troubleshooting

### 500 Internal Server Error

```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check permissions
chmod -R 755 storage bootstrap/cache
```

### Storage Link Issues

```bash
# Remove existing link
rm public/storage

# Recreate
php artisan storage:link
```

### Database Connection Failed

- Check credentials in `.env`
- Verify database exists
- Test connection: `php artisan tinker` → `DB::connection()->getPdo();`
