Подключение в БД

0) Скачиваем проект и переименовуем корневую папку в "diplom".
1) Располагаем на сервере.
2) прописуем sudo chmod -R 777 /opt/lampp/htdocs/diplom.
3) переходми в папку диплом cd /opt/lampp/htdocs/diplom.
4) прописуем composer install.
5) копируем env.example в .env.
6) прописуем php artisan key:generate
7) В phpMyAdmin создаем базу "diplom1" выбираем кодироку 'utf8_general_ci'.
8) прописуем в файле настройки базы .env DB_DATABASE=diplom1, DB_USERNAME=root, DB_PASSWORD=
9) В терменале прописуете  php artisan migrate.
10) В терменале прописуете  php artisan db:seed.
11) Запускаем сервер.
12) Перходим на старновй адресс http://localhost/diplom/public/.


ВАЖНО
1) Папку назвать diplom потому что используются полные пути.
2) При перемотки времени на слейдущюю неделю слейдущую неделю,задачам присваюется статус compited. ПРОБЛЕМА при переходе обратно, статусы заадч не обновляются.(Итог врямя можно мотать только вперед, если перематали назад нужно вносить в ручную изменения в базу). 
