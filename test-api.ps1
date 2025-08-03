# PowerShell script to test Laravel Sanctum API
$baseUrl = "http://127.0.0.1:8000/api"

Write-Host "=== Testing Laravel Sanctum Backend ===" -ForegroundColor Green
Write-Host "Base URL: $baseUrl" -ForegroundColor Yellow
Write-Host ""

# Test 1: Register a new user
Write-Host "1. Testing user registration..." -ForegroundColor Cyan
$registerData = @{
    name = "Test User"
    email = "test" + (Get-Random) + "@example.com"  # Random email to avoid conflicts
    password = "password123"
} | ConvertTo-Json

try {
    $registerResponse = Invoke-RestMethod -Uri "$baseUrl/register" -Method POST -Body $registerData -ContentType "application/json"
    Write-Host "✅ Registration successful!" -ForegroundColor Green
    Write-Host ($registerResponse | ConvertTo-Json -Depth 2) -ForegroundColor White
} catch {
    Write-Host "❌ Registration failed:" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
}

Write-Host "`n" + "="*50 + "`n"

# Test 2: Login
Write-Host "2. Testing login..." -ForegroundColor Cyan
$loginData = @{
    email = $registerData | ConvertFrom-Json | Select-Object -ExpandProperty email
    password = "password123"
} | ConvertTo-Json

try {
    $loginResponse = Invoke-RestMethod -Uri "$baseUrl/login" -Method POST -Body $loginData -ContentType "application/json"
    Write-Host "✅ Login successful!" -ForegroundColor Green
    Write-Host "Token: $($loginResponse.token)" -ForegroundColor White
    
    # Test 3: Get authenticated user
    Write-Host "`n3. Testing authenticated user endpoint..." -ForegroundColor Cyan
    $headers = @{
        "Authorization" = "Bearer $($loginResponse.token)"
        "Accept" = "application/json"
    }
    
    $userResponse = Invoke-RestMethod -Uri "$baseUrl/user" -Method GET -Headers $headers
    Write-Host "✅ Authenticated request successful!" -ForegroundColor Green
    Write-Host ($userResponse | ConvertTo-Json -Depth 2) -ForegroundColor White
    
} catch {
    Write-Host "❌ Login/Auth failed:" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
}

Write-Host "`n" + "="*50 + "`n"
Write-Host "🎉 Testing complete! Your Laravel Sanctum backend is working if you see green checkmarks above." -ForegroundColor Green
