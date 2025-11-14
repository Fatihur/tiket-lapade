# Panduan Penggunaan Aplikasi Tiket Wisata Online

## Alur Sistem

### 1. Pengunjung (Public)

#### A. Melihat Daftar Wisata
1. Buka halaman utama aplikasi
2. Lihat daftar wisata yang tersedia
3. Klik "Detail" untuk melihat informasi lengkap wisata

#### B. Memesan Tiket
1. Klik tombol "Pesan Tiket" pada wisata yang dipilih
2. Isi form pemesanan:
   - Nama lengkap
   - Email (untuk menerima tiket)
   - Nomor WhatsApp
   - Tanggal kunjungan
   - Jumlah tiket dewasa
   - Jumlah tiket anak
   - Jumlah parkir motor/mobil
3. Sistem akan menghitung total pembayaran otomatis
4. Lihat informasi rekening untuk transfer
5. Lakukan transfer sesuai nominal
6. Upload bukti transfer
7. Klik "Kirim Pemesanan"
8. Simpan kode pemesanan untuk tracking

#### C. Setelah Pemesanan
- Tunggu validasi dari admin (1-24 jam)
- Jika valid, tiket akan dikirim ke email dalam format PDF dengan QR Code
- Bawa tiket (cetak atau tampilkan di HP) saat berkunjung

---

### 2. Admin

#### A. Login
1. Akses halaman `/login`
2. Masukkan email: admin@wisata.com
3. Masukkan password: password
4. Klik "Login"

#### B. Dashboard
- Lihat statistik:
  - Total pemesanan
  - Pemesanan menunggu validasi
  - Pemesanan valid
  - Total pendapatan
- Lihat daftar pemesanan terbaru

#### C. Kelola Data Wisata
1. Menu "Wisata" → "Daftar Wisata"
2. Klik "Tambah Wisata"
3. Isi form:
   - Nama wisata
   - Deskripsi
   - Harga tiket dewasa
   - Harga tiket anak
   - Biaya parkir motor
   - Biaya parkir mobil
   - Informasi rekening bank
   - Email kontak
   - Nomor WhatsApp
4. Klik "Simpan"

#### D. Kelola Galeri Wisata
1. Buka detail wisata
2. Klik "Upload Gambar"
3. Pilih file gambar (JPG/PNG, max 2MB)
4. Isi keterangan (opsional)
5. Centang "Gambar Utama" jika ingin dijadikan cover
6. Klik "Upload"

#### E. Validasi Transaksi
1. Menu "Transaksi" → "Daftar Transaksi"
2. Filter berdasarkan status/tanggal (opsional)
3. Klik "Detail" pada transaksi yang ingin divalidasi
4. Lihat bukti transfer
5. Pilih status:
   - **Valid**: Jika pembayaran sesuai
   - **Tidak Valid**: Jika pembayaran tidak sesuai
6. Isi catatan (opsional)
7. Klik "Validasi Pembayaran"
8. Sistem akan generate QR Code tiket otomatis jika valid

#### F. Kelola User/Petugas
1. Menu "User" → "Daftar User"
2. Klik "Tambah User"
3. Isi form:
   - Nama
   - Email
   - Password
   - Role (Admin/Petugas/Bendahara/Owner)
   - Nomor telepon
   - Status aktif
4. Klik "Simpan"

#### G. Laporan Penjualan
1. Menu "Laporan"
2. Filter berdasarkan:
   - Tanggal dari - sampai
   - Wisata tertentu
3. Klik "Filter"
4. Lihat laporan:
   - Total pendapatan
   - Total tiket terjual
   - Detail per transaksi
5. Export/Print laporan (jika tersedia)

---

### 3. Petugas Tiket

#### A. Login
1. Akses halaman `/login`
2. Masukkan email: petugas@wisata.com
3. Masukkan password: password

#### B. Scan QR Code Tiket
1. Menu "Scan Tiket"
2. Izinkan akses kamera
3. Arahkan kamera ke QR Code tiket pengunjung
4. Sistem akan otomatis validasi:
   - **Berhasil**: Tiket valid, pengunjung boleh masuk
   - **Gagal**: Tiket sudah digunakan atau tidak valid

#### C. Input Manual (Jika Scan Gagal)
1. Di halaman scan, scroll ke bawah
2. Masukkan kode tiket secara manual
3. Klik "Validasi"

#### D. Riwayat Scan
1. Menu "Riwayat Scan"
2. Lihat daftar tiket yang sudah discan
3. Filter berdasarkan tanggal (opsional)

---

### 4. Bendahara

#### A. Login
1. Akses halaman `/login`
2. Masukkan email: bendahara@wisata.com
3. Masukkan password: password

#### B. Lihat Laporan Transaksi
1. Dashboard akan menampilkan laporan transaksi valid
2. Filter berdasarkan tanggal
3. Lihat:
   - Total pendapatan
   - Detail per transaksi
   - Informasi pemesanan

#### C. Verifikasi Laporan
1. Cocokkan data dengan rekening bank
2. Verifikasi jumlah transaksi dan nominal
3. Buat laporan keuangan

---

### 5. Owner

#### A. Login
1. Akses halaman `/login`
2. Masukkan email: owner@wisata.com
3. Masukkan password: password

#### B. Dashboard Statistik
Lihat informasi:
- Pendapatan hari ini
- Pengunjung hari ini
- Pendapatan bulan ini
- Pengunjung bulan ini

#### C. Grafik Penjualan
1. Pilih periode:
   - Harian (7 hari terakhir)
   - Mingguan (8 minggu terakhir)
   - Bulanan (12 bulan terakhir)
2. Lihat grafik:
   - Pendapatan per periode
   - Jumlah pengunjung per periode

---

## Tips Penggunaan

### Untuk Admin
- Validasi transaksi secara berkala (minimal 2x sehari)
- Update informasi wisata secara rutin
- Upload foto wisata yang menarik untuk meningkatkan pemesanan
- Backup data secara berkala

### Untuk Petugas
- Pastikan koneksi internet stabil saat scan
- Jika scan gagal, gunakan input manual
- Periksa tanggal kunjungan pada tiket
- Laporkan tiket yang mencurigakan ke admin

### Untuk Pengunjung
- Pesan tiket minimal H-1 untuk memastikan validasi tepat waktu
- Simpan kode pemesanan untuk tracking
- Cek email secara berkala setelah pemesanan
- Bawa tiket (cetak atau digital) saat berkunjung
- Pastikan QR Code terlihat jelas

---

## FAQ (Frequently Asked Questions)

### Q: Berapa lama proses validasi tiket?
A: Biasanya 1-24 jam setelah upload bukti transfer.

### Q: Apakah tiket bisa digunakan berkali-kali?
A: Tidak, tiket hanya bisa digunakan 1 kali. Setelah discan, tiket tidak bisa digunakan lagi.

### Q: Bagaimana jika bukti transfer salah upload?
A: Hubungi admin melalui WhatsApp atau email yang tertera di website.

### Q: Apakah bisa refund jika tidak jadi berkunjung?
A: Kebijakan refund tergantung pada aturan masing-masing wisata. Hubungi admin untuk informasi lebih lanjut.

### Q: Bagaimana jika QR Code tidak bisa discan?
A: Petugas bisa melakukan validasi manual dengan memasukkan kode tiket.

---

## Kontak Support

Jika ada pertanyaan atau masalah teknis, hubungi:
- Email: admin@wisata.com
- WhatsApp: (sesuai yang tertera di website)
