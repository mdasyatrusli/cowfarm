# Database Thinking

## Purpose
Mengatur cara AI merancang database sebelum menulis kode.

---

## When to Use

Gunakan skill ini ketika:

- Mendesain database baru
- Membuat migration
- Menambah tabel
- Mengubah struktur database
- Mendesain relasi
- Membuat ERD

---

## Thinking Process

AI harus selalu berpikir dengan urutan berikut:

Business Requirement
↓

Entity Identification
↓

Relationship Design
↓

Normalization
↓

Migration Design
↓

Model Relationship

---

## Rules

Sebelum membuat migration AI wajib menentukan:

- Entity utama
- Primary Key
- Foreign Key
- Relasi
- Index
- Constraint

---

## Relationship Priority

Selalu tentukan jenis relasi:

- One to One
- One to Many
- Many to Many

Gunakan Eloquent Relationship.

---

## Multi Tenant Rules

Jika project adalah SaaS:

Semua data bisnis harus memiliki:

- farm_id
- tenant isolation

Tidak boleh membuat tabel bisnis tanpa tenant identifier.

---

## Migration Rules

Migration harus:

- reversible
- menggunakan foreign key
- menggunakan cascade bila diperlukan
- menggunakan timestamps

---

## Output

AI harus menjelaskan:

1. Entity
2. Relationship
3. Migration
4. Model Relationship
5. Alasan desain database
