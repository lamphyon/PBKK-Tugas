# Portal Akademik — Dashboard & RBAC

Kelanjutan portal akademik PBKK menggunakan **Laravel 13**, **Laravel Breeze**,
**AdminLTE 4 / Bootstrap 5**, dan **Spatie Laravel Permission**. Kode mengikuti alur
Laravel biasa: Route → Middleware → Controller → Model → Blade.

## Menjalankan proyek

Gunakan PHP 8.4+ untuk seluruh development tools yang terkunci di `composer.lock`,
Composer, Node.js 22.12+ / npm, serta ekstensi PHP SQLite (`pdo_sqlite`).

Untuk instalasi awal:

```bash
composer setup
php artisan serve
```

`composer setup` menyiapkan `.env`, key aplikasi, database SQLite, migrasi, seeder,
dependensi frontend, aset AdminLTE lokal, dan build Vite. Jalankan sekali saat
instalasi awal; untuk menjalankan kembali proyek cukup `php artisan serve`.

Buka [halaman login](http://localhost:8000/login). Klik **Masuk Admin** atau
**Masuk Staf**, atau gunakan akun berikut:

| Peran | Email                 | Password   |
| ----- | --------------------- | ---------- |
| Admin | `admin@akademik.test` | `password` |
| Staf  | `staf@akademik.test`  | `password` |

Kedua akun demo sudah terverifikasi. Login instan memerlukan
`DEMO_LOGIN_ENABLED=true` serta environment `local` atau `testing`; controller
selalu menolaknya di production. Akun demo dan data Faker hanya dibuat di
`local`/`testing`. Semua form login instan memakai POST, CSRF, dan pembatasan
percobaan.

Untuk mengubah CSS/JS sambil mengembangkan aplikasi, jalankan `npm run dev` di
terminal kedua. Setelah selesai, `npm run build` menghasilkan aset yang bisa
disajikan tanpa Vite dev server. Aset AdminLTE disajikan dari `public/vendor`,
yang dibuat otomatis saat setup dan tidak disimpan di Git.

Pendaftar baru selalu mendapat role **Staf** dan harus memverifikasi email.
Konfigurasi lokal memakai `MAIL_MAILER=log`: tautan verifikasi/reset password
tersedia di `storage/logs/laravel.log`. Untuk pengiriman email sungguhan,
konfigurasikan mailer pada `.env`.

## Fitur dan hak akses

| Aksi                                 | Admin | Staf  |
| ------------------------------------ | ----- | ----- |
| Dashboard dan tiga statistik dinamis | Ya    | Ya    |
| Lihat, cari, dan filter mahasiswa    | Ya    | Ya    |
| Tambah dan ubah mahasiswa            | Ya    | Ya    |
| Hapus mahasiswa                      | Ya    | Tidak |

Dashboard berada di `/dashboard`; tabel mahasiswa di `/admin/mahasiswa`.
Halaman publik tugas sebelumnya tetap tersedia dan memiliki tautan Login/Dashboard.

**Admin murni** pada proyek ini berarti pengguna hanya memiliki role `Admin`.
Pengguna dengan role gabungan `Admin` + `Staf` tidak dapat menghapus data.
Selain role tersebut, permission `hapus mahasiswa` juga wajib dimiliki.

Semua spesifikasi wajib dan challenge tersedia:

- Layout backoffice mewarisi `@extends('adminlte::page')`.
- Login, logout, registrasi, reset password, dan verifikasi email memakai
  controller serta `LoginRequest` dari scaffolding Blade resmi Laravel Breeze.
  View autentikasi disesuaikan dengan Bootstrap AdminLTE.
- Role dan permission tersimpan di tabel fisik Spatie, bukan kolom role hardcoded
  di tabel `users`.
- Widget menggunakan `Mahasiswa::count()`, `ProgramStudi::count()`, dan `User::count()`.
- Middleware `permission:` memeriksa setiap aksi controller.
- Penghapusan diperiksa kembali di server dan tombolnya dirender bersyarat di Blade.
- Pencarian nama/NRP/email serta filter prodi/status menggunakan `when()`.
- Pagination menggunakan `withQueryString()` untuk mempertahankan seluruh filter.
- Faker menyiapkan 60 mahasiswa pada 4 program studi saat instalasi lokal.
- Tombol login instan memudahkan perbandingan akses Admin dan Staf.

## Urutan membaca kode

| Urutan | File                                                            | Yang dipelajari                                                      |
| ------ | --------------------------------------------------------------- | -------------------------------------------------------------------- |
| 1      | `routes/web.php` dan `routes/auth.php`                          | URL, grup `auth`/`verified`, route resource, dan endpoint Breeze     |
| 2      | `bootstrap/app.php`                                             | Pendaftaran alias middleware `permission`                            |
| 3      | `database/seeders/RolePermissionSeeder.php`                     | Daftar permission dan perbedaan hak Admin/Staf                       |
| 4      | `app/Models/User.php`                                           | Trait `HasRoles` dan kontrak `MustVerifyEmail`                       |
| 5      | `app/Http/Controllers/DashboardController.php`                  | Tiga kueri `count()` untuk statistik                                 |
| 6      | `app/Http/Controllers/MahasiswaController.php`                  | Middleware per aksi, CRUD, pencarian, pagination, dan pengaman hapus |
| 7      | `app/Http/Requests/MahasiswaRequest.php`                        | Validasi data yang dipakai bersama oleh tambah/ubah                  |
| 8      | `app/Models/Mahasiswa.php` dan `ProgramStudi.php`               | Relasi `belongsTo` / `hasMany` dan kolom yang boleh diisi            |
| 9      | `resources/views/layouts/admin.blade.php`                       | Layout AdminLTE, notifikasi, dan identitas role                      |
| 10     | `resources/views/admin/mahasiswa/`                              | Form bersama, tabel, filter, `@can`, dan tombol hapus bersyarat      |
| 11     | `database/factories/` dan `database/seeders/AcademicSeeder.php` | Pembuatan data dummy realistis                                       |
| 12     | `app/Http/Controllers/Auth/DemoLoginController.php`             | Login demo dengan daftar akun tertutup dan pengunci environment      |

Nama variabel mengikuti domain (`mahasiswa`, `programStudi`, `angkatan`), sedangkan
method resource mengikuti konvensi Laravel (`index`, `create`, `store`, `edit`,
`update`, `destroy`). Komentar menjelaskan bagian yang penting untuk tugas.

## Memahami pengaman akses

Misalnya Staf mengirim `DELETE /admin/mahasiswa/1` secara langsung:

1. Middleware `auth` memastikan pengguna sudah login lewat Breeze.
2. Middleware `verified` memastikan email sudah terverifikasi.
3. Middleware controller `permission:hapus mahasiswa` memeriksa permission di database.
4. Method `destroy()` memastikan pengguna memiliki **hanya** role `Admin`.
5. Jika semua lolos, barulah `$mahasiswa->delete()` dijalankan.

Blade memakai syarat yang sama untuk tombol **Hapus Data**. Menyembunyikan tombol
hanya mengatur tampilan; middleware dan pemeriksaan controller melindungi datanya.

Laravel 13 memakai interface `HasMiddleware` dan method statis `middleware()`
sebagai padanan modern constructor middleware pada contoh Laravel lama.
Pengaman manual di `destroy()` juga memenuhi persyaratan otorisasi server-side.

Role-permission dapat diubah melalui API Spatie; perubahan tersimpan di database.
Contoh di `php artisan tinker` untuk mencabut hak tambah Staf:

```php
$staf = Spatie\Permission\Models\Role::findByName('Staf', 'web');
$staf->revokePermissionTo('tambah mahasiswa');
```

Tombol tambah akan hilang dan request tambah akan ditolak. Untuk mengembalikannya:

```php
$staf->givePermissionTo('tambah mahasiswa');
```

Seeder role menggunakan `syncPermissions()`: menjalankannya ulang akan
mengembalikan konfigurasi permission ke definisi tugas.

## Memahami pencarian dan pagination

Di `MahasiswaController::index()`:

```php
->when($search !== '', function (Builder $query) use ($search) {
    $query->where(function (Builder $query) use ($search) {
        $query->where('nama', 'like', '%'.$search.'%')
            ->orWhere('nrp', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%');
    });
})
->paginate(10)
->withQueryString();
```

`when()` menerapkan pencarian hanya jika kata kunci terisi. Kondisi OR dikelompokkan
supaya tidak mengabaikan filter program studi/status. Nilai pencarian menjadi
parameter kueri melalui Eloquent. `withQueryString()` membawa parameter seperti
`?search=Andi&status=Aktif` ke link halaman berikutnya.

## Seeder dan pengujian

```bash
php artisan db:seed
php artisan test
composer lint:check
composer types:check
npm run check
npm run types:check
npm run build
```

Seeder boleh diulang: akun dan prodi tidak digandakan; setiap prodi yang belum
memiliki mahasiswa diisi 15 data Faker. Data yang sudah ada tidak dihapus.

Feature test mencakup autentikasi Breeze, verifikasi email, statistik, CRUD,
validasi, akses tanpa permission, penolakan hapus oleh Staf, role gabungan,
pencarian/pagination, seeder berulang, dan pengunci login demo di production.
Database pengujian memakai SQLite in-memory sehingga data lokal tidak berubah.

`deploy.sh` memublikasikan aset AdminLTE dan menjalankan seeder role pada deployment.
Seeder tersebut tidak membuat akun demo atau data Faker di production. Akun Admin
production perlu disiapkan sendiri oleh pengelola aplikasi.

## Referensi

- [Laravel Breeze — scaffolding autentikasi](https://github.com/laravel/breeze)
- [Laravel-AdminLTE — dokumentasi paket](https://jeroennoten.github.io/Laravel-AdminLTE/)
- [Spatie Laravel Permission — kompatibilitas dan prasyarat](https://spatie.be/docs/laravel-permission/v7/prerequisites)


# Screenshots

/login

<img width="1855" height="1050" alt="image" src="https://github.com/user-attachments/assets/e80a2aba-6276-42bd-a750-d3686d2b50a9" />

/dashboard

<img width="1855" height="1050" alt="image" src="https://github.com/user-attachments/assets/142baaea-900a-49ce-8af9-a497aa697173" />

/admin/mahasiswa

<img width="1855" height="1050" alt="image" src="https://github.com/user-attachments/assets/9670ddb1-cef0-4edb-8183-c2cb3f738378" />

/admin/mahasiswa/create (dan bisa CRUD lain seperti di gambar sebelumnya)

<img width="1855" height="1050" alt="image" src="https://github.com/user-attachments/assets/522ab593-bc0a-4271-9a8a-353bb39d70b9" />


