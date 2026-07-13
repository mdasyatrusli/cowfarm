# Laravel Controller Template

## Purpose
Template standar untuk membuat Controller Laravel pada proyek CowFarm SaaS.

---

## File Location

app/Http/Controllers/

---

## Naming Convention

EntityController

Contoh:
- CowController
- FarmController
- MilkRecordController

---

## Required Methods

- index()
- create()
- store()
- show()
- edit()
- update()
- destroy()

---

## Controller Responsibilities

Controller hanya boleh:

- menerima request
- memanggil Service
- mengembalikan response

Controller tidak boleh:

- business logic
- query kompleks
- validasi manual

---

## Dependencies

Gunakan Dependency Injection.

Contoh:

- Service
- FormRequest

---

## Return Type

Blade:
return view()

API:
return Resource

Redirect:
return redirect()

---

## Checklist

☐ Menggunakan FormRequest

☐ Menggunakan Service

☐ Tidak ada business logic

☐ Method resource lengkap

☐ Naming sesuai standar
