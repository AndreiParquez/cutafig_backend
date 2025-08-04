# Railway Environment Variables Setup

## Required Environment Variables for Railway

Copy and paste these environment variables in your Railway project dashboard:

### Application Configuration
```
APP_NAME=Cutafig Backend
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-domain.railway.app
APP_KEY=base64:r/myFm76ppSk0UHxxDgJs656625nJFm1n1NZJFvw8X0=
```

### Database Configuration
```
DB_CONNECTION=mysql
```

**Note**: Railway will automatically inject these MySQL variables when you add a MySQL service:
- `MYSQLHOST`
- `MYSQLPORT` 
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`

Then set these to reference the auto-injected variables:
```
DB_HOST=$MYSQLHOST
DB_PORT=$MYSQLPORT
DB_DATABASE=$MYSQLDATABASE
DB_USERNAME=$MYSQLUSER
DB_PASSWORD=$MYSQLPASSWORD
```

### Session and Cache Configuration
```
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### Logging Configuration
```
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

### CORS Configuration (Testing - Allow All Origins)
```
CORS_ALLOWED_ORIGINS=*
```

## Common Issues and Solutions

### 502 Error - Port Issue ⚠️ **CRITICAL**
- **Problem**: Server runs on port 8080 instead of Railway's $PORT
- **Symptoms**: Logs show "Server running on [http://0.0.0.0:8080]"
- **Solution**: 
  - Ensure your start command uses `--port=$PORT` (not `--port=${PORT}`)
  - Railway should automatically provide the PORT environment variable
  - Check Railway logs for "PORT is: XXXX" to verify the variable is set
  - If PORT is not set, Railway service configuration may be incorrect

### Database Connection Issues
- Make sure MySQL service is added to your Railway project
- Verify that database environment variables are properly set
- Check that DB_CONNECTION=mysql

### Environment File Issues
- Do not commit .env files with production secrets
- Use Railway's environment variables tab instead
- Railway automatically loads environment variables you set in the dashboard

## Deployment Steps

1. Push your code to GitHub
2. Connect your Railway project to the GitHub repository
3. Add a MySQL service to your Railway project
4. Set the environment variables listed above in Railway's dashboard
5. Deploy!

## Testing Endpoints

After deployment, test these endpoints:
- `https://your-domain.railway.app/` - Basic API info
- `https://your-domain.railway.app/health` - Health check
- `https://your-domain.railway.app/api/health` - API health check
- `https://your-domain.railway.app/api/test-db` - Database connection test
