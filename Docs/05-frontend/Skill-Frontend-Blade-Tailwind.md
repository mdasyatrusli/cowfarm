# FRONTEND BLADE + TAILWIND — COWFARM SAAS

## Purpose
Mengatur semua tampilan UI agar konsisten, rapi, dan mudah digunakan di sistem CowFarm SaaS.

---

## Core Principle
Frontend harus:
- Simple
- Responsive
- Reusable
- Consistent design

---

## Technology Stack
- Laravel Blade
- Tailwind CSS
- Alpine.js (optional)

---

## UI ARCHITECTURE

### Layout Structure
- layouts/app.blade.php (main layout)
- layouts/auth.blade.php (login/register)
- components/ (reusable UI)

---

## Folder Structure
- resources/views/layouts
- resources/views/components
- resources/views/pages

---

## DESIGN RULES

### 1. Mobile First
- UI harus berjalan di HP dulu
- Baru desktop

### 2. Component Based
- Button harus component
- Card harus component
- Table harus reusable

### 3. No Inline CSS
- Semua pakai Tailwind

---

## DASHBOARD STRUCTURE

### Sidebar
- Dashboard
- Cows
- Milk Records
- Health Records
- Feed Records
- Settings

---

## UI PATTERN

### Card Pattern
- Statistik pakai card
- Ringkasan data pakai card

### Table Pattern
- Semua data list pakai table
- Wajib pagination

### Form Pattern
- Input harus jelas
- Validation error ditampilkan

---

## BLADE RULES
- Gunakan @extends
- Gunakan @section
- Gunakan @include untuk reusable UI

---

## COMPONENT RULES

Contoh:
- <x-button />
- <x-card />
- <x-table />

---

## DATA BINDING RULES
- Tidak boleh logic berat di Blade
- Blade hanya untuk display

---

## BEST PRACTICES
- Gunakan layout utama
- Gunakan component reusable
- Gunakan Tailwind utility class

---

## ANTI PATTERNS
- Inline CSS ❌
- Logic di Blade ❌
- Duplicate UI ❌

---

## KEY PRINCIPLE
> "UI is not decoration, UI is system usability"
