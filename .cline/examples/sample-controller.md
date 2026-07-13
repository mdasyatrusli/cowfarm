# Sample Controller

## Purpose

Contoh Controller yang sesuai standar CowFarm.

---

## Responsibilities

Controller hanya bertugas:

- menerima request
- validasi menggunakan FormRequest
- memanggil Service
- mengembalikan response

---

## Good Example Structure

CowController

├── index()
├── create()
├── store()
├── show()
├── edit()
├── update()
└── destroy()

---

## Best Practices

✔ Dependency Injection

✔ Resource Controller

✔ FormRequest

✔ Service Layer

✔ Authorization

---

## Never

❌ Query kompleks

❌ Business Logic

❌ Raw SQL

❌ Validasi manual
