1.composer Update
2.bikin db di pgsql
3.insert .env file dari internet. jgn lupa ganti isi engnya yg DB_DATABASE, DB_USERNAME(biasanya "postgres"), DB_PASSWORD, DB_PORT, DB_CONNECTION
should be like this
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=52221
    DB_DATABASE=inventory
    DB_USERNAME=postgres
    DB_PASSWORD=
4.php artisan migrate:fresh --seed
5.php artisan storage:link
6.bikin folder baru di storage\app\public (yg bawah), incomingItemImage, itemImages, OutgoingItemImage
7.php artisan key:generate
8.php artisan serve

buat ngakses server intan, pake aplikasi tableplus
    DB_CONNECTION=pgsql
    DB_HOST=192.168.9.26
    DB_PORT=5432
    DB_DATABASE=list_wms
    DB_USERNAME=postgres
    DB_PASSWORD=intan1122
