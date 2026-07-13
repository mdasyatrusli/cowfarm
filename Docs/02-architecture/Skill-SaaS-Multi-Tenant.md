# SAAS MULTI-TENANT ARCHITECTURE — COWFARM

## Purpose
Mengatur isolasi data antar peternakan (farm) dalam sistem SaaS.

---

## Multi-Tenant Strategy
Digunakan model:

> Shared Database + Tenant ID (farm_id)

---

## Core Concept
Setiap data harus memiliki:
- farm_id sebagai isolasi utama

---

## Data Isolation Rule
- Tidak boleh ada data lintas farm
- Semua query wajib filter farm_id

---

## Example Structure

### users
- id
- farm_id
- name
- role

### cows
- id
- farm_id
- name
- birth_date

### milk_records
- id
- farm_id
- cow_id
- quantity

---

## Middleware Tenant
- Inject farm context saat login
- Auto filter query berdasarkan farm_id

---

## Security Rules
- User hanya bisa akses farm sendiri
- Admin tidak bisa lihat farm lain
- Query wajib scoped

---

## Laravel Implementation Concept
- Global Scope (FarmScope)
- Middleware TenantResolver
- Policy authorization

---

## Anti Patterns
- Query tanpa farm_id ❌
- Cross tenant access ❌
- Hardcoded tenant ❌

---

## Scaling Strategy
Jika sistem besar:
- Bisa upgrade ke database per tenant
- Atau hybrid multi-database

---

## Key Principle
> "No data ever leaves its tenant boundary"
