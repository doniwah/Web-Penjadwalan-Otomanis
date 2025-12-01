# 📧 Email Notification System - Quick Start Guide

## Overview

Sistem notifikasi email otomatis yang mengirimkan pengingat ke dosen dan mahasiswa **5 jam sebelum jadwal kuliah dimulai**.

## 🚀 Quick Setup

### 1. Konfigurasi Email

Edit file `.env` dan tambahkan konfigurasi email:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=e41240137@student.polije.ac.id
MAIL_PASSWORD=vdxtbmqoahtpskch
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=e41240137@student.polije.ac.id
MAIL_FROM_NAME="SiJaDu System"
```

> **Catatan:** Lihat file `.env.email.example` untuk contoh konfigurasi berbagai provider email.

### 2. Jalankan Scheduler (Development)

Buka terminal baru dan jalankan:

```bash
php artisan schedule:work
```

Biarkan terminal ini tetap berjalan. Scheduler akan memeriksa jadwal setiap jam.

### 3. Test Manual

Untuk test langsung tanpa menunggu scheduler:

```bash
php artisan send:schedule-reminders
```

## 📋 Cara Kerja

1. **Setiap jam**, sistem akan memeriksa jadwal yang akan dimulai dalam 5 jam
2. **Sistem mencari**:
   - Jadwal yang sesuai dengan hari dan waktu
   - Dosen yang mengajar (dosen 1 dan dosen 2 jika ada)
   - Mahasiswa yang terdaftar di kelas tersebut
3. **Email dikirim** ke semua pihak terkait dengan detail:
   - Nama mata kuliah
   - Ruangan
   - Waktu
   - Dosen pengajar (untuk mahasiswa)
   - Nama kelas (untuk dosen)

## 🎯 Contoh Email

**Untuk Dosen:**
```
Halo Dr. Ahmad,

Anda memiliki jadwal mengajar dalam 5 jam.

Detail Jadwal:
📚 Mata Kuliah: Pemrograman Web
🏫 Ruangan: Lab Komputer 1
📅 Hari: Senin
🕐 Waktu: 13:00 - 15:00
👥 Kelas: TI-3A

Pastikan Anda sudah siap dan tidak terlambat.

Terima kasih,
Tim SiJaDu
```

**Untuk Mahasiswa:**
```
Halo Budi Santoso,

Anda memiliki jadwal kuliah dalam 5 jam.

Detail Jadwal:
📚 Mata Kuliah: Pemrograman Web
👨‍🏫 Dosen: Dr. Ahmad & Dr. Siti
🏫 Ruangan: Lab Komputer 1
📅 Hari: Senin
🕐 Waktu: 13:00 - 15:00

Pastikan Anda sudah siap dan tidak terlambat.

Terima kasih,
Tim SiJaDu
```

## 🔧 Production Setup

Untuk server production, tambahkan cron job:

```bash
* * * * * cd /path-to-sijadu && php artisan schedule:run >> /dev/null 2>&1
```

## ✅ Verifikasi

Cek daftar scheduled tasks:
```bash
php artisan schedule:list
```

Output yang benar:
```
0 * * * *  php artisan send:schedule-reminders
```

## 🐛 Troubleshooting

### Email tidak terkirim?
1. Cek konfigurasi `.env`
2. Test koneksi SMTP
3. Cek log: `storage/logs/laravel.log`

### Tidak ada jadwal yang ditemukan?
1. Pastikan ada jadwal di database
2. Cek nama hari (harus dalam bahasa Indonesia: Senin, Selasa, dll)
3. Pastikan waktu jadwal sesuai (5-6 jam dari sekarang)

## 📁 File Penting

- `app/Notifications/ScheduleReminder.php` - Template email
- `app/Console/Commands/SendScheduleReminders.php` - Logic pengiriman
- `routes/console.php` - Konfigurasi scheduler
- `database/migrations/*_create_schedule_notifications_table.php` - Database tracking

## 💡 Tips

- Gunakan **Mailtrap** untuk testing (tidak mengirim email sungguhan)
- Gunakan **Gmail** dengan App Password untuk development
- Gunakan **SendGrid** atau **Mailgun** untuk production
- Sistem otomatis mencegah pengiriman email duplikat
