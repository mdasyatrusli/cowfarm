Berikut usulan struktur kolom berdasarkan domain umum peternakan sapi, sesuai 4 entity di ERD.md kamu:

### Tabel farms (sekaligus tabel tenant)
Kolom            |Tipe	      |Keterangan
id	             |bigint	  |PK
name             |string	  |nama peternakan
address          |string	  |alamat
phone            |string	  |kontak
owner_name       |string	  |nama pemilik/pengelola
subscription_plan|string/enum |sesuai model subscription v1 kamu
is_active	     |boolean	  |default true
timestamps		 |            |created_at,updated_at

### users (dari Breeze, ditambah kolom tenant)
Kolom	          |Tipe	       |Keterangan
id	              |bigint	   |PK
name	          |string	   |nama peternakan
address	          |string	   |alamat
phone	          |string	   |kontak
owner_name        |string	   |nama pemilik/pengelola
subscription_plan |string/enum |sesuai model subscription v1 kamu
is_active	      |boolean	   |default true
timestamps		  |            |created_at, updated_at
-----------------------------------------------------------
### users (dari Breeze, ditambah kolom tenant)
Kolom	                  |Tipe	             |Keterangan
...kolom default Breeze...		
farm_id	                  |bigint FK → farms.id|pemilik akses data user ini
role	                  |string/enum	     |misal: owner, staff
------------------------------------------------------------
### cows
Kolom	         |Tipe	                |Keterangan
id	             |bigint	            |PK
farm_id	         |bigint FK → farms.id	|isolasi tenant
tag_number	     |string	            |nomor identitas sapi (unik per farm)
name	         |string, nullable	    |nama panggilan (opsional)
breed	         |string	            |jenis/ras sapi
gender	         |enum(male,female)	
birth_date	     |date, nullable	
status	         |enum(active,sold,dead)|default active
timestamps		
-------------------------------------------------------------
### health_records
Kolom	    |Tipe	              |Keterangan
id	        |bigint	              |PK
cow_id	    |bigint FK → cows.id	
farm_id	    |bigint FK → farms.id |denormalisasi, mempermudah scope query
record_date	|date	              |tanggal pemeriksaan
diagnosis	|string	
treatment	|text, nullable	
vet_name	|string, nullable	
cost	    |decimal, nullable	
timestamps	|	
------------------------------------------------------------
### milk_records
Kolom	     |Tipe	         |Keterangan
id	         |bigint          |PK
cow_id	     |bigint          |FK → cows.id	
farm_id	     |bigint          |FK → farms.id	denormalisasi
record_date 	|date	
session	     |enum(pagi,sore) |sesi pemerahan
volume_liters|decimal	     |jumlah susu
timestamps	 |
------------------------------------------------------------
### Urutan migration (FK-safe):
1. farms
2. users (Breeze default + farm_id, role)
3. cows
4. health_records
5. milk_records

### Konsep BelongsToTenant trait — otomatis filter query berdasarkan farm_id user yang login:

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('farm_id', auth()->user()->farm_id);
            }
        });

        static::creating(function ($model) {
            if (auth()->check() && !$model->farm_id) {
                $model->farm_id = auth()->user()->farm_id;
            }
        });
    }
}

Trait ini nanti dipakai di model Cow, HealthRecord, MilkRecord (tidak dipakai di Farm sendiri, karena Farm justru sumber tenant-nya).
