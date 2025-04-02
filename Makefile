setup: up
	docker compose exec php bash -c "composer install && cp .env.example .env && php artisan key:generate && npm install && php artisan migrate && exit"

up:
	docker compose up -d --build

down:
	docker compose down
