# WORKFLOW GENERAL — COWFARM SAAS

## Purpose
Mengatur alur kerja standar dalam membangun fitur agar sistem tetap terstruktur, tidak acak, dan mudah dikembangkan.

---

## Core Principle
Setiap fitur harus dibuat dengan urutan yang sama, tidak boleh lompat tahap.

---

## DEVELOPMENT FLOW

### 1. ANALYSIS
- Pahami kebutuhan fitur
- Tentukan tujuan fitur
- Identifikasi module terkait

---

### 2. DESIGN
- Rancang database jika diperlukan
- Tentukan flow data
- Tentukan UI structure

---

### 3. IMPLEMENTATION PLAN
Urutan wajib:
1. Migration
2. Model
3. Controller
4. Service (jika ada)
5. Route
6. Blade / API

---

### 4. CODING
- Implementasi sesuai plan
- Tidak boleh lompat layer

---

### 5. TESTING
- Cek fungsi berjalan
- Cek error
- Cek validasi

---

### 6. REFACTOR
- Bersihkan kode
- Rapikan struktur
- Hilangkan duplicate code

---

## RULES
- Tidak boleh langsung coding tanpa analisis
- Tidak boleh skip database design
- Tidak boleh campur logic UI dan backend

---

## KEY PRINCIPLE
> "Think first, build second"
