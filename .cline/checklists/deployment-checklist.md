# Deployment Checklist

## Purpose

Memastikan aplikasi siap dipindahkan ke staging atau production.

---

## When to Use

Sebelum deployment.

---

# SOURCE CODE

☐ Branch benar

☐ Pull Request selesai

☐ Merge selesai

---

# TEST

☐ Semua test lulus

☐ Tidak ada error

---

# DATABASE

☐ Backup database

☐ Migration sudah diuji

☐ Rollback tersedia

---

# ENVIRONMENT

☐ .env production benar

☐ APP_DEBUG=false

☐ APP_ENV=production

---

# OPTIMIZATION

☐ Config Cache

☐ Route Cache

☐ View Cache

☐ Build Frontend

---

# QUEUE

☐ Queue Worker aktif

☐ Scheduler aktif

---

# SECURITY

☐ HTTPS aktif

☐ Secret aman

☐ Permission folder benar

---

# MONITORING

☐ Log dipantau

☐ Server sehat

☐ Queue berjalan

---

# POST DEPLOYMENT

☐ Login berhasil

☐ Dashboard berjalan

☐ CRUD berjalan

☐ Tidak ada error

---

## PASS CRITERIA

Deployment dinyatakan berhasil jika seluruh checklist selesai dan aplikasi dapat digunakan tanpa error kritis.
