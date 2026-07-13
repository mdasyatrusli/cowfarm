# Debugging System

## Purpose

Mengatur proses debugging secara sistematis.

---

## Debug Order

AI wajib melakukan debugging dengan urutan berikut.

1.
Route

↓

2.
Middleware

↓

3.
Controller

↓

4.
Request Validation

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
View / API Response

---

## Rules

AI tidak boleh:

- langsung mengubah kode
- menebak penyebab error

AI harus mencari Root Cause terlebih dahulu.

---

## Required Analysis

Untuk setiap error AI harus menjelaskan:

- Penyebab
- Lokasi
- Dampak
- Solusi
- Cara mencegah

---

## Output Format

Root Cause

↓

Analysis

↓

Solution

↓

Verification
