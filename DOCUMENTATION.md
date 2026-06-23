# Store Management System of BUBT - Complete Documentation

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Technology Stack](#2-technology-stack)
3. [Project Structure](#3-project-structure)
4. [Features & Modules](#4-features--modules)
5. [Database Schema](#5-database-schema)
6. [API Routes](#6-api-routes)
7. [User Roles & Permissions](#7-user-roles--permissions)
8. [Installation Guide](#8-installation-guide)
9. [Configuration](#9-configuration)
10. [Running the Application](#10-running-the-application)

---

## 1. Project Overview

### 1.1 Project Description

The **Store Management System of BUBT** is a comprehensive Laravel-based inventory management application designed for institutional use at Bangladesh University of Business and Technology (BUBT). The system facilitates efficient management of products, purchases, requisitions, issues, and reporting across various departments.

### 1.2 Key Objectives

- **Inventory Management**: Track products, stock levels, and categories
- **Purchase Management**: Handle purchase orders and supplier management
- **Requisition System**: Allow department users to request products
- **Issue Management**: Distribute products to users/departments
- **Damage Tracking**: Report and track damaged products
- **Reporting**: Generate comprehensive reports (Purchase, Stock, Damage, Fixed Asset, Product TRX, Lifetime)
- **Access Control**: Role-based permissions (Super Admin, Admin, Department User)
- **Communication**: Real-time chat via Chatify

### 1.3 Project Type

- **Framework**: Laravel 12.0
- **Language**: PHP 8.2
- **Database**: MySQL
- **Frontend**: Blade Templates with Tailwind CSS and Alpine.js

---

## 2. Technology Stack

### 2.1 Backend Technologies

| Component | Technology | Version |
|-----------|------------|---------|
| Framework | Laravel | 12.0 |
| PHP | PHP | 8.2 |
| Database | MySQL | 8.x |
| Authentication | Laravel Breeze | 2.3 |
| Permissions | Spatie Permission | 6.17 |

### 2.2 Frontend Technologies

| Component | Technology | Version |
|-----------|------------|---------|
| CSS Framework | Tailwind CSS | 3.x |
| JavaScript | Alpine.js | 3.x |
| Build Tool | Vite | 6.x |
| Template Engine | Blade | - |

### 2.3 Additional Packages

| Package | Purpose | Version |
|---------|---------|---------|
| barryvdh/laravel-dompdf | PDF Generation | 3.1 |
| intervention/image | Image Handling | 3.11 |
| munafio/chatify | Real-time Chat | 1.6 |
| spatie/laravel-permission | Role & Permission | 6.17 |

---

## 3. Project Structure

### 3.1 Directory Structure

```
Store Management System of BUBT/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── Auth/
│   │   │   ├── Backend/
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── CheckPermissionOrRole.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── Brand.php
│   │   ├── DamageProduct.php
│   │   ├── Department.php
│   │   ├── Issue.php
│   │   ├── Product.php
│   │   ├── Purchase.php
│   │   ├── Quotation.php
│   │   ├── Requisition.php
│   │   ├── Semester.php
│   │   ├── Supplier.php
│   │   └── User.php
│   ├── Providers/
│   ├── Services/
│   │   └── Reports/
│   └── View/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   ├── web.php
│   ├── auth.php
│   ├── chatify/
│   └── console.php
├── storage/
├── tests/
├── vendor/
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
└── vite.config.js
```

### 3.2 Key Directories

| Directory | Description |
|-----------|-------------|
| `app/Http/Controllers/Backend/` | All business logic controllers |
| `app/Models/` | Eloquent ORM models |
| `app/Services/Reports/` | Report generation services |
| `database/migrations/` | Database schema definitions |
| `resources/views/` | Blade templates |
| `routes/` | Route definitions |

---

## 4. Features & Modules

### 4.1 Product Management

- **Categories**: Create, edit, delete product categories
- **Subcategories**: Manage subcategories under categories
- **Brands**: Manage product brands
- **Products**: Full CRUD operations with SKU generation
- **Stock Tracking**: Monitor stock levels with alert thresholds
- **Fixed Asset**: Mark products as fixed assets

### 4.2 Purchase Management

- **Purchase Orders**: Create purchase orders from suppliers
- **Purchase Details**: Track date, supplier, items, totals
- **Discount & Shipping**: Calculate with discount and shipping costs
- **File Upload**: Attach documents to purchases
- **Tracking**: Track purchase orders with tracking numbers

### 4.3 Return Purchase Management

- **Return Orders**: Create return orders to suppliers
- **Return Details**: Track return date, supplier, items, totals

### 4.4 Requisition Management

- **Create Requisition**: Department users request products
- **Approval Workflow**: Admin approves/rejects requests
- **Status Tracking**: Pending, Approved, Rejected statuses

### 4.5 Issue Management

- **Issue Products**: Issue products to users/departments
- **Fulfill Requisition**: Link issues to requisitions
- **Issue Returns**: Handle product returns from users

### 4.6 Damage Product Management

- **Report Damage**: Track damaged products
- **Damage Details**: Record date, items, notes

### 4.7 Quotation Management

- **Create Quotations**: Generate supplier quotations
- **Quotation Items**: Add products with prices
- **Track Total**: Calculate subtotal, discount, grand total

### 4.8 Report Generation

| Report Type | Description |
|-------------|-------------|
| Purchase Report | All purchase transactions |
| Purchase Return Report | Return purchases |
| Damage Product Report | Damaged products |
| Issue Report | Product issues |
| Issue Return Report | Product returns |
| Stock Report | Current stock levels |
| Fixed Asset Report | Fixed asset products |
| Product TRX Report | Product transactions |
| Product Lifetime Report | Product lifecycle |

### 4.9 User Management

- **User Roles**: Super Admin, Admin, Department User
- **Department Assignment**: Assign users to departments
- **Semester Management**: Manage academic semesters

### 4.10 Chat System

- **Real-time Chat**: Built-in chat via Chatify
- **User Messaging**: Internal messaging between users

---

## 5. Database Schema

### 5.1 Core Tables

#### 5.1.1 Users Table

```php
- id (bigint, PK)
- name (string)
- email (string, unique)
- email_verified_at (timestamp, nullable)
- password (string)
- photo (string, nullable)
- phone (string, nullable)
- address (string, nullable)
- role (string, nullable)
- department_id (bigint, FK, nullable)
- status (string, default: 'active')
- avatar (string, nullable)
- dark_mode (boolean, nullable)
- messenger_color (string, nullable)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 5.1.2 Products Table

```php
- id (bigint, PK)
- name (string)
- code (string)
- image (json, nullable)
- category_id (bigint, FK)
- brand_id (bigint, FK, nullable)
- supplier_id (bigint, FK, nullable)
- subcategory_id (bigint, FK, nullable)
- price (decimal)
- product_qty (integer)
- stock_alert (integer, nullable)
- discount (decimal, nullable)
- product_cost (decimal, nullable)
- fixed_asset (boolean, default: false)
- note (text, nullable)
- status (string, default: 'active')
- active (tinyint, default: 1)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 5.1.3 Purchases Table

```php
- id (bigint, PK)
- date (date)
- supplier_id (bigint, FK)
- discount (decimal, default: 0)
- shipping (decimal, default: 0)
- status (string, default: 'pending')
- note (text, nullable)
- grand_total (decimal)
- tracking_no (string, nullable)
- note_no (string, nullable)
- file_upload (string, nullable)
- semester_id (bigint, FK)
- department_id (bigint, FK)
- user_id (bigint, FK)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 5.1.4 Requisitions Table

```php
- id (bigint, PK)
- date (date)
- user_id (bigint, FK)
- semester_id (bigint, FK)
- department_id (bigint, FK)
- notes (text, nullable)
- status (string, default: 'pending')
- created_at (timestamp)
- updated_at (timestamp)
```

#### 5.1.5 Issues Table

```php
- id (bigint, PK)
- date (date)
- requisition_id (bigint, FK, nullable)
- user_id (bigint, FK)
- issued_by (bigint, FK)
- semester_id (bigint, FK)
- department_id (bigint, FK)
- notes (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

#### 5.1.6 Semesters Table

```php
- id (bigint, PK)
- name (string)
- slug (string)
- code (string, nullable)
- status (string, default: 'active')
- created_at (timestamp)
- updated_at (timestamp)
```

#### 5.1.7 Departments Table

```php
- id (bigint, PK)
- name (string)
- code (string)
- head_of_department (string, nullable)
- head_of_department_email (string, nullable)
- head_of_department_phone (string, nullable)
- status (string, default: 'active')
- created_at (timestamp)
- updated_at (timestamp)
```

### 5.2 Related Tables

| Table | Description |
|-------|-------------|
| `brands` | Product brands |
| `product_categories` | Product categories |
| `subcategories` | Product subcategories |
| `suppliers` | Supplier information |
| `product_images` | Product image gallery |
| `purchase_items` | Items in purchases |
| `return_purchases` | Return purchases |
| `return_purchase_items` | Items in return purchases |
| `requisition_items` | Items in requisitions |
| `issue_items` | Items in issues |
| `issue_returns` | Issue return records |
| `issue_return_items` | Items in issue returns |
| `damage_products` | Damage product records |
| `damage_product_items` | Items in damage products |
| `quotations` | Supplier quotations |
| `quotation_items` | Items in quotations |

### 5.3 Permission Tables (Spatie)

```php
- permissions
- roles
- model_has_permissions
- model_has_roles
- role_has_permissions
```

---

## 6. API Routes

### 6.1 Authentication Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/login` | Login page |
| POST | `/login` | Login action |
| GET | `/register` | Register page |
| POST | `/register` | Register action |
| POST | `/logout` | Logout action |

### 6.2 Dashboard Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/dashboard` | Dashboard with statistics |

### 6.3 Brand Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/all/brand` | All brands |
| GET | `/add/brand` | Add brand form |
| POST | `/store/brand` | Store brand |
| GET | `/edit/brand/{id}` | Edit brand form |
| POST | `/update/brand` | Update brand |
| GET | `/delete/brand/{id}` | Delete brand |

### 6.4 Supplier Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/all/supplier` | All suppliers |
| GET | `/add/supplier` | Add supplier form |
| POST | `/store/supplier` | Store supplier |
| GET | `/edit/supplier/{id}` | Edit supplier form |
| POST | `/update/supplier` | Update supplier |
| GET | `/delete/supplier/{id}` | Delete supplier |

### 6.5 Product Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/all/category` | All categories |
| POST | `/store/category` | Store category |
| GET | `/edit/category/{id}` | Edit category |
| POST | `/update/category` | Update category |
| GET | `/delete/category/{id}` | Delete category |
| GET | `/all/subcategory` | All subcategories |
| POST | `/store/subcategory` | Store subcategory |
| GET | `/all/product` | All products |
| GET | `/add/product` | Add product form |
| POST | `/store/product` | Store product |
| GET | `/edit/product/{id}` | Edit product form |
| POST | `/update/product` | Update product |
| GET | `/delete/product/{id}` | Delete product |
| GET | `/details/product/{id}` | Product details |

### 6.6 Purchase Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/all/purchase` | All purchases |
| GET | `/add/purchase` | Add purchase form |
| POST | `/store/purchase` | Store purchase |
| GET | `/edit/purchase/{id}` | Edit purchase |
| POST | `/update/purchase/{id}` | Update purchase |
| GET | `/details/purchase/{id}` | Purchase details |
| GET | `/invoice/purchase/{id}` | Purchase invoice PDF |
| GET | `/delete/purchase/{id}` | Delete purchase |

### 6.7 Requisition Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/my/requisition` | My requisitions |
| GET | `/all/requisition` | All requisitions |
| GET | `/add/requisition` | Add requisition |
| POST | `/store/requisition` | Store requisition |
| GET | `/edit/requisition/{id}` | Edit requisition |
| POST | `/update/requisition/{id}` | Update requisition |
| GET | `/details/requisition/{id}` | Requisition details |
| GET | `/invoice/requisition/{id}` | Requisition invoice |
| POST | `/issue/requisition/{id}` | Issue requisition |

### 6.8 Issue Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/my/issue` | My issues |
| GET | `/all/issue` | All issues |
| GET | `/add/issue` | Add issue |
| POST | `/store/issue` | Store issue |
| GET | `/edit/issue/{id}` | Edit issue |
| POST | `/update/issue/{id}` | Update issue |
| GET | `/details/issue/{id}` | Issue details |
| GET | `/invoice/issue/{id}` | Issue invoice |

### 6.9 Report Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/all/report` | All reports |
| GET | `/purchase/report` | Purchase report |
| GET | `/damage/product/report` | Damage report |
| GET | `/issue/report` | Issue report |
| GET | `/stock/report` | Stock report |
| GET | `/fixed/asset/report` | Fixed asset report |
| GET | `/product/trx/report` | Product TRX report |
| GET | `/product/lifetime/report` | Product lifetime report |

### 6.10 Role & Permission Routes

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/all/permission` | All permissions |
| GET | `/add/permission` | Add permission |
| POST | `/store/permission` | Store permission |
| GET | `/all/roles` | All roles |
| GET | `/add/roles` | Add role |
| POST | `/store/roles` | Store role |
| GET | `/add/roles/permission` | Add role permissions |
| POST | `/role/permission/store` | Store role permissions |
| GET | `/all/admin` | All admin users |
| GET | `/add/admin` | Add admin |
| POST | `/store/admin` | Store admin |

---

## 7. User Roles & Permissions

### 7.1 Roles

| Role | Description |
|------|-------------|
| Super Admin | Full system access |
| Admin | Administrative access |
| Department User | Limited access for requisitions |

### 7.2 Permission Groups

#### Brand Permissions
- `Brand::menu` - View brand menu
- `Brand::add` - Add brand
- `Brand::edit` - Edit brand
- `Brand::delete` - Delete brand

#### Supplier Permissions
- `Supplier::menu` - View supplier menu
- `Supplier::add` - Add supplier
- `Supplier::edit` - Edit supplier
- `Supplier::delete` - Delete supplier

#### Product Permissions
- `Product::menu` - View product menu
- `Product::add` - Add product
- `Product::edit` - Edit product
- `Product::delete` - Delete product
- `Product::Roles has permission` - Role permission
- `Product::In Stock` - Stock view

#### Category Permissions
- `Category::menu` - View category menu
- `Category::add` - Add category
- `Category::edit` - Edit category
- `Category::delete` - Delete category

#### SubCategory Permissions
- `SubCategory::menu` - View subcategory menu
- `SubCategory::add` - Add subcategory
- `SubCategory::edit` - Edit subcategory
- `SubCategory::delete` - Delete subcategory

#### Purchase Permissions
- `Purchase::menu` - View purchase menu
- `Purchase::add` - Add purchase
- `Purchase::edit` - Edit purchase
- `Purchase::delete` - Delete purchase

#### Purchase Return Permissions
- `Purchase Return::menu` - View return menu
- `Purchase Return::add` - Add return
- `Purchase Return::edit` - Edit return
- `Purchase Return::delete` - Delete return

#### Requisition Permissions
- `Requisition::menu` - View requisition menu
- `Requisition::add` - Add requisition
- `Requisition::edit` - Edit requisition
- `Requisition::delete` - Delete requisition
- `Requisition::my requisitions` - View own requisitions
- `Requisition::all requisitions` - View all requisitions

#### Issue Permissions
- `Issue::menu` - View issue menu
- `Issue::add` - Add issue
- `Issue::edit` - Edit issue
- `Issue::delete` - Delete issue
- `Issue::my issues` - View own issues
- `Issue::all issues` - View all issues

#### Issue Return Permissions
- `Issue Return::menu` - View return menu
- `Issue Return::add` - Add return
- `Issue Return::edit` - Edit return
- `Issue Return::delete` - Delete return

#### Damage Product Permissions
- `Damage Product::menu` - View damage menu
- `Damage Product::add` - Add damage
- `Damage Product::edit` - Edit damage
- `Damage Product::delete` - Delete damage

#### Quotation Permissions
- `Quotation::menu` - View quotation menu
- `Quotation::add` - Add quotation
- `Quotation::edit` - Edit quotation
- `Quotation::delete` - Delete quotation

#### Report Permissions
- `Report::menu` - View report menu
- `Report::purchase report` - Purchase report
- `Report::damage product report` - Damage report
- `Report::issue report` - Issue report
- `Report::issue return report` - Issue return report
- `Report::stock report` - Stock report
- `Report::fixed asset report` - Fixed asset report
- `Report::product trx report` - Product TRX report
- `Report::all reports` - All reports

#### Semester Permissions
- `Semester::menu` - View semester menu
- `Semester::add` - Add semester
- `Semester::edit` - Edit semester
- `Semester::delete` - Delete semester

#### Department Permissions
- `Department::menu` - View department menu
- `Department::add` - Add department
- `Department::edit` - Edit department
- `Department::delete` - Delete department

#### User Management Permissions
- `Manage User::menu` - View user menu
- `Manage User::add` - Add user
- `Manage User::edit` - Edit user
- `Manage User::delete` - Delete user

#### Role Permission
- `Role Permission::menu` - View role permission menu

#### Chat
- `Chat::menu` - View chat menu

#### Stock
- `Stock::quantity` - View stock quantity

---

## 8. Installation Guide

### 8.1 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ (for frontend assets)
- MySQL 8.x
- XAMPP/WAMP/Laragon (optional, for local development)

### 8.2 Installation Steps

#### Step 1: Clone Repository
```bash
git clone <repository-url>
cd "Store Management System of BUBT"
```

#### Step 2: Install PHP Dependencies
```bash
composer install
```

#### Step 3: Install Node Dependencies
```bash
npm install
```

#### Step 4: Environment Configuration
```bash
# Copy .env.example to .env
copy .env.example .env
```

#### Step 5: Generate Application Key
```bash
php artisan key:generate
```

#### Step 6: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=store_management_system_of_bubt
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### Step 7: Run Migrations
```bash
php artisan migrate
```

#### Step 8: (Optional) Seed Database
```bash
php artisan db:seed
```

#### Step 9: Create Storage Link
```bash
php artisan storage:link
```

---

## 9. Configuration

### 9.1 Application Configuration (.env)

```env
APP_NAME="Store Management System of BUBT"
APP_ENV=local
APP_KEY=your_generated_key
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=store_management_system_of_bubt
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### 9.2 Chatify Configuration

```env
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

MESSENGER_COLOR="#007bff"
```

### 9.3 Mail Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 10. Running the Application

### 10.1 Development Server

#### Using Artisan
```bash
php artisan serve
```

#### Using Laravel Sail
```bash
./vendor/bin/sail up
# or
docker-compose up -d
```

### 10.2 Frontend Development

```bash
npm run dev
```

### 10.3 Production Build

```bash
npm run build
```

### 10.4 Running Queue Workers

```bash
php artisan queue:work
```

### 10.5 Clearing Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 10.6 Accessing the Application

- **URL**: `http://localhost:8000`
- **Login**: Use credentials created during registration or from database seed

---

## Appendix A: Database SQL File

The project includes a SQL dump file: `store_management_system_of_bubt.sql` containing the full database schema and sample data.

---

## Appendix B: Key Controllers

| Controller | Location | Purpose |
|------------|----------|---------|
| BrandController | app/Http/Controllers/Backend/ | Brand CRUD |
| SupplierController | app/Http/Controllers/Backend/ | Supplier CRUD |
| ProductController | app/Http/Controllers/Backend/ | Product, Category, Subcategory CRUD |
| PurchaseController | app/Http/Controllers/Backend/ | Purchase CRUD |
| ReturnPurchaseController | app/Http/Controllers/Backend/ | Return purchase CRUD |
| RequisitionController | app/Http/Controllers/Backend/ | Requisition CRUD |
| IssueController | app/Http/Controllers/Backend/ | Issue CRUD |
| IssueReturnController | app/Http/Controllers/Backend/ | Issue return CRUD |
| DamageProductController | app/Http/Controllers/Backend/ | Damage product CRUD |
| QuotationController | app/Http/Controllers/Backend/ | Quotation CRUD |
| ReportController | app/Http/Controllers/Backend/ | Report generation |
| RoleController | app/Http/Controllers/Backend/ | Role & Permission management |
| ProductLifetimeReportController | app/Http/Controllers/Backend/ | Product lifetime reports |

---

## Appendix C: Key Services

| Service | Location | Purpose |
|---------|----------|---------|
| ProductLifetimeReportService | app/Services/Reports/ | Product lifetime report generation |

---

## Appendix D: Custom Middleware

| Middleware | Location | Purpose |
|------------|----------|---------|
| CheckPermissionOrRole | app/Http/Middleware/ | Permission and role checking |

---

## Appendix E: Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## Appendix F: License

This project is licensed under the MIT License.

---

*Document Version: 1.0*
*Last Updated: June 2026*
*Project: Store Management System of BUBT*
*Location: D:\Capstone Project\Store Management System of BUBT*
