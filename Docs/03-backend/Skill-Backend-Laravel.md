# BACKEND LARAVEL — COWFARM SAAS

## Purpose
Mengatur semua logika backend Laravel agar rapi, scalable, dan sesuai arsitektur SaaS.

---

## Core Principle
Backend harus:
- Bersih
- Terstruktur
- Tidak bercampur logic UI

---

## Architecture Flow
Request → Route → Controller → Service → Model → Database → Response

---

## Controller Rules
- Hanya sebagai entry point
- Tidak boleh ada business logic
- Harus memanggil Service

---

## Service Layer Rules
- Tempat semua business logic
- Bisa dipakai ulang
- Tidak bergantung pada HTTP

---

## Model Rules
- Hanya untuk:
  - Relasi
  - Query dasar
- Tidak boleh logic kompleks

---

## Folder Structure
- Controllers/
- Services/
- Models/
- Requests/

---

## Best Practices
- Gunakan dependency injection
- Gunakan eager loading
- Gunakan pagination

---

## Anti Patterns
- Logic di controller ❌
- Query di view ❌
- Hardcode data ❌
