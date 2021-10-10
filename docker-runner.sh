docker-compose pull
docker-compose build
docker-compose up -d --remove-orphans
composer install
php artisan migrate
php artisan keys:generate