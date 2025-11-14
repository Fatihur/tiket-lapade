# Security Best Practices

## File .env

### ⚠️ PENTING: Jangan Upload .env ke GitHub!

File `.env` berisi informasi sensitif seperti:
- Database credentials
- API keys
- Email passwords
- Application key

### Sudah Aman ✅

File `.env` sudah ada di `.gitignore` dan sudah dihapus dari git tracking.

### Jika Tidak Sengaja Ter-upload

Jika file `.env` tidak sengaja ter-upload ke GitHub:

1. **Hapus dari git tracking:**
```bash
git rm --cached .env
git commit -m "Remove .env from tracking"
git push
```

2. **Ganti semua credentials:**
   - Generate APP_KEY baru: `php artisan key:generate`
   - Ganti database password
   - Ganti email password
   - Ganti semua API keys

3. **Hapus dari history (jika perlu):**
```bash
# Gunakan BFG Repo-Cleaner atau git filter-branch
# Ini akan rewrite history, gunakan dengan hati-hati!
```

## Environment Files

### Development (.env)
```env
APP_ENV=local
APP_DEBUG=true
```

### Production (.env)
```env
APP_ENV=production
APP_DEBUG=false
```

### Template (.env.example)
- ✅ File `.env.example` BOLEH di-upload ke GitHub
- ✅ Berisi template tanpa nilai sensitif
- ✅ Digunakan sebagai panduan setup

## Database Security

### Jangan Gunakan Credentials Default

❌ **Jangan:**
```env
DB_USERNAME=root
DB_PASSWORD=
```

✅ **Gunakan:**
```env
DB_USERNAME=tiket_user
DB_PASSWORD=strong_random_password_here
```

### Generate Password yang Kuat

```bash
# Generate random password
openssl rand -base64 32
```

## Application Key

### Generate Key Baru

```bash
php artisan key:generate
```

### Jangan Share APP_KEY

- ❌ Jangan share di chat/email
- ❌ Jangan commit ke git
- ❌ Jangan screenshot

## Email Security

### Gunakan App Password (Gmail)

1. Enable 2-Step Verification
2. Generate App Password
3. Gunakan App Password di MAIL_PASSWORD

❌ **Jangan gunakan password akun:**
```env
MAIL_PASSWORD=your_gmail_password
```

✅ **Gunakan App Password:**
```env
MAIL_PASSWORD=abcd efgh ijkl mnop
```

## File Upload Security

### Validasi File Upload

```php
$request->validate([
    'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
]);
```

### Jangan Simpan di Public Folder

❌ **Jangan:**
```php
$file->move(public_path('uploads'), $filename);
```

✅ **Gunakan Storage:**
```php
$file->store('uploads', 'public');
```

## Production Checklist

### Before Deploy

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Ganti semua default passwords
- [ ] Generate APP_KEY baru
- [ ] Setup SSL certificate
- [ ] Enable firewall
- [ ] Backup database
- [ ] Test semua fitur

### After Deploy

- [ ] Monitor error logs
- [ ] Check file permissions
- [ ] Test backup restore
- [ ] Setup automated backups
- [ ] Monitor server resources

## Common Vulnerabilities

### SQL Injection

✅ **Gunakan Eloquent/Query Builder:**
```php
User::where('email', $email)->first();
```

❌ **Jangan gunakan raw query:**
```php
DB::select("SELECT * FROM users WHERE email = '$email'");
```

### XSS (Cross-Site Scripting)

✅ **Blade auto-escape:**
```blade
{{ $user->name }}
```

❌ **Jangan gunakan raw output:**
```blade
{!! $user->name !!}
```

### CSRF Protection

✅ **Selalu gunakan @csrf:**
```blade
<form method="POST">
    @csrf
    ...
</form>
```

### File Upload

✅ **Validasi tipe file:**
```php
'file' => 'required|mimes:pdf,jpg,png|max:2048'
```

## Reporting Security Issues

Jika menemukan security vulnerability:

1. **Jangan** buat public issue di GitHub
2. Email ke: security@yourdomain.com
3. Berikan detail lengkap
4. Tunggu response sebelum disclosure

## Resources

- [Laravel Security](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://phptherightway.com/#security)

---

**Last Updated:** 2024-11-14
