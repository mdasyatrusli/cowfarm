# Feature Checklist

## Purpose

Memastikan setiap fitur baru telah selesai dibangun sesuai standar proyek CowFarm SaaS.

---

## When to Use

Gunakan checklist ini setelah implementasi fitur selesai dan sebelum melakukan commit atau pull request.

---

# REQUIREMENT

☐ Semua kebutuhan fitur telah diimplementasikan

☐ Tidak ada requirement yang terlewat

☐ Sesuai Business Flow

---

# DATABASE

☐ Migration berhasil dijalankan

☐ Rollback berhasil

☐ Foreign Key benar

☐ Index dibuat jika diperlukan

☐ farm_id digunakan untuk data tenant

---

# MODEL

☐ Fillable sudah benar

☐ Relationship lengkap

☐ Scope digunakan jika diperlukan

---

# VALIDATION

☐ Menggunakan FormRequest

☐ Semua input divalidasi

☐ Error message jelas

---

# CONTROLLER

☐ Tidak ada business logic

☐ Menggunakan Service

☐ Dependency Injection digunakan

---

# SERVICE

☐ Business logic berada di Service

☐ Method kecil dan fokus

☐ Tidak ada duplicate code

---

# ROUTE

☐ Route sudah terdaftar

☐ Middleware benar

☐ Authorization benar

---

# UI

☐ Responsive

☐ Validation tampil

☐ Loading state

☐ Empty state

☐ Success message

☐ Error message

---

# API (jika ada)

☐ Menggunakan Resource

☐ HTTP Status Code benar

☐ Response konsisten

---

# SECURITY

☐ Authorization

☐ Authentication

☐ CSRF

☐ Input Validation

---

# TESTING

☐ Manual Test

☐ Feature Test

☐ Tidak ada error

---

# DOCUMENTATION

☐ Dokumentasi diperbarui

☐ Changelog diperbarui

---

## PASS CRITERIA

Semua checklist wajib selesai sebelum fitur dianggap selesai.
