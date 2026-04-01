<div align="center">
  <h1>Madura Mart</h1>
  <p><strong>A comprehensive E-Commerce, POS, and Inventory Management System</strong></p>
</div>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5">
</p>

---

## Overview

**Madura Mart** is a robust, full-stack Laravel application designed to streamline distribution, procurement, inventory, and point-of-sale (POS) operations. Built with a beautiful and responsive **Soft UI Dashboard**, it provides deep analytics and role-based access control for owners, customers, and field couriers.

## Key Features

- **Role-Based Access Control**: Secure multi-role system (Owner/Admin, Customer, Courier).
- **Inventory Management**: Track products, stock levels, expiration dates, and custom pricing.
- **Procurement (Purchases)**: Record inward stock flows from distributors and manage supplier relationships.
- **Point of Sale (Sales)**: Fast and efficient daily sales transaction tracking.
- **Courier & Logistics Hub**: Assign expeditions, manage internal couriers, and track localized deliveries.
- **Advanced Analytics**: Comprehensive, real-time reporting dashboards for products, distributors, sales, and overall business health.
- **Responsive UI**: A mobile-friendly interface leveraging Bootstrap 5.

---

## User Roles

| Role | Access Level | Description |
|---|---|---|
| **Owner / Admin** | Complete Access | Full access to all management modules, financial reports, user approvals, and system configurations. |
| **Customer** | Client Portal | Can view available products, place orders, and track their personal purchase histories. |
| **Courier** | Delivery Portal | Access to the Courier Dashboard to view assigned deliveries, update shipping statuses, and process completions. |

---

## Tech Stack

- **Framework**: Laravel 11.x
- **Backend**: PHP 8.2+
- **Database**: MySQL 5.7+
- **Frontend**: Blade Templating, Bootstrap 5, Vanilla JS
- **UI Architecture**: Soft UI Dashboard
- **Styling**: SweetAlert2 (Alerts), FontAwesome (Icons)

---

## Installation & Setup

### 1. Requirements
Ensure you have the following installed on your local machine:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

### 2. Getting Started

Clone the repository and enter the directory:
```bash
git clone <repository-url>
cd madura_mart
```

Install PHP and Node dependencies:
```bash
composer install
npm install
npm run build
```

Set up your environment variables:
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Update your `.env` file with your local database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=madura_mart
DB_USERNAME=root
DB_PASSWORD=
```

Migrate the database and seed it with realistic dummy data:
```bash
php artisan migrate:fresh --seed
```
*(Note: The seeder will automatically generate products, transactions, and user accounts).*

### 4. Storage & Assets
Link the local storage to serve uploaded resources (like profile pictures):
```bash
php artisan storage:link
```

### 5. Launch the Application
Start the local development server:
```bash
php artisan serve
```
Visit `http://localhost:8000` in your browser.

---

## Default Credentials

After running the database seeders, you can access the system using the master owner account:

- **Email**: `admin@linux.com`
- **Password**: `adminpassword`

- **Email**: `test@example.com`
- **Password**: `tes12345`

*(Other dummy accounts for couriers and customers are auto-generated with the password `password` if you wish to test different role views).*

---

## Core Database Architecture

The system revolves around these primary operational flows:

1. **Procurement Flow**: `Distributors` -> `Purchases` -> `Purchase Details` -> `Products` (Increases Stock)
2. **Sales Flow (POS)**: `Sales` -> `Sale Details` -> `Products` (Decreases Stock)
3. **Logistics Flow**: `Orders` -> `Deliveries` -> `Expeditions / Couriers`

---

## Credits & Contact

**Project Created By:** Shiki-12 / Shiki-21  
**GitHub Profile:** [https://github.com/Shiki-12](https://github.com/Shiki-12)  

Happy Coding!
