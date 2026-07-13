# DATABASE DESIGN — COWFARM SAAS

## Purpose
Mengatur desain database agar scalable, konsisten, dan sesuai multi-tenant SaaS.

---

## Core Principle
Database harus:
- Terstruktur
- Ter-normalisasi
- Multi-tenant ready
- Tidak duplikasi data

---

## Design Rules
- Semua tabel wajib punya `farm_id`
- Gunakan foreign key
- Gunakan timestamp
- Gunakan indexing untuk query penting

---

## Naming Convention

### Table
- plural snake_case
  - cows
  - milk_records
  - health_records

### Column
- snake_case
  - farm_id
  - cow_id
  - created_at

---

## Relationship Rules
- One Farm → Many Cows
- One Cow → Many Records
- One Farm → Many Users

---

## Indexing Rules
Wajib index:
- farm_id
- cow_id
- created_at

---

## Migration Rules
- Semua perubahan via migration
- Tidak boleh edit database manual
- Harus reversible (rollback)

---

## Anti Patterns
- Duplicate data ❌
- No foreign key ❌
- No farm_id ❌
- Manual DB edit ❌
