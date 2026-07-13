# BUSINESS FLOW COWFARM SAAS

## 1. Registrasi User
User mendaftar ke sistem
→ sistem membuat akun
→ user otomatis masuk sebagai "admin farm"

---

## 2. Pembuatan Farm
Admin membuat farm baru
→ farm_id dibuat
→ semua data akan terikat ke farm tersebut

---

## 3. Manajemen Sapi
Admin menambahkan sapi:
- nama sapi
- umur
- status kesehatan

Sapi masuk ke database dengan relasi farm_id

---

## 4. Produksi Susu
Setiap sapi memiliki data produksi:
- tanggal
- jumlah susu (liter)

Data disimpan per hari

---

## 5. Kesehatan Sapi
Admin mencatat:
- penyakit
- perawatan
- status kesehatan

---

## 6. Pakan Sapi
Catatan pemberian pakan:
- jenis pakan
- jumlah
- jadwal

---

## 7. Dashboard
Sistem menampilkan:
- total sapi
- total produksi susu
- sapi sehat vs sakit
- aktivitas farm

---

## 8. Multi-Tenant Isolation
Setiap farm:
- tidak bisa melihat data farm lain
- semua query wajib filter farm_id

---

## 9. Output Sistem
- laporan harian
- statistik produksi
- data kesehatan
