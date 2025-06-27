# SiemensX API Integration Guide

This document explains how frontend developers can interact with the SiemensX backend.
All endpoints return JSON and expect the `Content-Type: application/json` header when
sending a body.

The API root is the directory where the PHP project is hosted. If running locally
with `php -S localhost:8000` then the base URL is `http://localhost:8000`.

Most endpoints require authentication via a bearer token obtained during login or
registration. Include the header:

```
Authorization: Bearer <token>
```

## Authentication

### `POST /api/auth/register.php`
Create a new user.

**Request JSON**
```json
{
  "full_name": "John Smith",
  "username": "jsmith",
  "email": "jsmith@example.com",
  "password": "secret",
  "referred_by": 1      // optional user id
}
```

**Response**
```json
{
  "token": "<api_token>",
  "user_id": 12
}
```

### `POST /api/auth/login.php`
Log in with username or email and password.

**Request JSON**
```json
{
  "username": "jsmith",
  "password": "secret"
}
```

**Response**
```json
{
  "token": "<api_token>"
}
```

## User

### `GET /api/user/get_profile.php`
Return the authenticated user's profile.

### `POST /api/user/update.php`
Update `full_name` or `email`.

**Request JSON**
```json
{
  "full_name": "New Name",
  "email": "new@example.com"
}
```

### `GET /api/user/earnings.php`
Return total referral earnings for the logged in user.

## Deposits

### `POST /api/deposits/request.php`
Request a new deposit.

**Request JSON**
```json
{
  "amount": 100,
  "method": "bank"
}
```

### `GET /api/deposits/history.php`
List the user's past deposit requests.

## Withdrawals

### `POST /api/withdrawals/request.php`
Request a withdrawal.

**Request JSON**
```json
{
  "amount": 50,
  "wallet_address": "0x123...",
  "method": "crypto"
}
```

### `GET /api/withdrawals/history.php`
List withdrawal requests made by the user.

## Transactions

### `GET /api/transactions/history.php`
Return the account's transaction log.

## Referrals

### `GET /api/referrals/earnings.php`
List individual referral earnings entries.

## Admin Endpoints
(Admin token required)

### `GET /api/admin/dashboard_stats.php`
Return counts of users and pending requests.

### `POST /api/admin/approve_deposit.php`
Approve or reject a deposit request.

**Request JSON**
```json
{
  "id": 5,
  "status": "approved"   // or "rejected"
}
```

### `POST /api/admin/approve_withdrawal.php`
Approve or reject a withdrawal request.

**Request JSON**
```json
{
  "id": 2,
  "status": "approved"
}
```

### `POST /api/admin/broadcast_email.php`
Send a message to all users.

**Request JSON**
```json
{
  "subject": "News",
  "message": "Hello everyone"
}
```

---

For additional details on environment setup or deployment see `README.md`.
