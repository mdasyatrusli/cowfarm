# Business Rules

## Tenant

Satu Farm = Satu Tenant

Semua data bisnis harus terikat dengan farm_id.

---

## User Roles

Super Admin

- Mengelola seluruh tenant

Farm Admin

- Mengelola satu farm

User

- Menggunakan fitur sesuai izin

---

## Cow

Setiap sapi:

- memiliki identitas unik
- berada pada satu farm
- memiliki riwayat kesehatan
- memiliki riwayat produksi susu

---

## Milk Production

Produksi susu selalu:

- memiliki tanggal
- memiliki jumlah
- memiliki sapi

---

## Vaccination

Setiap vaksin:

- memiliki tanggal
- jenis vaksin
- petugas

---

## Security Rule

User tidak boleh melihat data tenant lain.
