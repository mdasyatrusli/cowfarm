# Migration Template

## Purpose

Template standar migration Laravel.

---

## Naming

create_entities_table

add_column_to_entities_table

---

## Required Columns

- id
- farm_id (jika data tenant)
- timestamps

---

## Rules

Gunakan:

- foreignId()
- constrained()
- cascadeOnDelete() jika diperlukan

---

## Required Structure

Primary Key

↓

Business Fields

↓

Foreign Keys

↓

Indexes

↓

Timestamps

---

## Checklist

☐ Nama migration benar

☐ Foreign key benar

☐ Index dibuat

☐ Rollback aman

☐ Timestamp tersedia
