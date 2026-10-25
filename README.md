# Indonesian News Portal

A PHP and MySQL web application for publishing and reading Indonesian news. The project includes a public-facing news website and an administration area for managing content.

## Features

- Browse news and open individual article details.
- Organize articles by category.
- Submit reader comments and manage comments through the administration area.
- Manage news articles and categories from the admin pages.
- Store news, categories, comments, and comment replies in a MySQL database.

## Tech Stack

- **Backend:** PHP
- **Database:** MySQL / MariaDB with MySQLi
- **Frontend:** HTML, CSS, JavaScript, Bootstrap 5, responsive editorial styling
- **Local development:** XAMPP or another PHP and MySQL environment

## Project Structure

| Path | Purpose |
| --- | --- |
| `index.php` | Public homepage |
| `berita.php` | News listing page |
| `detail_berita.php` | News detail page |
| `admin/` | Administration pages for news, categories, and comments |
| `controllers/` | Database connection and request-processing scripts |
| `database/beritaindonesia.sql` | SQL dump used to create and populate the database |
| `css/`, `js/` | Stylesheets and JavaScript |
| `assets/`, `images/` | Images and other static assets |
| `user/` | User-related pages and resources |

## Run Locally

### Requirements

- PHP with the MySQLi extension
- MySQL or MariaDB
- Apache or another PHP-capable web server

### Setup

1. Clone or download this repository into your web server's document root (for XAMPP, this is commonly `htdocs`).
2. Start Apache and MySQL from your local development environment.
3. Open phpMyAdmin and create a database named `beritaindonesia`.
4. Import `database/beritaindonesia.sql` into that database.
5. Check `controllers/connect.php` and update the database host, username, password, and database name to match your local setup.
6. Open the project in your browser, for example: `http://localhost/Web-Berita/`.
7. To open the admin sign-in page, visit `http://localhost/Web-Berita/admin/login.php`.

> The connection file is configured for local development. Do not commit real production credentials to source control.

## Akun Demo Lokal

Database contoh menyediakan akun khusus untuk pengujian lokal:

- **Username:** `demo_admin`
- **Password:** `DemoOnly-Change-2026!`

Akun ini hanya untuk latihan pada komputer lokal. Ganti password dan periksa semua konfigurasi sebelum aplikasi dipasang pada server publik.

## Database

The SQL dump includes the tables and sample records needed to explore the project locally. The database includes news, categories, comments, and comment replies.

## Project Status

This is a portfolio and learning project. The public article and comment flows use parameterized queries and output escaping; admin login uses POST, prepared statements, and hashed-password verification with a one-time compatibility upgrade for legacy local passwords. Before any production use, review all admin CRUD endpoints, authorization, CSRF protection, file uploads, and deployment configuration.
