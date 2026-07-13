# LARAVEL EXECUTION ENGINE

## Purpose
Mengatur cara AI mengeksekusi fitur Laravel dari awal sampai selesai.

---

## EXECUTION FLOW

1. Understand feature
2. Design database (if needed)
3. Create migration
4. Create model
5. Create controller
6. Create service
7. Create routes
8. Create UI/API

---

## RULES

- Tidak boleh lompat step
- Database selalu dibuat dulu jika ada data
- Controller harus clean
- Logic pindah ke service

---

## STRUCTURE RULE

- MVC + Service Layer wajib
- Tidak boleh campur logic

---

## ANTI PATTERN
- Langsung coding tanpa design ❌
- Skip migration ❌
- Logic di controller ❌

---

## PRINCIPLE
> "Follow the Laravel flow, not shortcuts"
