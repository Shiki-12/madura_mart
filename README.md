# Madura Mart - E-Commerce Management System

A comprehensive Laravel-based e-commerce and inventory management system designed for distribution and sales operations.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Image Storage](#image-storage)
- [Deployment](#deployment)
- [Project Structure](#project-structure)
- [API Documentation](#api-documentation)
- [Troubleshooting](#troubleshooting)

---

## Overview

Madura Mart is a full-stack Laravel application for managing:
- **Product Catalog**: Track products with serial numbers, types, and pricing
- **Distributors**: Manage distributor information and contact details
- **Purchases**: Record purchase orders from distributors
- **Sales**: Track sales transactions and details
- **Orders**: Manage customer orders and order details
- **Deliveries**: Track delivery logistics and status
- **Expeditions**: Manage shipping partners and their information
- **User Authentication**: Multi-role user system with role-based access

---

## Features

- ✅ User authentication (Admin, Distributor, Courier)
- ✅ Product and inventory management
- ✅ Purchase order management
- ✅ Sales tracking and reporting
- ✅ Order and delivery management
- ✅ Distributor management
- ✅ Expedition/shipping partner management
- ✅ Dashboard with analytics
- ✅ Database-backed sessions
- ✅ Responsive UI with Soft UI Dashboard

---

## System Requirements

- **PHP**: ^8.2
- **MySQL**: 5.7 or higher
- **Node.js**: 16+ (for frontend assets)
- **Composer**: Latest version
- **Git**: For version control

---

## Installation

### Quick Start (Local Development)

**Step 1: Clone the repository**
```bash
git clone <repository-url>
cd madura_mart
```

**Step 2: Install dependencies**
```bash
composer install
```

**Step 3: Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

**Step 4: Database configuration**
Edit `.env` and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=madura_mart
DB_USERNAME=root
DB_PASSWORD=
```

**Step 5: Run migrations**
```bash
php artisan migrate
```

**Step 6: Start the server**
```bash
php artisan serve
```

Access at: `http://localhost:8000`

---

## Configuration

### Environment Variables (.env)

```env
# Application
APP_NAME=MaduraMart
APP_ENV=local
APP_KEY=base64:YFV2/9CqXuTt4ZsM40GsT0AYDZ8n9IEE0TNzb4nCQ2k=
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=madura_mart
DB_USERNAME=root
DB_PASSWORD=

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache
CACHE_STORE=database

# Queue
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=local
```

---

## Database Setup

### Migrations Included

The following tables are created automatically via migrations:

| Table | Purpose |
|-------|---------|
| `users` | User accounts and authentication |
| `distributors` | Distributor company information |
| `expeditions` | Shipping/logistics partners |
| `products` | Product catalog |
| `purchases` | Purchase orders from distributors |
| `purchase_details` | Line items in purchase orders |
| `orders` | Customer orders |
| `order_details` | Line items in customer orders |
| `sales` | Sales transactions |
| `sale_details` | Line items in sales |
| `deliveries` | Delivery tracking |

### Run Migrations

```bash
# Fresh install
php artisan migrate:fresh

# Standard migration
php artisan migrate

# Rollback
php artisan migrate:rollback

# Reset all
php artisan migrate:reset
```

---

## Image Storage

### Why NOT include `public/images` in version control?

- **Repository bloat**: Images significantly increase clone/pull times
- **Merge conflicts**: Multiple developers uploading images causes conflicts
- **Deployment complexity**: Different images on different environments
- **Storage waste**: Version history keeps old image versions
- **Security**: Accidental sensitive images in repo history

### Recommended Solution: Laravel Storage with Symbolic Link

This is the **recommended approach** for this project.

#### Setup Steps:

**1. Get the Images from my drive:**

https://drive.google.com/drive/folders/19Gf0l67piawa67zF95-R145cXQNb0BM_?usp=sharing

**2. Configure storage disk in `config/filesystems.php`:**

And just put it on public/images


#### File Structure After Setup:
```
storage/
└── app/
    └── public/
        └── expeditions/
            ├── image1.jpg
            ├── image2.png
            └── .gitkeep
```

---

## Deployment

### Pre-Deployment Checklist

- [ ] Test all features locally
- [ ] Run `php artisan test`
- [ ] Update `.env` with production database credentials
- [ ] Set `APP_DEBUG=false`
- [ ] Generate production key: `php artisan key:generate`
- [ ] Optimize application: `php artisan optimize`
- [ ] Build assets: `npm run build`
- [ ] Set up image storage strategy
- [ ] Configure database backups

## Project Structure

```
madura_mart/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── MakeAuthSetup.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php          # Authentication logic
│   │       ├── DashboardController.php     # Dashboard views
│   │       ├── DistributorController.php   # Distributor CRUD
│   │       ├── TestController.php          # Testing endpoints
│   │       └── Controller.php              # Base controller
│   ├── Models/                             # Eloquent models
│   │   ├── User.php
│   │   ├── Distributor.php
│   │   ├── Product.php
│   │   ├── Purchase.php
│   │   ├── PurchaseDetail.php
│   │   ├── Order.php
│   │   ├── OrderDetail.php
│   │   ├── Sale.php
│   │   ├── SaleDetail.php
│   │   ├── Delivery.php
│   │   └── Expedition.php
│   └── Providers/
│       └── AppServiceProvider.php
│
├── database/
│   ├── migrations/                         # Database schema
│   ├── factories/
│   │   └── UserFactory.php
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── resources/
│   ├── views/
│   │   ├── auth/                           # Login/Register pages
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   └── register-courier.blade.php
│   │   ├── dashboard/                      # Dashboard pages
│   │   │   └── index.blade.php
│   │   ├── distributor/                    # Distributor management
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── layout/                         # Layout templates
│   │   │   ├── master.blade.php
│   │   │   ├── menu.blade.php
│   │   │   └── navbar.blade.php
│   │   ├── test/
│   │   │   └── test.blade.php
│   │   ├── mizuki.blade.php
│   │   └── welcome.blade.php
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── css/
│       └── app.css
│
├── routes/
│   ├── web.php                             # Web routes
│   └── console.php                         # Console routes
│
├── storage/
│   ├── app/
│   │   └── public/                         # User-uploaded files
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/
│
├── public/
│   ├── layout/                             # Static assets (CSS, JS, fonts)
│   │   └── assets/
│   │       ├── css/
│   │       ├── js/
│   │       ├── fonts/
│   │       └── img/
│   ├── images/                             # .gitignored (use storage instead)
│   └── index.php                           # Entry point
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   ├── filesystems.php
│   ├── session.php
│   └── ...
│
├── bootstrap/
│   ├── app.php
│   ├── providers.php
│   └── cache/
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── vendor/                                 # Composer packages
├── .env                                    # Environment variables
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── vite.config.js
├── phpunit.xml
├── artisan
└── README.md
```

---

## Models Overview

### User
```php
// Authentication and user accounts
Fields: id, name, email, password, email_verified_at, created_at, updated_at
```

### Distributor
```php
// Supplier/distributor information
Fields: id, name, address, phone_number, timestamps
```

### Product
```php
// Product catalog
Fields: id, serial_number (unique), name, type, price, stock, description, timestamps
```

### Purchase & PurchaseDetail
```php
// Purchase orders from distributors
Purchase: id, note_number, purchase_date, distributor_id, timestamps
PurchaseDetail: id, note_number_purchase, product_id, quantity, price, timestamps
```

### Sale & SaleDetail
```php
// Sales transactions
Sale: id, sale_date, total_price, timestamps
SaleDetail: id, sale_id, product_id, quantity, price, timestamps
```

### Order & OrderDetail
```php
// Customer orders
Order: id, order_date, total_price, status, timestamps
OrderDetail: id, order_id, product_id, quantity, price, timestamps
```

### Delivery
```php
// Delivery tracking
Fields: id, delivery_date, order_id, expedition_id, status, timestamps
```

### Expedition
```php
// Shipping partners/couriers
Fields: id, name, address, phone_number, picture, timestamps
```

---

## API Documentation

### Authentication Routes

```php
// Public routes (accessible to everyone)
GET  /              Home page
GET  /mizuki        Profile page

// Authentication
GET  /register      Registration form
POST /register      Create new account
GET  /login         Login form
POST /login         Authenticate user
GET  /logout        Logout user
```

### Protected Routes (require login)

```php
// Dashboard
GET  /dashboard     Main dashboard

// Distributor Management
GET     /distributor           List all distributors
POST    /distributor           Store new distributor
GET     /distributor/create    Create form
GET     /distributor/{id}      Show distributor details
GET     /distributor/{id}/edit Edit form
PUT     /distributor/{id}      Update distributor
DELETE  /distributor/{id}      Delete distributor
```

### Controller Examples

**AuthController.php:**
```php
class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validates email/password
        // Authenticates user
        // Returns redirect or response
    }

    public function register(Request $request)
    {
        // Validates registration data
        // Creates new user
        // Returns success message
    }

    public function logout(Request $request)
    {
        // Logs out user
        // Clears session
    }
}
```

**DistributorController.php:**
```php
class DistributorController extends Controller
{
    public function index()
    {
        // Returns all distributors
        return view('distributor.index', [
            'distributors' => Distributor::all()
        ]);
    }

    public function store(Request $request)
    {
        // Validates input
        // Creates distributor
        // Returns redirect with message
    }

    public function update(Request $request, $id)
    {
        // Validates input
        // Updates distributor
        // Returns redirect with message
    }
}
```

---

## Common Commands

```bash
# Generate new model with migration
php artisan make:model ModelName -m

# Create controller
php artisan make:controller ControllerName

# Generate migration
php artisan make:migration create_table_name

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run tests
php artisan test

# Tinker (interactive shell)
php artisan tinker

# Serve application
php artisan serve --host=0.0.0.0 --port=8000
```

---

## Troubleshooting

### Database Errors

**"SQLSTATE[HY000]: General error: 1030"**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**"Class not found"**
```bash
composer dump-autoload
```

**Migration fails**
```bash
php artisan migrate:rollback
php artisan migrate
```

### Permission Issues

```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap

# Fix public directory
chmod -R 755 public
```

### Images Not Displaying

1. Verify storage symbolic link:
   ```bash
   php artisan storage:link
   ls -la public/storage
   ```

2. Check image exists:
   ```bash
   ls -la storage/app/public/expeditions/
   ```

3. Check permissions:
   ```bash
   chmod -R 755 storage/app/public
   ```

4. Verify view code:
   ```blade
   {{-- Correct --}}
   <img src="{{ asset('storage/' . $expedition->picture) }}" alt="">
   <img src="{{ Storage::url($expedition->picture) }}" alt="">
   ```

### Mail Not Working

Configure in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Session Issues

Ensure database is migrated:
```bash
php artisan migrate
```

Check session configuration in `.env`:
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

---

## Development Tips

### Local Development

**Watch file changes:**
```bash
npm run dev
```

**Run in background:**
```bash
php artisan serve &
npm run dev &
```

**Database testing:**
```bash
php artisan migrate:fresh --seed
```

### Debugging

**Using dd() function:**
```php
dd($variable);  // Dump and die
dump($variable); // Just dump
```

**Using Log:**
```php
use Illuminate\Support\Facades\Log;

Log::info('Debug message', ['variable' => $value]);
Log::debug('Debug:', $data);
Log::error('Error:', $error);
```

**View logs:**
```bash
tail -f storage/logs/laravel.log
```

---

## Performance Optimization

### Production Build

```bash
# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Caching

```bash
# Cache configuration
php artisan config:cache

# Clear all caches
php artisan cache:clear
```

---

## Support & Contact

**Project Created By:** Shiki-12  
**Last Updated:** January 2026  
**Laravel Version:** 12.0+  
**PHP Version:** 8.2+  

For issues, questions, or contributions, please contact the project maintainer.

---

**Happy coding! 🚀 from Shiki-21**
