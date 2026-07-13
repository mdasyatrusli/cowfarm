# Fix Bug Prompt

## Purpose

Memandu AI dalam menganalisis, menemukan akar penyebab, dan memperbaiki bug tanpa merusak fitur lain.

---

## When to Use

Gunakan ketika:

- muncul error Laravel
- exception
- SQL Error
- Validation Error
- API Error
- Blade Error
- Authentication Error
- Queue Error
- Deployment Error

---

## Inputs

AI harus mengumpulkan informasi berikut:

- Error Message
- Stack Trace
- Route
- Controller
- Service
- Model
- Migration (jika ada)
- Environment
- Langkah untuk mereproduksi bug

---

## AI Thinking Process

### Step 1

Reproduce bug

↓

### Step 2

Cari Root Cause

↓

### Step 3

Identifikasi file yang terlibat

↓

### Step 4

Tentukan solusi paling kecil

↓

### Step 5

Pastikan fitur lain tidak rusak

↓

### Step 6

Verifikasi hasil

---

## Debug Priority

1.
Syntax Error

↓

2.
Route

↓

3.
Middleware

↓

4.
Validation

↓

5.
Service

↓

6.
Model

↓

7.
Database

↓

8.
Frontend

---

## Implementation Strategy

AI harus:

✔ Menjelaskan penyebab

✔ Menjelaskan dampak

✔ Memberikan solusi

✔ Memberikan langkah verifikasi

---

## Output Format

Problem Summary

↓

Root Cause

↓

Technical Analysis

↓

Files Affected

↓

Fix Implementation

↓

Verification Steps

↓

Prevention

---

## Quality Checklist

☐ Root Cause ditemukan

☐ Tidak ada workaround

☐ Tidak merusak fitur lain

☐ Sudah diverifikasi

---

## Example

User:

> SQLSTATE Foreign Key Constraint

AI:

- identifikasi migration
- cek tipe data
- cek foreign key
- cek urutan migration
- berikan solusi
