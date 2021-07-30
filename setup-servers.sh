# Start publisher server
cd publisher-server && composer install && php artisan key:generate &
cd subscribing-server && composer install && php artisan key:generate
echo "Publisher and Subscriber server setup complete."