# Laravel Rules

## Purpose

Standar pengembangan Laravel yang wajib dipatuhi.

---

## Laravel Version

- Laravel 12
- PHP 8.3+

---

## Architecture

Gunakan:

- MVC
- Service Layer
- Form Request Validation
- Policy
- Middleware

---

## Controller Rules

Controller hanya bertugas:

- menerima request
- memanggil service
- mengembalikan response

Tidak boleh berisi business logic.

---

## Service Rules

Semua business logic ditempatkan di:

app/Services

---

## Model Rules

Model hanya untuk:

- Relationship
- Scope
- Query sederhana

---

## Route Rules

Gunakan:

- Route::resource()
- Route Group
- Middleware

---

## Validation

Semua input menggunakan:

FormRequest

---

## Blade

Gunakan:

- Layout
- Component
- Partial

---

## Eloquent

Selalu gunakan:

- eager loading
- relationship
- scope

Hindari:

- query di Blade
- N+1 Query

---

## Artisan

Prioritaskan Artisan:

php artisan make:model

php artisan make:controller

php artisan make:migration

---

## Never

- Query di View
- Business Logic di Controller
- Raw SQL tanpa alasan
