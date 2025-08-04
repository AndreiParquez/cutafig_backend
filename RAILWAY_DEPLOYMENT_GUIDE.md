# Railway Deployment Troubleshooting Guide

## Current Issue: Application failed to respond

### ✅ Steps to Fix:

1. **Set Environment Variables in Railway**
   - Go to Railway Dashboard → Your Project → Variables tab
   - Add these essential variables:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:r/myFm76ppSk0UHxxDgJs656625nJFm1n1NZJFvw8X0=
   LOG_LEVEL=error
   SESSION_DRIVER=file
   CORS_ALLOWED_ORIGINS=*
   ```

2. **Update APP_URL after deployment**
   - After your first successful deployment, get your Railway domain
   - Update APP_URL variable: `APP_URL=https://your-domain.railway.app`

3. **Test the deployment**
   - Visit: `https://your-domain.railway.app/health`
   - Should return: `{"status":"healthy","timestamp":"...","environment":"production"}`

### 🔍 Debugging Steps:

1. **Check Railway Logs**
   - Go to Railway Dashboard → Your Service → Logs
   - Look for error messages after the "Server running" message

2. **Test Different Endpoints**
   - Root: `https://your-domain.railway.app/`
   - Health: `https://your-domain.railway.app/health`
   - API Test: `https://your-domain.railway.app/api/test-db`

3. **Common Issues:**
   - Missing APP_KEY: Generate new with `php artisan key:generate --show`
   - Database issues: Check if MySQL service is connected
   - CORS issues: Verify CORS_ALLOWED_ORIGINS is set to "*" for testing

### 🚨 If still not working:

1. Try setting `APP_DEBUG=true` temporarily to see detailed errors
2. Check if the Railway service has proper port configuration
3. Verify the buildpack is correctly detecting your Laravel app
4. Make sure `composer.json` and `package.json` are in root directory

### 📝 Final Configuration:

After fixing, your Railway environment variables should include:
- APP_NAME, APP_ENV, APP_DEBUG, APP_KEY, APP_URL
- Database credentials (if using Railway MySQL)
- CORS configuration
- Session and logging settings
