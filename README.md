# Northstar POS Complete Point-of-Sale System

Northstar POS is a CodeIgniter 4 application for the IT0049 Midterm Project. It combines product, customer, and staff management with authentication, safe image uploads, stock-aware sales recording, and sales history.

## Demo staff login

- Username: `admin.marc`
- Password: `Northstar123!`

All sample staff accounts use the same demonstration password. The database stores only password hashes created by PHP's `password_hash()` function.

## Required features

- Product CRUD with price, stock quantity, optional uploaded image, and a prepared 640 x 480 display copy
- Customer CRUD with validated name, email, and phone fields
- Staff CRUD with unique usernames, hashed passwords, optional avatar upload, and a prepared 160 x 160 display copy
- Session login and logout with an authentication filter on every management route
- Record Sale form with an optional customer
- Atomic stock reduction and sale insertion
- Clear rejection when the requested quantity exceeds available stock
- Sales History with product, customer, staff member, quantity, total price, and date

## Routes

Public routes:

- `/` - project landing page
- `/about` - architecture and workflow overview
- `/login` - staff login
- `/logout` - logout POST action

Authenticated routes:

- `/products`, `/products/new`, `/products/{id}/edit`
- `/customers`, `/customers/new`, `/customers/{id}/edit`
- `/users`, `/users/new`, `/users/{id}/edit`
- `/sales/new` - record a sale
- `/sales` - sales history

Create, update, and delete actions use POST routes. Legacy automatic routing is disabled.

## Requirements

- PHP 8.2 or newer with MySQLi and GD enabled
- Composer 2
- MySQL 5.7 or newer, or MariaDB 10.4 or newer

## Local setup using the SQL export

1. Clone the repository and open the project folder.
2. Run `composer install`.
3. Create a MySQL database named `midterm_pos`.
4. Import `database/midterm_pos.sql`.
5. Copy `.env.example` to `.env` and update the database connection.
6. Run `php spark serve`.
7. Open `http://localhost:8080` and sign in with the demo account.

## Migration and seeder setup

For a new empty database, configure `.env`, then run:

```bash
php spark migrate
php spark db:seed MidtermSeeder
```

## Sales workflow

`app/Controllers/Sales.php` validates the selected product, optional customer, and quantity. It then starts a database transaction, performs a conditional stock reduction only when enough units remain, records the sale total from the stored product price, and commits both changes together. If stock is insufficient, the transaction is rolled back and the user receives a clear message.

## Image safety

Product images and staff avatars are optional. CodeIgniter validation restricts them to actual JPG, PNG, or WebP images up to 2 MB. `app/Libraries/DisplayImage.php` creates display-ready copies inside `public/uploads`.

## Database files

- `database/midterm_pos.sql` - portable schema and sample data
- `app/Database/Migrations/2026-10-09-000001_CreateMidtermPosTables.php` - complete schema migration
- `app/Database/Seeds/MidtermSeeder.php` - products, customers, staff, and sample sales

## Tests

Run:

```bash
composer test
```

The checks cover routing, protected access, schema relationships, CRUD components, image validation, password hashing, stock protection, and sales-history joins.

## Student

- Marco Arsenio B. De Leon
- Section TC33
- Professor: Mr. Von Erick Magbitang
