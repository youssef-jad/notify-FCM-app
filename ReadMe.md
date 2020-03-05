Follow up this steps if you want to use docker  : 

1 - create directory db-volume if not exists 
2 - set permission to following 
sudo chmod 777 -R db-volume/*
sudo chmod 777 -R src/*
sudo chmod 777 -R src/notify-app/*

attach your self to web container and run : 
composer install 
cp .env.example .env
php artisan key:generate
-----------------------------

Change / add following to your .env
DB_HOST=db 
DB_DATABASE=notify
DB_USERNAME=root
DB_PASSWORD=123456

FIREBASE_FCM_KEY=Your Key
-------------------------------------
Run Following after you update the .env:

php artisan migrate 
php artisan db:seed


