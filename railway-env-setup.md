# Railway Environment Variables Setup

## Required Environment Variables for Railway

Set these in your Railway project dashboard under Variables:

### Essential Variables:
```
APP_NAME=Cutafig Backend
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:r/myFm76ppSk0UHxxDgJs656625nJFm1n1NZJFvw8X0=
LOG_LEVEL=error
SESSION_DRIVER=file
```

### Important: Update APP_URL
After your first deployment, update this with your actual Railway domain:
```
APP_URL=https://your-actual-railway-domain.railway.app
```

### Database Variables (if using Railway MySQL):
```
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

### CORS Configuration:
```
CORS_ALLOWED_ORIGINS=*
```

## Steps to Fix:
1. Go to your Railway project dashboard
2. Click on your service
3. Go to Variables tab
4. Add all the variables above
5. Redeploy your application
