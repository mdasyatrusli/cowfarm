# Database Rules

## Purpose

Standar desain database.

---

## Naming

Table:

plural_snake_case

Column:

snake_case

Primary Key:

id

Foreign Key:

entity_id

---

## Required Columns

Semua tabel bisnis:

- id
- farm_id
- created_at
- updated_at

---

## Relationship

Gunakan:

- foreign key
- cascade jika perlu

---

## Index

Index wajib:

- farm_id
- created_at
- foreign key

---

## Migration

Migration harus:

- reversible
- menggunakan constraint
- menggunakan timestamps

---

## Multi Tenant

Semua tabel bisnis:

wajib memiliki farm_id.

---

## Never

- Duplicate data
- Tanpa foreign key
- Tanpa index
