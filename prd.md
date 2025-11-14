Berikut teks yang sudah saya perbaiki dan dirapikan:

---

Saya ingin membuat aplikasi pemesanan tiket wisata **secara online** dengan ketentuan sebagai berikut:

### 1. Hak Akses User

#### A. Admin

a. Admin dapat login sesuai hak akses (username dan password).
b. Admin dapat mengelola data petugas tiket.
c. Admin dapat mengelola data user.
d. Admin dapat memantau transaksi pemesanan tiket masuk.
e. Admin dapat mengelola data wisata (galery, deskripsi, biaya masuk, biaya parkir mobil/motor. dll).
f. Admin dapat mengatur tiket ( harga, parkir, nomer rekening, email, wa)
f. Admin dapat membuat dan melihat laporan penjualan tiket.
g. Admin dapat logout.

#### B. Petugas Tiket

a. Petugas dapat login sesuai hak akses (username dan password).
b. Petugas dapat memindai (scan) QR Code tiket di pintu masuk.
c. Petugas dapat melihat data tiket yang telah divalidasi/discan.
d. Petugas dapat logout.

#### C. Bendahara

a. Bendahara dapat login sesuai hak akses (username dan password).
b. Bendahara dapat melihat laporan transaksi penjualan tiket.
c. Bendahara dapat memverifikasi laporan penjualan tiket yang dihasilkan sistem.
d. Bendahara dapat logout.

#### D. Owner / Pemilik Wisata

a. Owner dapat login sesuai hak akses (username dan password).
b. Owner dapat melihat laporan penjualan tiket harian, mingguan, dan bulanan.
c. Owner dapat memantau jumlah pengunjung dan pendapatan wisata.
d. Owner dapat logout.

---

### 2. Alur (Flow) Sistem

1. Pengunjung membuka landing page website tanpa harus login.
2. Pengunjung melakukan pemesanan.
3. Pengunjung mengisi data/informasi yang diperlukan (misalnya: nama, nomor WhatsApp, email, tanggal kunjungan, jumlah tiket, dan lain-lain).
4. Pengunjung melakukan transfer pembayaran (TF) sesuai nominal yang tertera.
5. Pengunjung mengunggah (upload) bukti transfer pada form yang disediakan.
6. Admin mengecek transaksi dan memvalidasi apakah pembayaran **valid** atau **tidak valid**.
7. Jika transaksi dinyatakan valid, sistem akan mengirimkan tiket ke email pengunjung dalam bentuk pdf yang didalamnya terdapat tiket dengan **QR Code**.
8. Pengunjung datang ke lokasi wisata dengan menunjukkan QR Code tiket (di HP atau hasil cetak).
9. Petugas tiket melakukan pemindaian (scan) QR Code di pintu masuk.
10. Tiket yang sudah berhasil discan **tidak dapat digunakan atau discan lagi** (hanya berlaku satu kali).

---

### 3. Ketentuan Bahasa

Semua nama menu dan basis data (nama tabel dan field) menggunakan **bahasa Indonesia**.
