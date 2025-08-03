#!/bin/bash
# Laravel Sanctum API Test Commands

BASE_URL="http://127.0.0.1:8000"

echo "=== Testing Laravel Sanctum Backend ==="
echo "Base URL: $BASE_URL"
echo ""

echo "1. Testing user registration..."
curl -X POST $BASE_URL/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123"
  }'

echo ""
echo ""

echo "2. Testing login..."
LOGIN_RESPONSE=$(curl -s -X POST $BASE_URL/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }')

echo $LOGIN_RESPONSE

# Extract token (you'll need to manually copy the token for the next command)
echo ""
echo "3. Copy the token from above and use it in the next command:"
echo ""
echo "curl -X GET $BASE_URL/user \\"
echo "  -H \"Authorization: Bearer YOUR_TOKEN_HERE\" \\"
echo "  -H \"Accept: application/json\""
