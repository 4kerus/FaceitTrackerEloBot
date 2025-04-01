setup: up
	docker compose exec php bash -c "composer install && cp .env.example .env && php artisan key:generate && php artisan migrate && npm install && exit"

up:
	docker compose up -d --build

down:
	docker compose down
