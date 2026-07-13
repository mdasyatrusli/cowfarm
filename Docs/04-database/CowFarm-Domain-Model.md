# COWFARM DOMAIN MODEL

## Purpose
Menjelaskan struktur inti bisnis peternakan sapi dalam bentuk data model.

---

# CORE ENTITIES

## 1. Farm
Representasi peternakan

Fields:
- id
- name
- location
- owner_id
- created_at

---

## 2. User
Pengguna sistem

Fields:
- id
- farm_id
- name
- email
- password
- role

Roles:
- super_admin
- admin_farm
- user

---

## 3. Cow
Data sapi

Fields:
- id
- farm_id
- name
- birth_date
- gender
- status (healthy/sick)

---

## 4. MilkRecord
Data produksi susu

Fields:
- id
- farm_id
- cow_id
- quantity (liter)
- date

---

## 5. HealthRecord
Catatan kesehatan sapi

Fields:
- id
- farm_id
- cow_id
- condition
- treatment
- date

---

## 6. FeedRecord
Catatan pakan

Fields:
- id
- farm_id
- cow_id
- feed_type
- quantity
- date

---

# RELATIONSHIP MAP

Farm
 ├── Users
 ├── Cows
      ├── MilkRecords
      ├── HealthRecords
      └── FeedRecords

---

# BUSINESS RULES

## Data Isolation
- Semua data wajib punya farm_id
- Tidak boleh cross farm access

---

## Data Flow
User → Farm → Cow → Records

---

## Constraints
- Cow harus punya farm
- Record harus punya cow
- Record harus punya farm

---

## Anti Patterns
- Cow tanpa farm ❌
- Record tanpa cow ❌
- Data tanpa relasi ❌

---

## Key Principle
> "Every data must belong to a farm, nothing exists alone"
