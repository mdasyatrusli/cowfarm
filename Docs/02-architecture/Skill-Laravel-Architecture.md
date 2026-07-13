# LARAVEL ARCHITECTURE RULES — COWFARM SAAS

## Purpose
Mengatur bagaimana Laravel digunakan dalam project ini agar rapi, scalable, dan production-ready.

---

## Core Pattern
- MVC + Service Layer Pattern

---

## Folder Structure

### App Layer
- app/Models
- app/Http/Controllers
- app/Http/Requests
- app/Services
- app/Policies
- app/Enums

---

## Controller Rules
- Controller hanya menerima request
- Tidak boleh ada business logic
- Harus memanggil Service

---

## Service Layer Rules
- Semua logic bisnis ada di Service
- Reusable antar controller
- Tidak langsung akses Request

---

## Model Rules
- Hanya untuk:
  - Relasi
  - Query dasar
- Tidak boleh logic bisnis kompleks

---

## Request Validation Rules
- Gunakan FormRequest
- Semua input wajib divalidasi

---

## Routing Rules
- Web routes untuk Blade
- API routes untuk JSON
- Gunakan grouping berdasarkan module

---

## Best Practices
- Gunakan dependency injection
- Gunakan repository/service pattern jika kompleks
- Gunakan eager loading untuk relasi

---

## Anti Patterns
- Logic di controller ❌
- Query di view ❌
- Hardcoded data ❌

---

## Naming Convention
- Controller: CowController
- Service: CowService
- Request: StoreCowRequest
- Model: Cow

---

## Key Principle
> "Controller is only an entry point, not a brain"
