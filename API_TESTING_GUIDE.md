# Laravel Sanctum Backend API Testing Guide

Your Laravel server is running on: http://127.0.0.1:8000

## Available Endpoints:

### 1. Register a new user
**POST** `http://127.0.0.1:8000/register`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123"
}
```

**Expected Response:**
```json
{
    "id": 1,
    "name": "Test User",
    "email": "test@example.com",
    "email_verified_at": null,
    "created_at": "2025-08-03T...",
    "updated_at": "2025-08-03T..."
}
```

### 2. Login
**POST** `http://127.0.0.1:8000/login`

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body (JSON):**
```json
{
    "email": "test@example.com",
    "password": "password123"
}
```

**Expected Response:**
```json
{
    "token": "1|abc123def456..."
}
```

### 3. Get authenticated user (requires token)
**GET** `http://127.0.0.1:8000/user`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN_HERE
Accept: application/json
```

**Expected Response:**
```json
{
    "id": 1,
    "name": "Test User",
    "email": "test@example.com",
    "email_verified_at": null,
    "created_at": "2025-08-03T...",
    "updated_at": "2025-08-03T..."
}
```

## Testing Methods:

1. **Using Postman:** Import these requests into Postman
2. **Using curl commands:** See curl examples below
3. **Using VS Code REST Client extension:** See .http file examples below
4. **Using your frontend application:** React Native, React, Vue, etc.

## CORS Testing:
Your backend is configured to accept requests from:
- http://localhost:3000 (React/Next.js)
- http://localhost:8081 (React Native/Expo)
- exp://* (Expo development)
