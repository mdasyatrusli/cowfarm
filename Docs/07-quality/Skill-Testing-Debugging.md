# TESTING & DEBUGGING — COWFARM SAAS

## Purpose
Menjamin sistem berjalan benar, stabil, dan bebas error sebelum masuk production.

---

## CORE PRINCIPLE
- Tidak ada fitur tanpa testing
- Semua error harus dilacak sampai akar masalah
- Debug harus sistematis, bukan coba-coba

---

## TESTING TYPES

### 1. Feature Testing
- Cek fungsi utama berjalan
- Cek input/output

### 2. Validation Testing
- Cek form validation
- Cek error handling

### 3. Integration Testing
- Cek antar modul (Cow ↔ Milk ↔ Farm)

---

## DEBUGGING FLOW

1. Reproduce error
2. Check route
3. Check controller
4. Check service
5. Check model
6. Check database
7. Check view/API

---

## DEBUG TOOLS
- dd()
- log Laravel
- browser console
- network tab

---

## RULES
- Jangan langsung ubah kode tanpa analisis
- Jangan tebak-tebakan
- Harus isolasi masalah

---

## ANTI PATTERNS
- Fix tanpa tahu root cause ❌
- Debug di production ❌
- Skip testing ❌

---

## KEY PRINCIPLE
> "No fix without understanding the problem"
