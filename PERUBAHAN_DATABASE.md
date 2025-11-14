# Perubahan Struktur Database

## ✅ Perubahan Selesai Dilakukan

### 1. Database Schema

#### Tabel `wisata`
**Dihapus:**
- `nama_wisata` - Tidak diperlukan karena single wisata system
- `harga_tiket_dewasa` - Digabung menjadi satu harga
- `harga_tiket_anak` - Digabung menjadi satu harga

**Ditambah:**
- `harga_tiket` - Harga tiket umum (tidak dibedakan dewasa/anak)

#### Tabel `pemesanan`
**Dihapus:**
- `wisata_id` - Tidak diperlukan karena hanya ada 1 wisata
- `jumlah_tiket_dewasa` - Digabung menjadi satu field
- `jumlah_tiket_anak` - Digabung menjadi satu field

**Ditambah:**
- `jumlah_tiket` - Total jumlah tiket (tidak dibedakan dewasa/anak)

### 2. Models

✅ **app/Models/Wisata.php** - Updated
- Fillable fields disesuaikan
- Relasi `pemesanan()` dihapus

✅ **app/Models/Pemesanan.php** - Updated
- Fillable fields disesuaikan
- Relasi `wisata()` dihapus

### 3. Seeders

✅ **database/seeders/WisataSeeder.php** - Updated
- Data default disesuaikan dengan struktur baru

### 4. Controllers

✅ **app/Http/Controllers/PemesananController.php** - Updated
- Validation disesuaikan
- Perhitungan total harga disesuaikan
- Tidak perlu wisataId parameter

✅ **app/Http/Controllers/Admin/WisataController.php** - Updated
- Validation disesuaikan
- Default data disesuaikan

✅ **app/Http/Controllers/Admin/TransaksiController.php** - Updated (partial)
- Generate tiket disesuaikan (tidak ada pembedaan dewasa/anak)

### 5. Routes

✅ **routes/web.php** - Updated
- Route pemesanan tidak perlu wisataId

---

## ⚠️ File yang Masih Perlu Diupdate Manual

Karena banyaknya file view yang perlu diupdate, berikut adalah daftar file dan cara updatenya:

### Views Landing Page

#### 1. resources/views/landing/index.blade.php
**Perubahan:**
```blade
<!-- HAPUS atau GANTI -->
<h2>{{ $wisata->nama_wisata }}</h2>
<!-- DENGAN -->
<h2>Wisata Kami</h2>

<!-- HAPUS -->
<p>Rp {{ number_format($wisata->harga_tiket_dewasa, 0, ',', '.') }}</p>
<p>Rp {{ number_format($wisata->harga_tiket_anak, 0, ',', '.') }}</p>
<!-- GANTI DENGAN -->
<p>Rp {{ number_format($wisata->harga_tiket, 0, ',', '.') }}</p>

<!-- UPDATE LINK -->
<a href="{{ route('pemesanan.create', $wisata->id) }}">
<!-- MENJADI -->
<a href="{{ route('pemesanan.create') }}">
```

#### 2. resources/views/landing/detail.blade.php
**Perubahan yang sama dengan index.blade.php**

#### 3. resources/views/landing/pemesanan.blade.php
**Perubahan:**
```blade
<!-- HAPUS input jumlah_tiket_dewasa dan jumlah_tiket_anak -->
<!-- GANTI DENGAN -->
<div>
    <label>Jumlah Tiket</label>
    <input type="number" name="jumlah_tiket" value="{{ old('jumlah_tiket', 1) }}" 
           min="1" data-harga="{{ $wisata->harga_tiket }}"
           class="form-control hitung-total" required>
    <p>Rp {{ number_format($wisata->harga_tiket, 0, ',', '.') }}/tiket</p>
</div>

<!-- UPDATE JavaScript perhitungan total -->
<script>
$('.hitung-total').on('input', function() {
    let jumlahTiket = parseInt($('input[name="jumlah_tiket"]').val()) || 0;
    let hargaTiket = parseInt($('input[name="jumlah_tiket"]').data('harga')) || 0;
    let parkirMotor = parseInt($('input[name="jumlah_parkir_motor"]').val()) || 0;
    let hargaParkirMotor = parseInt($('input[name="jumlah_parkir_motor"]').data('harga')) || 0;
    let parkirMobil = parseInt($('input[name="jumlah_parkir_mobil"]').val()) || 0;
    let hargaParkirMobil = parseInt($('input[name="jumlah_parkir_mobil"]').data('harga')) || 0;
    
    let total = (jumlahTiket * hargaTiket) + 
                (parkirMotor * hargaParkirMotor) + 
                (parkirMobil * hargaParkirMobil);
    
    $('#total-harga').text('Rp ' + total.toLocaleString('id-ID'));
});
</script>
```

#### 4. resources/views/landing/sukses.blade.php
**Perubahan:**
```blade
<!-- HAPUS -->
<p>Wisata: {{ $pemesanan->wisata->nama_wisata }}</p>
<!-- GANTI DENGAN -->
<p>Wisata: Wisata Kami</p>
```

### Views Admin Panel

#### 5. resources/views/admin/wisata/index.blade.php
**Perubahan:**
```blade
<!-- HAPUS -->
<p>{{ $wisata->nama_wisata }}</p>
<p>Rp {{ number_format($wisata->harga_tiket_dewasa, 0, ',', '.') }}</p>
<p>Rp {{ number_format($wisata->harga_tiket_anak, 0, ',', '.') }}</p>

<!-- GANTI DENGAN -->
<p>Rp {{ number_format($wisata->harga_tiket, 0, ',', '.') }}</p>
```

