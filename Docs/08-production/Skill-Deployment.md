
---

# 📁 `Skill-Deployment.md`

```md id="deploy-001"
# DEPLOYMENT STRATEGY — COWFARM SAAS

## Purpose
Menjelaskan cara aplikasi berjalan di production environment.

---

## DEPLOYMENT TYPES

### 1. Manual VPS Deploy
- SSH ke server
- Pull repo
- Install dependencies

### 2. Docker Deploy (advanced)
- Containerized system
- Isolated environment

### 3. CI/CD Deploy (recommended)
- Automated deployment via GitHub Actions

---

## SERVER REQUIREMENTS

- Nginx
- PHP 8.2+
- Composer
- Node.js
- MySQL/PostgreSQL

---

## FILE STRUCTURE ON SERVER

/var/www/cowfarm/
├── app
├── bootstrap
├── storage
├── vendor
└── public

---

## SECURITY RULES

- .env tidak boleh public
- Storage harus protected
- HTTPS wajib

---

## PERFORMANCE SETUP

- Enable OPcache
- Enable caching
- Use queue worker

---

## MONITORING

- Log error Laravel
- Server monitoring tools
- Queue monitoring

---

## ANTI PATTERNS
- Upload manual ❌
- No SSL ❌
- No backup ❌

---

## KEY PRINCIPLE
> "Production is not a testing ground"
