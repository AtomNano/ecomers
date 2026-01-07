# Grosir Berkat Ibu - E-Commerce Platform

Sistem E-Commerce dengan fitur Google OAuth Login, Cloudflare Turnstile Captcha, dan sistem harga grosir bertingkat.

---

## 🚀 Quick Start (Development)

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite atau MySQL

### Installation

1. **Clone & Install Dependencies**
   ```bash
   git clone <repository-url>
   cd ecomers
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   # Jika pakai SQLite (default)
   touch database/database.sqlite
   
   # Atau edit .env untuk MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_DATABASE=your_database
   # DB_USERNAME=your_username
   # DB_PASSWORD=your_password
   
   php artisan migrate
   php artisan db:seed
   ```

4. **Run Development Server**
   ```bash
   composer run dev
   # atau
   php artisan serve
   npm run dev
   ```

5. **Access Application**
   - Frontend: http://localhost:8000
   - Login: http://localhost:8000/login

---

## 🔐 Google OAuth Setup

### 1. Get Google OAuth Credentials

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih existing project
3. Enable **Google+ API**
4. Buka **APIs & Services** → **OAuth consent screen**
   - User Type: **External**
   - App name: `Grosir Berkat Ibu`
   - User support email: your-email@gmail.com
5. Buka **Credentials** → **Create Credentials** → **OAuth client ID**
   - Application type: **Web application**
   - Authorized redirect URIs:
     - Development: `http://localhost:8000/auth/google/callback`
     - Production: `https://yourdomain.com/auth/google/callback`
6. Copy **Client ID** dan **Client Secret**

### 2. Configure Laravel

Edit `.env`:
```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

### 3. Test OAuth

1. Visit: http://localhost:8000/login
2. Click "Masuk dengan Google"
3. Login dengan Google account
4. Should redirect back with user logged in

**Troubleshooting:**
- Error `redirect_uri_mismatch`: Add exact redirect URI to Google Console
- Error `invalid_client`: Check Client ID & Secret in `.env`

📖 **Detail Guide:** Lihat `docs/GOOGLE_OAUTH_SETUP.md`

---

## 🛡️ Cloudflare Turnstile Captcha Setup

### 1. Get Turnstile Keys

1. Login ke [Cloudflare Dashboard](https://dash.cloudflare.com/)
2. Pilih **Turnstile** di sidebar
3. Click **Add Site**
   - Site name: `Grosir Berkat Ibu - Dev`
   - Domain: `localhost` (untuk development)
   - Widget mode: **Managed** (recommended)
4. Copy **Site Key** dan **Secret Key**

### 2. Configure Laravel

Edit `.env`:
```env
TURNSTILE_SITE_KEY=your_site_key_here
TURNSTILE_SECRET_KEY=your_secret_key_here
VITE_TURNSTILE_SITE_KEY="${TURNSTILE_SITE_KEY}"
```

### 3. Test Keys (Development)

Untuk testing tanpa real keys, gunakan test keys:
```env
TURNSTILE_SITE_KEY=1x00000000000000000000AA
TURNSTILE_SECRET_KEY=1x0000000000000000000000000000000AA
```

### 4. Clear Cache
```bash
php artisan config:clear
php artisan config:cache
```

📖 **Detail Guide:** Lihat `docs/CLOUDFLARE_TURNSTILE_SETUP.md`

---

## 🌐 Production Deployment

### Pre-Deployment Checklist

1. **Environment Configuration**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   # Use production Google OAuth credentials
   GOOGLE_CLIENT_ID=production_client_id
   GOOGLE_CLIENT_SECRET=production_client_secret
   GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
   
   # Use production Turnstile keys
   TURNSTILE_SITE_KEY=production_site_key
   TURNSTILE_SECRET_KEY=production_secret_key
   
   # Database (MySQL recommended for production)
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_DATABASE=production_db
   DB_USERNAME=production_user
   DB_PASSWORD=strong_password_here
   
   # Email
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.example.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email
   MAIL_PASSWORD=your_password
   ```

