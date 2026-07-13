# Code Review Checklist

## Purpose

Membantu AI dan developer melakukan code review secara konsisten.

---

## When to Use

Sebelum merge ke branch develop atau main.

---

# ARCHITECTURE

☐ MVC dipatuhi

☐ Service Layer digunakan

☐ Tidak ada business logic di Controller

---

# DATABASE

☐ Query optimal

☐ Tidak ada N+1 Query

☐ Relationship benar

---

# PERFORMANCE

☐ Pagination digunakan

☐ Eager Loading digunakan

☐ Cache dipertimbangkan

---

# SECURITY

☐ Validation lengkap

☐ Authorization benar

☐ Tidak ada hardcoded secret

---

# CODE QUALITY

☐ Naming jelas

☐ Function pendek

☐ Tidak ada duplicate code

☐ Tidak ada dead code

---

# UI

☐ Konsisten

☐ Responsive

☐ Mudah digunakan

---

# TESTING

☐ Semua test lulus

☐ Tidak ada warning penting

---

## PASS CRITERIA

Tidak ada isu Critical atau High sebelum merge.
