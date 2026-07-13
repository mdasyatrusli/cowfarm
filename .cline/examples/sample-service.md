# Sample Service

## Purpose

Contoh Service Layer.

---

## Responsibilities

Service berisi:

- business logic
- transaction
- workflow

---

## Good Structure

CowService

├── create()

├── update()

├── delete()

├── sync()

├── calculate()

---

## Rules

Service tidak boleh:

- return Blade

- membaca Request langsung

- mengakses Session

---

## Best Practice

✔ Single Responsibility

✔ Reusable

✔ Small Methods