2. **Server Requirements**
   - PHP 8.2+
   - Composer
   - MySQL 8.0+ atau MariaDB 10.3+
   - Nginx atau Apache
   - SSL Certificate (Let's Encrypt)

### Deployment Steps

1. **Upload Code to Server**
   ```bash
   # Via Git
   git clone <repository-url> /var/www/grosir-berkat-ibu
   cd /var/www/grosir-berkat-ibu
   ```

2. **Install Dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install --production
   npm run build
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   # Edit .env dengan production settings
   nano .env
   
   php artisan key:generate --force
   ```

4. **Database Setup**
   ```bash
   # Create database
   mysql -u root -p
   > CREATE DATABASE production_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   > CREATE USER 'production_user'@'localhost' IDENTIFIED BY 'strong_password';
   > GRANT ALL PRIVILEGES ON production_db.* TO 'production_user'@'localhost';
   > FLUSH PRIVILEGES;
   > exit;
   
   # Run migrations
   php artisan migrate --force
   php artisan db:seed --class=AdminSeeder --force
   php artisan db:seed --class=SettingSeeder --force
   ```

5. **File Permissions**
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   chmod 600 .env
   ```

6. **Optimize**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. **Setup Web Server (Nginx)**
   
   Create `/etc/nginx/sites-available/grosir-berkat-ibu`:
   ```nginx
   # HTTP → HTTPS Redirect
   server {
       listen 80;
       server_name yourdomain.com www.yourdomain.com;
       return 301 https://$server_name$request_uri;
   }
   
   # HTTPS Server
   server {
       listen 443 ssl http2;
       server_name yourdomain.com www.yourdomain.com;
       root /var/www/grosir-berkat-ibu/public;
       index index.php;
       
       # SSL Configuration
       ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
       ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
       ssl_protocols TLSv1.2 TLSv1.3;
       
       # Security Headers
       add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
       add_header X-Frame-Options "DENY" always;
       add_header X-Content-Type-Options "nosniff" always;
       
       # Laravel Routes
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       # Deny access to hidden files
       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```
   
   Enable site:
   ```bash
   ln -s /etc/nginx/sites-available/grosir-berkat-ibu /etc/nginx/sites-enabled/
   nginx -t
   systemctl reload nginx
   ```

8. **SSL Certificate (Let's Encrypt)**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
   ```

9. **Setup Queue Worker**
   
   Create `/etc/systemd/system/laravel-worker.service`:
   ```ini
   [Unit]
   Description=Laravel Queue Worker
   After=network.target
   
   [Service]
   User=www-data
   Group=www-data
   Restart=always
   ExecStart=/usr/bin/php /var/www/grosir-berkat-ibu/artisan queue:work --sleep=3 --tries=3
   
   [Install]
   WantedBy=multi-user.target
   ```
   
   Enable worker:
   ```bash
   sudo systemctl enable laravel-worker
   sudo systemctl start laravel-worker
   ```

10. **Setup Scheduler**
    ```bash
    crontab -e
    # Add:
    * * * * * cd /var/www/grosir-berkat-ibu && php artisan schedule:run >> /dev/null 2>&1
    ```

### Post-Deployment Verification

1. **Test Application**
   - [ ] Visit https://yourdomain.com
   - [ ] Test user registration
   - [ ] Test Google OAuth login
   - [ ] Test captcha on login
   - [ ] Test product browsing
   - [ ] Test cart and checkout

2. **Security Check**
   - [ ] SSL certificate valid (green padlock)
   - [ ] Security headers present
   - [ ] Rate limiting works
   - [ ] File upload validation works

3. **Monitoring**
   - [ ] Check error logs: `tail -f storage/logs/laravel.log`
   - [ ] Check web server logs: `tail -f /var/log/nginx/error.log`
   - [ ] Setup uptime monitoring (UptimeRobot, Pingdom)

📖 **Detail Guide:** Lihat `docs/DEPLOYMENT_CHECKLIST.md`

---

## 📁 Project Structure

```
ecomers/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── AuthController.php (Google OAuth + Turnstile)
│   │   │   │   └── RegisterController.php
│   │   │   ├── Admin/
│   │   │   ├── Owner/
│   │   │   └── Customer/
│   │   └── Middleware/
│   └── Models/
│       └── User.php (OAuth fields: google_id, avatar)
├── config/
│   ├── services.php (Google OAuth config)
│   └── turnstile.php (Turnstile config)
├── database/
│   └── migrations/
│       └── 2026_01_06_080000_add_oauth_to_users_table.php
├── resources/
│   └── views/
│       └── auth/
│           └── login.blade.php (OAuth button + Turnstile widget)
├── routes/
│   └── web.php (OAuth routes)
├── docs/
│   ├── GOOGLE_OAUTH_SETUP.md
│   ├── CLOUDFLARE_TURNSTILE_SETUP.md
│   ├── SECURITY_RECOMMENDATIONS.md
│   └── DEPLOYMENT_CHECKLIST.md
└── .env.example
```

---

## 🔑 Default Credentials (Development)

**Admin:**
- Email: admin@grosir.com
- Password: password123

**Owner:**
- Email: owner@grosir.com
- Password: password123

**Customer:**
- Email: budi@example.com / siti@example.com
- Password: password123

⚠️ **PENTING:** Ganti semua password default di production!

---

## 🛠️ Common Tasks

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Run Migrations
```bash
php artisan migrate
# atau rollback
php artisan migrate:rollback
```

### Seed Database
```bash
php artisan db:seed
# atau specific seeder
php artisan db:seed --class=ProductSeeder
```

### Check Queue Jobs
```bash
php artisan queue:work
# atau check failed jobs
php artisan queue:failed
```

### Generate Storage Link
```bash
php artisan storage:link
```

---

## 🐛 Troubleshooting

### "Class Socialite not found"
```bash
composer install
php artisan config:clear
```

### "Column google_id doesn't exist"
```bash
php artisan migrate
```

### "500 Internal Server Error"
1. Check logs: `storage/logs/laravel.log`
2. Enable debug (development only):
   ```env
   APP_DEBUG=true
   ```
3. Check file permissions:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

### "OAuth redirect_uri_mismatch"
- Pastikan redirect URI di Google Console exact match dengan `GOOGLE_REDIRECT_URI` di `.env`
- Include protocol (http/https) dan port jika ada

### "Turnstile widget not showing"
1. Check browser console for errors
2. Verify site key: `php artisan config:cache`
3. Check Turnstile script loaded: View page source → Search "cloudflare.com/turnstile"

### "Login page not responsive on mobile"
- Clear browser cache (Ctrl+Shift+R)
- Check login.blade.php updated with responsive fixes
- Test on actual device, not just browser resize

---

## 📚 Documentation

- **Google OAuth Setup:** `docs/GOOGLE_OAUTH_SETUP.md`
- **Turnstile Captcha Setup:** `docs/CLOUDFLARE_TURNSTILE_SETUP.md`
- **Security Recommendations:** `docs/SECURITY_RECOMMENDATIONS.md`
- **Deployment Checklist:** `docs/DEPLOYMENT_CHECKLIST.md`
- **Walkthrough:** `docs/walkthrough.md`

---

## 🔒 Security

### Best Practices
- ✅ HTTPS/SSL required for production
- ✅ Strong passwords (min 8 chars, mixed case, numbers)
- ✅ Rate limiting on login (6 attempts per minute)
- ✅ CSRF protection enabled
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ File upload validation
- ✅ Server-side captcha validation

### Security Headers
Implement in production (see `docs/SECURITY_RECOMMENDATIONS.md`):
- `Strict-Transport-Security`
- `X-Frame-Options`
- `X-Content-Type-Options`
- `X-XSS-Protection`
- `Content-Security-Policy`

---

## 🤝 Support

**Email:** support@grosirberakatibu.com  
**Security Issues:** security@grosirberakatibu.com

---

## 📄 License

MIT License - See LICENSE file for details

---

## 🎯 Features

### Authentication
- ✅ Email/Password login
- ✅ Google OAuth login
- ✅ Cloudflare Turnstile captcha
- ✅ Password reset
- ✅ Role-based access (Admin, Owner, Customer)

### E-Commerce
- ✅ Product management (CRUD)
- ✅ Tiered pricing (grosir system)
- ✅ Shopping cart
- ✅ Checkout & payment
- ✅ Order management
- ✅ Payment proof upload & verification

### Admin Panel
- ✅ Dashboard with statistics
- ✅ Product management
- ✅ Order verification
- ✅ Financial reports

### Owner Panel
- ✅ Customer management
- ✅ Sales reports
- ✅ Store settings

### UI/UX
- ✅ Responsive design (mobile-friendly)
- ✅ Modern TailwindCSS styling
- ✅ Alpine.js for interactivity
- ✅ Smooth animations

---

**Version:** 1.1  
**Last Updated:** 2026-01-06  
**Status:** Production Ready ✅
