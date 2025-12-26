# Production Performance Commands

## Laravel Cache Optimization

Run these commands before deploying to production:

```bash
# Clear all caches first
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build optimized caches
php artisan config:cache    # Cache configuration
php artisan route:cache     # Cache routes
php artisan view:cache      # Cache Blade views
php artisan event:cache     # Cache event listeners

# Single command to optimize all
php artisan optimize
```

## Vite Production Build

```bash
npm run build
```

## Verify

After deploying:

1. Check `storage/framework/cache/config.php` exists
2. Check `bootstrap/cache/routes-v7.php` exists
3. Check `storage/framework/views/*.php` are compiled
