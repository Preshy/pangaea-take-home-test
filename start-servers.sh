# Start publisher server
echo "Publisher and Subscriber server running on port 8000 and 9000"
cd publisher-server && php -S localhost:8000 -t public &> /dev/null &
cd subscribing-server && php -S localhost:9000 -t public &> /dev/null
