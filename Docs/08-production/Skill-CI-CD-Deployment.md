# CI/CD & DEPLOYMENT — COWFARM SAAS

## Purpose
Mengatur proses deployment aplikasi dari development ke production secara otomatis, aman, dan terstruktur.

---

## CORE PRINCIPLE
- Tidak ada deploy manual sembarangan
- Semua perubahan harus bisa dilacak
- Production harus stabil dan reproducible

---

## ENVIRONMENT STRUCTURE

### Development
- Local machine
- Debug aktif

### Staging
- Testing server
- Mirror production

### Production
- Live system
- Debug OFF

---

## CI/CD FLOW (GITHUB ACTIONS)

1. Push ke GitHub
2. Trigger pipeline
3. Run test
4. Install dependencies
5. Build assets
6. Deploy ke VPS
7. Run migration
8. Restart queue

---

## SERVER STACK (VPS)

- Ubuntu Server
- Nginx
- PHP-FPM
- MySQL / PostgreSQL
- Redis (optional)
- Supervisor (queue worker)

---

## DEPLOYMENT STEPS

### 1. Pull Code
```bash id="deploy-001"
git pull origin main

### 2. Install Dependencies
```composer install
npm install && npm run build

### 3. Migration
``` php artisan migrate --force

### 4. Cache Optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

QUEUE MANAGEMENT
1. Gunakan Supervisor
2. Auto restart worker jika crash

RULES
1. Tidak boleh deploy tanpa testing
2. Tidak boleh edit production langsung
3. Harus rollback plan

ROLLBACK STRATEGY
1. Gunakan git revert
2. Backup database sebelum migration
3. Versioned deployment

ANTI PATTERNS
1. Upload manual file ke server ❌
2. Migration tanpa backup ❌
3. Skip CI/CD ❌

KEY PRINCIPLE

"If it’s not automated, it’s not safe"
