# Changelog

## [1.1.0] - 2024-11-14

### Added
- ✨ Email tiket otomatis dengan PDF dan QR Code
- ✨ Cetak laporan PDF untuk Admin dan Bendahara
- ✨ Bulk verifikasi transaksi untuk Bendahara
- ✨ Tracking verifikasi (siapa dan kapan)
- ✨ Toggle show/hide password di halaman login
- ✨ Demo credentials di halaman login
- 📝 Dokumentasi deployment lengkap (DEPLOYMENT.md)
- 📝 Panduan troubleshooting (TROUBLESHOOTING.md)
- 📝 Quick command reference (COMMANDS.md)
- 🔧 Script helper untuk switch environment (switch-env.ps1 / switch-env.sh)

### Changed
- 🎨 Redesign halaman login dengan tampilan modern
- 🎨 Perbaikan tampilan laporan Bendahara
- 🔄 Landing page sekarang menggunakan Tailwind CSS CDN (tidak perlu build)
- 🔄 Admin dashboard tetap menggunakan Vite untuk Bootstrap

### Fixed
- 🐛 Fix error Vite manifest not found di production
- 🐛 Fix modal structure di halaman laporan Bendahara
- 🐛 Fix relasi wisata di model Pemesanan

### Improved
- ⚡ Optimasi untuk production deployment
- 📦 Update .gitignore untuk file yang lebih bersih
- 📦 Tambah .editorconfig dan .gitattributes
- 🔐 Improve security dengan APP_DEBUG=false di production

## [1.0.0] - 2024-11-01

### Initial Release
- 🎉 Sistem pemesanan tiket wisata online
- 👥 Multi-role system (Admin, Bendahara, Petugas, Owner)
- 🎫 Generate QR Code otomatis untuk tiket
- 📱 QR Scanner untuk validasi tiket
- 💰 Sistem validasi pembayaran
- 📊 Dashboard statistik untuk setiap role
- 📧 Email notification system
- 🖼️ Galeri wisata
- 📱 Responsive design
