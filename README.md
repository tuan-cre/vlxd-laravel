# VLXD - Construction Materials E-Commerce Platform

A full-featured e-commerce platform built with Laravel for a Vietnamese construction materials business. The system handles product catalog management, shopping cart, checkout, order processing, multi-warehouse inventory, customer loyalty programs, and an admin dashboard with revenue reporting.

## Tech Stack

- **Backend:** PHP 8.5, Laravel 13, Eloquent ORM
- **Database:** MySQL (utf8mb4, InnoDB) with stored procedures and optimized indexes
- **Frontend:** Bootstrap 5.3, Vanilla JavaScript, Chart.js
- **Libraries:** PHPMailer (SMTP email), CKEditor 5 (rich text editing)
- **Integration:** Coze AI Chatbot API

## Features

### Customer-Facing
- Product catalog with categories, brands, multi-image gallery
- Advanced filtering (price range, brand, stock status) with AJAX pagination
- Product search by name/description with Vietnamese diacritics support
- Session-based shopping cart with coupon/discount system
- Guest & registered user checkout with saved address book
- 4-tier loyalty/points system (Bronze → Silver → Gold → Platinum)
- Product reviews and ratings with moderation workflow
- News/blog system with rich text content

### Admin Panel
- Dashboard with KPIs: revenue, orders, products, low-stock alerts
- Full CRUD for products, categories, brands, coupons, news, warehouses
- Order management with 5-state workflow (Pending → Confirmed → Shipping → Completed → Cancelled)
- Multi-warehouse inventory with import bill management and approval workflow
- Revenue reports with Chart.js visualizations and CSV export
- Role-based access control (Admin, Staff, Customer)

### Technical
- Eloquent ORM with 22 models and defined relationships
- Form Request validation with Vietnamese error messages
- Service layer pattern (CartService, OrderService, ProductService, CouponService, RevenueService, AuthService)
- Middleware-based auth and role authorization
- Database stored procedures for reporting (order totals, stock summaries, revenue reports, top products)
- 28+ database indexes for query optimization
- Concurrency-safe inventory operations with `SELECT ... FOR UPDATE`
- Transaction-based order processing

## Installation

### Prerequisites
- PHP 8.2+ with extensions: pdo_mysql, mbstring, xml, curl, zip, bcmath
- MySQL 5.7+ or MariaDB 10.3+
- Composer 2.x

### Setup

1. Clone the repository:
```bash
git clone <repository-url>
cd vlxd-laravel
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Update `.env` with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vlxd_db
DB_USERNAME=root
DB_PASSWORD=
```

5. Import the database:
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS vlxd_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root vlxd_db < data/vlxd.sql
```

6. Run migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

8. Open `http://localhost:8000` in your browser.

### Default Credentials
- **Admin:** admin@vlxd.com / 123456
- **Customer:** khachhang@gmail.com / 123456

## Project Structure

```
vlxd-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # 18 controllers (Auth, Product, Cart, Checkout, Admin*)
│   │   ├── Middleware/          # Auth, Admin, Staff, Customer role middleware
│   │   └── Requests/           # 10 Form Request validation classes
│   ├── Models/                 # 22 Eloquent models with relationships
│   └── Services/               # 6 service classes (Cart, Order, Product, Coupon, Revenue, Auth)
├── data/
│   └── vlxd.sql                # Database schema with seed data and triggers
├── database/
│   └── migrations/             # Stored procedures and database indexes
├── public/                     # Frontend assets, images, existing PHP views
├── routes/
│   └── web.php                 # 80+ routes (public, admin, staff)
├── config/                     # Laravel configuration
├── admin_legacy/               # Original admin panel (plain PHP)
├── model_legacy/               # Original model classes (plain PHP)
└── documents/                  # PDF price sheets
```

## Database

- 20+ tables with InnoDB engine
- Foreign key constraints with cascade/set null rules
- 3 database triggers for inventory stock synchronization
- 4 stored procedures for reporting
- 28+ indexes for query performance optimization
- Seed data included (products, categories, brands, users, orders)

## Security

- PDO prepared statements (SQL injection prevention)
- htmlspecialchars output escaping (XSS prevention)
- Laravel Form Request validation
- Session-based authentication with role-based access control
- File upload validation (size, MIME type, image dimensions)

## License

This project is for educational/portfolio purposes.
