# ClAssign - Sistem Manajemen Tugas Kelas

<p align="center">
<img src="public/img/logo.png" width="200" alt="ClAssign Logo">
</p>

ClAssign adalah sistem manajemen tugas kelas berbasis web yang dibangun dengan Laravel. Aplikasi ini memungkinkan guru untuk membuat dan mengelola kelas, materi pembelajaran, serta tugas-tugas, sementara siswa dapat mengakses materi dan mengirimkan tugas mereka.

## 🚀 Fitur Utama

### Untuk Guru (Teacher)

-   **Manajemen Kelas**: Membuat, mengedit, dan menghapus kelas
-   **Manajemen Materi**: Upload dan kelola materi pembelajaran
-   **Manajemen Tugas**: Membuat tugas, mengatur deadline, dan memberikan penilaian
-   **Penilaian**: Menilai dan memberikan feedback pada tugas siswa
-   **Dashboard**: Monitoring aktivitas kelas dan siswa

### Untuk Siswa (Student)

-   **Bergabung dengan Kelas**: Menggunakan kode kelas untuk bergabung
-   **Akses Materi**: Melihat dan mengunduh materi pembelajaran
-   **Pengiriman Tugas**: Upload dan kirim tugas sesuai deadline
-   **Kalender**: Melihat jadwal tugas dan aktivitas kelas
-   **Profil**: Mengelola informasi pribadi

### Fitur Umum

-   **Autentikasi**: Sistem login/register dengan role-based access
-   **Dashboard**: Interface yang user-friendly untuk berbagai role
-   **Kalender**: Integrasi kalender untuk tracking deadline
-   **File Management**: Upload dan download file dengan aman
-   **Responsive Design**: Tampilan yang responsif di berbagai perangkat

## Persyaratan Sistem

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Database (MySQL/PostgreSQL/SQLite)
-   Web Server (Apache/Nginx)

## Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd ClAssignv2
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

Edit file `.env` untuk konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=classign_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
# Run database migrations
php artisan migrate

# (Optional) Run seeders for sample data
php artisan db:seed
```

### 6. Build Assets

```bash
# Build frontend assets
npm run build

# Or for development
npm run dev
```

### 7. Storage Link

```bash
# Create storage link for file uploads
php artisan storage:link
```

## Menjalankan Aplikasi

### Development Server

```bash
# Start Laravel development server
php artisan serve

# Start Vite development server (in another terminal)
npm run dev
```

Akses aplikasi di: `http://localhost:8000`

### Production

Untuk production, pastikan web server sudah dikonfigurasi dengan benar dan arahkan document root ke folder `public/`.

## Struktur Proyek

```
ClAssign/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories
├── public/
│   ├── img/                # Images
│   └── storage/            # Public storage link
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # CSS files
│   └── js/                 # JavaScript files
├── routes/
│   └── web.php             # Web routes
└── storage/
    ├── app/                # Private storage
    └── logs/               # Application logs
```

## 🛤️ Struktur Routes

### Authentication Routes

```php
GET  /login                 # Halaman login
POST /login                 # Proses login
GET  /register              # Halaman register
POST /register              # Proses register
POST /logout                # Logout
```

### Public Routes

```php
GET  /                      # Welcome page
```

### Protected Routes (Authenticated Users)

```php
GET  /dashboard             # Dashboard utama
GET  /profile               # Halaman profil
PUT  /profile               # Update profil
GET  /calendar              # Kalender
```

### Student Routes

```php
GET  /join-class            # Halaman bergabung kelas
POST /join-class            # Proses bergabung kelas
POST /assignments/{id}/submit # Submit tugas
```

### Teacher Routes

```php
# Class Management
GET  /classes/create        # Form buat kelas
POST /classes               # Simpan kelas baru
GET  /classes/{id}/edit     # Form edit kelas
PUT  /classes/{id}          # Update kelas
DELETE /classes/{id}        # Hapus kelas

# Material Management
GET  /materials/create      # Form buat materi
POST /materials             # Simpan materi baru
GET  /materials/{id}/edit   # Form edit materi
PUT  /materials/{id}        # Update materi
DELETE /materials/{id}      # Hapus materi

# Assignment Management
GET  /assignments/create    # Form buat tugas
POST /assignments           # Simpan tugas baru
GET  /assignments/{id}/edit # Form edit tugas
PUT  /assignments/{id}      # Update tugas
DELETE /assignments/{id}    # Hapus tugas
PUT  /assignments/{id}/grade/{submission_id} # Nilai tugas
```

### Shared Routes (Teacher & Student)

```php
GET  /classes               # Daftar kelas
GET  /classes/{id}          # Detail kelas
GET  /classes/{id}/materials # Daftar materi kelas
GET  /materials/{id}        # Detail materi
GET  /materials/{id}/download # Download materi
GET  /classes/{id}/assignments # Daftar tugas kelas
GET  /assignments/{id}      # Detail tugas
GET  /submissions/{id}/download # Download submission
```

## Role & Permission

### Teacher

-   Dapat membuat dan mengelola kelas
-   Dapat membuat dan mengelola materi pembelajaran
-   Dapat membuat dan mengelola tugas
-   Dapat memberikan penilaian pada tugas siswa
-   Dapat melihat semua aktivitas siswa

### Student

-   Dapat bergabung dengan kelas menggunakan kode kelas
-   Dapat melihat materi pembelajaran
-   Dapat mengunduh materi pembelajaran
-   Dapat mengirim tugas
-   Dapat melihat nilai dan feedback tugas

## 🔧 Konfigurasi

### File Upload

Konfigurasi file upload dapat diatur di `config/filesystems.php`. Secara default, file disimpan di `storage/app/public/`.

### Mail Configuration

Untuk fitur notifikasi email, konfigurasi mail di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## Testing

```bash
# Run semua tests
php artisan test

# Run specific test
php artisan test --filter TestClassName
```

## License

Aplikasi ini menggunakan lisensi MIT. Silakan lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

## Contributing

Kontribusi selalu welcome! Silakan buat pull request atau laporkan issue jika menemukan bug.

## Support

Jika ada pertanyaan atau butuh bantuan, silakan buat issue di repository ini.
