HAL YANG HARUS DILAKUKAN SEBELUM NGERUN PROGRAM INI

Di folder php.ini (bisa diakses dari xampp terus php config, ato ngga cari di windows start menu aja)
hapus tanda baca ini ; dari extensions berikut, zip, gd, pdo_pgsql, pgsql
tujuannya biar kodenya ngerun
sama cari "memory_limit" dan set ke 1024 karena image resizing mayan berat

penjelasan:
zip = buat unzip data pas ngejalanin composer Update
gd = buat salah satu library dari composer Update
pdo_pgsql dan pgsql = buat bisa jalan di database postgresql

kalo udah ngelakuin hal diatas, lakuin ini pas buka file buat konfigurasi
1.composer Update (penting soalnya kalo download dari github, file vendor tidak diupload ke github)
2.bikin db di pgsql (cukup namanya aja)
3.di folder ini harusnya ada file bernama ".env.example", hapus ".example" dari nama filenya agar menjadi ".env"
4. ganti isi envnya yg DB_DATABASE, DB_USERNAME(biasanya "postgres"), DB_PASSWORD, DB_PORT, DB_CONNECTION
should be like this
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=52221
    DB_DATABASE=inventory
    DB_USERNAME=postgres
    DB_PASSWORD=

Lalu, jalankan kode berikut:
4.php artisan migrate:fresh --seed (untuk membuat data di tabel. ini kenapa harus buat database dengan namanya dulu di langkah ke 2)
5.php artisan storage:link (untuk bisa mengupload dan mendownload gambar)
6.bikin folder baru di storage\app\public (yg bawah), incomingItemImage, itemImages, OutgoingItemImage
7.php artisan key:generate
8.php artisan serve

sebenernya diatas(commant 4-8) bisa dimasukin ke batch file, tinggal masukin commandnya aja di batch file
command 4-7 hanya harus dijalankan sekali.
command 8 itu untuk menjalankan aplikasi

buat ngakses server intan, pake aplikasi tableplus, contoh:
    DB_CONNECTION=pgsql////
    DB_HOST=192.168.9.226////
    DB_PORT=5432////x
    DB_DATABASE=list_wms////
    DB_USERNAME=postgres////
    DB_PASSWORD=intan1122////
