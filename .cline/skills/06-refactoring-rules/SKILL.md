# Refactoring Rules

## Purpose

Mengatur proses perbaikan kode tanpa mengubah perilaku aplikasi.

---

## Goal

Refactoring bertujuan:

- meningkatkan kualitas kode
- meningkatkan keterbacaan
- mengurangi duplicate code

---

## Rules

Sebelum refactor AI harus memastikan:

Semua fitur lama tetap berjalan.

---

## Refactor Priority

1.
Duplicate Code

↓

2.
Long Method

↓

3.
Large Controller

↓

4.
Complex Query

↓

5.
Magic Number

↓

6.
Naming

---

## Laravel Rules

Controller maksimal berisi:

- request
- validation
- service call

Logic dipindahkan ke Service.

---

## Output

AI harus menjelaskan:

Before

↓

Problem

↓

Improvement

↓

After
