# Start publisher server
cd publisher-server && composer install && php artisan key:generate && php artisan migrate &
cd subscribing-server && composer install && php artisan key:generate && php artisan migrate
echo "Publisher and Subscriber server setup complete."