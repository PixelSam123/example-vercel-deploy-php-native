# example-vercel-deploy-php-native

Contoh Deployment Aplikasi PHP Native ke Vercel berupa To-do List untuk WPU Sharing Session 7 November 2025.

## Cara Menjalankan

1. Buat satu database, dan satu tabel di Supabase namanya `todos`, dengan kolom-kolom berikut:
- id: int8 primary key auto_increment
- created_at: timestamptz not null default now()
- item: varchar(255) not null
- is_checked: bool not null

2. Ambil koneksi ke database melalui metode **transaction pooler (penting, agar koneksi inisial tidak memakan waktu lama).** Masukkan HOST, PORT, DBNAME, USER dan PASSWORD dari parameter yang disediakan Supabase ke dalam file `.env`, contoh:

```env
HOST=xyz.pooler.supabase.com
PORT=1234
DBNAME=postgres
USER=postgres.bunchofrandomletters
PASSWORD=yourpasswordhere
```

3. Jalankan local server melalui `php -S localhost:8000` atau ganti 8000 dengan port yang diinginkan.

4. Deploy ke Vercel dengan cara import dari project GitHub saja, import `.env` local kalian dan biarkan project kalian di-package dan diberikan link-nya oleh Vercel. Selesai 🎉

## Tentang PHP Runtime untuk Vercel

Untuk meminta Vercel menggunakan PHP Runtime, diperlukan file `vercel.json` yang bisa dianggap sebagai `.htaccess` versi Vercel.  
Perlu diketahui bahwa entry point tidak boleh di luar folder `/api`, sehingga file-file PHP perlu ada dalam folder `/api`.

Kalian bisa membaca dokumentasi Vercel PHP Runtime di sini:  
https://github.com/vercel-community/php

## Referensi

- https://neon.com/postgresql/postgresql-php/connect
- https://stackoverflow.com/questions/67963371/load-a-env-file-with-php
- https://github.com/vercel-community/php
- https://vercel.com
- https://supabase.com/dashboard