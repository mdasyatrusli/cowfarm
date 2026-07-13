# SECURITY — COWFARM SAAS

## Purpose
Melindungi sistem dari akses tidak sah, data leak, dan serangan umum.

---

## CORE PRINCIPLE
- Semua input tidak dipercaya
- Semua akses harus divalidasi
- Semua data harus dilindungi

---

## AUTH SECURITY
- Password harus hash
- Session harus aman
- Login rate limit

---

## AUTHORIZATION
- Gunakan role middleware
- Gunakan policy
- Tidak boleh bypass akses

---

## INPUT VALIDATION
- Semua request wajib validasi
- Gunakan FormRequest
- Sanitize input

---

## DATABASE SECURITY
- Gunakan prepared statements (Eloquent safe)
- Jangan expose sensitive data

---

## API SECURITY
- Gunakan token auth
- Gunakan middleware auth
- Rate limiting

---

## MULTI-TENANT SECURITY
- Wajib filter farm_id
- Tidak boleh cross tenant data
- Gunakan global scope

---

## ANTI PATTERNS
- Password plain text ❌
- Query tanpa filter ❌
- Bypass middleware ❌

---

## KEY PRINCIPLE
> "If it's not secure, it's broken"