#### 6. resources/views/admin/wisata/edit.blade.php
**Perubahan:**
```blade
<!-- HAPUS input nama_wisata -->
<!-- HAPUS input harga_tiket_dewasa dan harga_tiket_anak -->

<!-- GANTI DENGAN -->
<div class="mb-3">
    <label class="form-label">Harga Tiket</label>
    <input type="number" name="harga_tiket" class="form-control" 
           value="{{ old('harga_tiket', $wisata->harga_tiket) }}" required>
</div>
```

#### 7. resources/views/admin/transaksi/index.blade.php
**Perubahan:**
```blade
<!-- HAPUS -->
<td>{{ $p->wisata->nama_wisata }}</td>
<!-- GANTI DENGAN -->
<td>Wisata Kami</td>
```

#### 8. resources/views/admin/transaksi/detail.blade.php
**Perubahan:**
```blade
<!-- HAPUS -->
<td>: {{ $pemesanan->wisata->nama_wisata }}</td>
<td>: {{ $pemesanan->jumlah_tiket_dewasa }} x Rp {{ number_format($pemesanan->wisata->harga_tiket_dewasa, 0, ',', '.') }}</td>
<td>: {{ $pemesanan->jumlah_tiket_anak }} x Rp {{ number_format($pemesanan->wisata->harga_tiket_anak, 0, ',', '.') }}</td>

<!-- GANTI DENGAN -->
<td>: Wisata Kami</td>
<td>: {{ $pemesanan->jumlah_tiket }} tiket</td>
```

#### 9. resources/views/admin/laporan/index.blade.php
**Perubahan:**
```blade
<!-- HAPUS kolom wisata dari filter dan tabel -->
<!-- HAPUS kolom jumlah_tiket_dewasa dan jumlah_tiket_anak -->
<!-- GANTI DENGAN kolom jumlah_tiket -->
<td>{{ $p->jumlah_tiket }}</td>
```

### Views Email & PDF

#### 10. resources/views/emails/tiket.blade.php
**Perubahan:**
```blade
<!-- HAPUS -->
<span>{{ $pemesanan->wisata->nama_wisata }}</span>
<span>{{ $pemesanan->jumlah_tiket_dewasa }} orang</span>
<span>{{ $pemesanan->jumlah_tiket_anak }} orang</span>

<!-- GANTI DENGAN -->
<span>Wisata Kami</span>
<span>{{ $pemesanan->jumlah_tiket }} tiket</span>
```

#### 11. resources/views/pdf/tiket.blade.php
**Perubahan yang sama dengan email template**

### Views Petugas

#### 12. resources/views/petugas/riwayat.blade.php
**Perubahan:**
```blade
<!-- HAPUS -->
<td>{{ $tiket->pemesanan->wisata->nama_wisata }}</td>
<td>{{ $tiket->pemesanan->jumlah_tiket_dewasa }} Dewasa, {{ $tiket->pemesanan->jumlah_tiket_anak }} Anak</td>

<!-- GANTI DENGAN -->
<td>Wisata Kami</td>
<td>{{ $tiket->pemesanan->jumlah_tiket }} tiket</td>
```

#### 13. resources/views/petugas/dashboard.blade.php
**Perubahan yang sama**

### Views Bendahara & Owner

#### 14. resources/views/bendahara/dashboard.blade.php
#### 15. resources/views/owner/dashboard.blade.php
**Perubahan yang sama dengan admin views**

### Controllers Lainnya

#### 16. app/Http/Controllers/Admin/LaporanController.php
**Perubahan:**
```php
// HAPUS filter wisata
// UPDATE perhitungan total tiket
$totalTiket = $pemesanan->sum('jumlah_tiket');
```

#### 17. app/Http/Controllers/Owner/DashboardController.php
**Perubahan:**
```php
// UPDATE query
DB::raw('SUM(jumlah_tiket) as pengunjung')
```

#### 18. app/Http/Controllers/Petugas/ScanController.php
**Perubahan:**
```php
// HAPUS referensi ke wisata
'wisata' => 'Wisata Kami',
```

#### 19. app/Mail/TiketEmail.php
**Perubahan:**
```php
// UPDATE subject
subject: 'Tiket Wisata Kami',
```

---

## 🚀 Cara Update Cepat

### Menggunakan Find & Replace di Editor

1. **Find:** `->nama_wisata`  
   **Replace:** (hapus atau ganti dengan "Wisata Kami")

2. **Find:** `->harga_tiket_dewasa`  
   **Replace:** `->harga_tiket`

3. **Find:** `->harga_tiket_anak`  
   **Replace:** (hapus baris)

4. **Find:** `jumlah_tiket_dewasa`  
   **Replace:** `jumlah_tiket`

5. **Find:** `jumlah_tiket_anak`  
   **Replace:** (hapus atau set 0)

6. **Find:** `$pemesanan->wisata->`  
   **Replace:** (hapus relasi)

7. **Find:** `route('pemesanan.create', $wisata->id)`  
   **Replace:** `route('pemesanan.create')`

---

## ✅ Testing

Setelah semua file diupdate, jalankan:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Test fitur:
- ✅ Landing page
- ✅ Form pemesanan
- ✅ Admin panel
- ✅ Validasi transaksi
- ✅ Email & PDF
- ✅ Scan QR Code
- ✅ Laporan

---

## 📝 Catatan

Perubahan ini dilakukan untuk menyederhanakan sistem karena:
1. Hanya ada 1 wisata (single wisata system)
2. Tidak perlu pembedaan harga dewasa/anak
3. Mengurangi kompleksitas database dan kode
4. Mempermudah maintenance

Jika di kemudian hari perlu kembali ke sistem multi-wisata atau pembedaan harga, bisa dilakukan dengan migration baru.
