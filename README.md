# SiemensX PHP Backend

This project provides a simple RESTful backend for the **SiemensX** platform built with pure PHP and MySQL. It exposes JSON endpoints for user management, deposits, withdrawals, referrals and basic admin functions.

## Requirements
- PHP 8.x
- MySQL

## Setup
1. Create a database named `siemensx` and import `db.sql`.
2. Update the database credentials in `config/db.php` if needed.
3. Start the PHP server from the repository root:
   ```bash
   php -S localhost:8000
   ```
   The API will be available at `http://localhost:8000`.

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
- `GET  /api/user/get_profile.php` (Authorization header required)
- `POST /api/deposits/request.php`
- `GET  /api/admin/dashboard_stats.php` (admin token required)

All responses are JSON. Include `Authorization: Bearer <token>` for protected routes.
