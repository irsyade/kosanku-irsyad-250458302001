1. Website Kosanku adalah Website tentang pencarian kamar atau kosan untuk mahasiswa dan perantau, untuk memudahkan mereka mencari tempat tinggal tanpa harus survei di tempatnya
2. Fitur utama : Menambah data kosan, Detail kamar
3. Laravel (Backend & MVC), Livewire (SPA tanpa JavaScript manual), MySQL (Database), TailwindCSS / Bootstrap (opsional, sesuaikan), Composer, npm/Vite
4. Cara Instalasi Ikuti langkah berikut:
- Clone Repository
git clone https://github.com/username/kosanku.git
cd kosanku

- Install Dependencies Composer
composer install

- Install Dependencies Frontend
npm install

- Copy File Environment
cp .env.example .env

- Generate App Key
php artisan key:generate

- Atur Database di .env

Ubah bagian berikut:

DB_DATABASE=kosanku
DB_USERNAME=root
DB_PASSWORD=

- Migrasi Database
php artisan migrate

- (Optional) Seeder
php artisan db:seed

4. Cara Menjalankan Project :
   
- Jalankan Server Laravel
php artisan serve

- Jalankan Vite (untuk asset frontend)
npm run dev

- Setelah itu buka di browser:

http://127.0.0.1:8000
