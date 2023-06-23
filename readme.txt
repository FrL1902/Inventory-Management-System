1.composer Update
2.bikin db di pgsql
3.insert .env file dari internet. jgn lupa ganti isi engnya yg DB_DATABASE, DB_USERNAME(biasanya "postgres"), DB_PASSWORD, DB_PORT, DB_CONNECTION
4.php artisan migrate:fresh --seed
5.php artisan storage:link
6.bikin folder baru di public storage, incomingItemImage, itemImages, OutgoingItemImage
7.php artisan serve
