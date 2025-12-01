# Database Seeder - User Documentation

## Overview

Seeder untuk mengisi database dengan data user awal:
- **1 Admin**
- **20 Dosen** (dengan gelar akademik dan NIP)
- **500 Mahasiswa** (terbagi dalam 4 program studi)

## Program Studi

Mahasiswa terdistribusi merata di 4 program studi:

1. **Teknik Industri (TI)** - 125 mahasiswa
2. **Teknik Sipil (TS)** - 125 mahasiswa
3. **Informatika (IF)** - 125 mahasiswa
4. **Teknik Mesin (TM)** - 125 mahasiswa

## Struktur Data

### Admin
- **Email**: admin@sijadu.ac.id
- **Password**: admin123
- **Role**: admin

### Dosen (20 orang)
- **Email**: dosen1@sijadu.ac.id hingga dosen20@sijadu.ac.id
- **Password**: dosen123
- **Role**: dosen
- **NIP**: Format 19XX0XXXXXX (contoh: 198100000001)
- **Gelar**: Dr., Prof., Ir., S.T., M.T., S.Kom., M.Kom., S.Si., M.Si.
- **Max SKS**: 10-16 SKS (random)
- **Nama**: Kombinasi nama Indonesia dengan gelar akademik

### Mahasiswa (500 orang)
- **Email**: mahasiswa1@sijadu.ac.id hingga mahasiswa500@sijadu.ac.id
- **Password**: mahasiswa123
- **Role**: mahasiswa
- **NIM**: Format YYYYPPNNNN
  - YYYY = Tahun masuk (2021-2024)
  - PP = Kode prodi (01-04)
  - NNNN = Nomor urut (0001-0500)
- **Nama**: Kombinasi nama depan dan belakang Indonesia
- **Kelas**: Format PRODI-SEMESTERKELAS (contoh: IF-3A, TI-5B)
  - Semester: 1-8
  - Kelas: A, B, C, D
- **Prodi**: Teknik Industri, Teknik Sipil, Informatika, atau Teknik Mesin

## Cara Menggunakan

### 1. Jalankan Seeder

```bash
# Jalankan hanya UserSeeder
php artisan db:seed --class=UserSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

### 2. Reset dan Seed Ulang

```bash
# Hapus semua data dan seed ulang
php artisan migrate:fresh --seed
```

### 3. Verifikasi Data

```bash
# Cek jumlah users
php artisan tinker --execute="echo 'Users: ' . App\Models\User::count();"

# Cek jumlah dosen
php artisan tinker --execute="echo 'Lecturers: ' . App\Models\Lecturer::count();"

# Cek jumlah mahasiswa
php artisan tinker --execute="echo 'Students: ' . App\Models\Student::count();"
```

## Login Credentials

### Admin
```
Email: admin@sijadu.ac.id
Password: admin123
```

### Dosen
```
Email: dosen1@sijadu.ac.id (hingga dosen20@sijadu.ac.id)
Password: dosen123
```

### Mahasiswa
```
Email: mahasiswa1@sijadu.ac.id (hingga mahasiswa500@sijadu.ac.id)
Password: mahasiswa123
```

## Contoh Data

### Contoh Dosen
```
Nama: Dr. Ahmad Santoso
Email: dosen1@sijadu.ac.id
NIP: 198100000001
Max SKS: 12
```

### Contoh Mahasiswa
```
Nama: Budi Wijaya
Email: mahasiswa1@sijadu.ac.id
NIM: 202101000001
Prodi: Teknik Industri
Semester: 3
Kelas: TI-3A
```

## Distribusi Mahasiswa

| Prodi | Jumlah | Kelas | Semester |
|-------|--------|-------|----------|
| Teknik Industri | 125 | TI-1A hingga TI-8D | 1-8 |
| Teknik Sipil | 125 | TS-1A hingga TS-8D | 1-8 |
| Informatika | 125 | IF-1A hingga IF-8D | 1-8 |
| Teknik Mesin | 125 | TM-1A hingga TM-8D | 1-8 |

## File Seeder

- **UserSeeder.php**: `database/seeders/UserSeeder.php`
- **DatabaseSeeder.php**: `database/seeders/DatabaseSeeder.php`

## Catatan

- Semua password menggunakan bcrypt hashing
- Nama-nama menggunakan nama Indonesia yang umum
- NIP dosen mengikuti format standar
- NIM mahasiswa disesuaikan dengan tahun masuk dan prodi
- Distribusi kelas merata (A, B, C, D)
- Semester tersebar dari 1-8
