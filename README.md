# SiemensX PHP Backend

This project provides a simple RESTful backend for the **SiemensX** platform built with pure PHP and MySQL. It exposes JSON endpoints for user management, deposits, withdrawals, referrals and admin features.

## Requirements
- PHP 8.x or later
- MySQL

## Setup
1. Create a MySQL database called `siemensx` (or any name you prefer) and import `db.sql` located in the repository root.
2. Edit `config/db.php` and update `$DB_HOST`, `$DB_USER`, `$DB_PASS`, and `$DB_NAME` with your database settings.
3. Ensure the `uploads/` directories are writable by the web server so uploaded receipt and profile images can be stored.
4. (Optional) Create an admin user directly in the database table `admins` so you can access admin endpoints.

## Running Locally
Launch PHP's built-in server from the project root:
```bash
php -S localhost:8000
```
The API will be accessible at `http://localhost:8000`.

## Deployment Notes
To deploy in production you can use Apache or Nginx with PHP-FPM:
1. Copy the project files to your server.
2. Point your web server's document root to the repository directory.
3. Configure a virtual host so all requests under `/api/` are served by PHP. A basic Apache config might look like:
```apache
<VirtualHost *:80>
    DocumentRoot /var/www/siemensx
    <Directory /var/www/siemensx>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
4. Restart your web server and verify the API endpoints respond.

Make sure to keep `uploads/` protected by the provided `.htaccess` files to prevent executing uploaded content.

## Folder Structure
```
/api
  /auth          Authentication endpoints
  /admin         Admin-only endpoints
  /deposits      Deposit requests and history
  /withdrawals   Withdrawal requests and history
  /referrals     Referral earnings
  /transactions  Transaction history
  /user          Profile actions
/config          Database and CORS config
/helpers        Utility helpers
/middleware     Authentication middleware
/uploads/       Uploaded files (protected by .htaccess)
```

## Example Endpoints
- `POST /api/auth/register.php`
- `POST /api/auth/login.php`
- `GET  /api/user/get_profile.php` (requires Authorization header)
- `POST /api/deposits/request.php`
- `GET  /api/admin/dashboard_stats.php` (admin token required)

All responses are JSON. For protected routes include `Authorization: Bearer <token>`.
