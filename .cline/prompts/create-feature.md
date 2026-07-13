# Create Feature Prompt

## Purpose

Panduan bagi AI untuk merancang dan mengimplementasikan fitur baru pada proyek CowFarm SaaS secara sistematis.

---

## Objective

Ketika user meminta fitur baru, AI harus:

- memahami kebutuhan bisnis
- menganalisis dampak terhadap sistem
- membuat rencana implementasi
- menghasilkan kode sesuai standar proyek

---

## Thinking Process

### Step 1 — Requirement Analysis

Identifikasi:

- tujuan fitur
- aktor yang menggunakan
- masalah yang diselesaikan
- output yang diharapkan

---

### Step 2 — Architecture Analysis

Tentukan apakah fitur membutuhkan:

- tabel baru
- kolom baru
- relasi baru
- perubahan API
- perubahan UI

---

### Step 3 — Module Identification

Identifikasi module yang terlibat.

Contoh:

- Farm
- Cow
- Milk
- Health
- Feed
- Report

---

### Step 4 — Implementation Plan

Susun urutan pekerjaan:

1. Migration
2. Model
3. Relationship
4. Form Request
5. Service
6. Controller
7. Route
8. Blade atau API
9. Testing
10. Documentation

---

### Step 5 — Code Generation

Kode harus mengikuti:

- Laravel Best Practice
- Service Layer
- Form Request Validation
- Resource jika API
- Blade Component jika UI

---

### Step 6 — Validation

Sebelum selesai AI harus memastikan:

- Semua route benar
- Validasi tersedia
- Authorization benar
- Tidak ada duplicate code
- Multi-tenant aman
- Tidak terjadi N+1 Query

---

## Output Format

AI harus memberikan jawaban dengan urutan:

### Requirement Summary

---

### Technical Design

---

### Database Changes

---

### Files To Create

---

### Implementation Steps

---

### Generated Code

---

### Testing Plan

---

### Next Recommendation

---

## Example

User:

> Tambahkan fitur pencatatan vaksin sapi.

AI:

1. Analisis kebutuhan
2. Tambahkan tabel vaccinations
3. Relasi ke cows
4. Buat Vaccination model
5. Buat Form Request
6. Buat Service
7. Buat Controller
8. Tambahkan menu Blade
9. Tambahkan Feature Test
10. Dokumentasikan perubahan

---

## Final Rule

AI tidak boleh langsung menghasilkan kode sebelum menyelesaikan proses analisis dan perencanaan implementasi.
