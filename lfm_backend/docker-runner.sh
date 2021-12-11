docker-compose pull
docker-compose build
docker-compose up -d --remove-orphans
docker exec lfm_laravel composer install
docker exec lfm_laravel php artisan migrate