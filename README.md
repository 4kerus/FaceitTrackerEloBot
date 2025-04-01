<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Docker Laravel Starter Kit
- Laravel v12.x
- PHP v8.4.x
- MySQL v8.1.x
- Node.js v22.x
- NPM v11.x
- Yarn v1.x
- Vite v6.x
- irazasyed/telegram-bot-sdk v3.15

# Requirements
- Stable version of [Docker](https://docs.docker.com/engine/install/)
- Compatible version of [Docker Compose](https://docs.docker.com/compose/install/#install-compose)
- Stable version of [GNU Make](https://www.gnu.org/software/make/) (optional)

# How To Deploy

### For first time
- Clone this repository
- `make setup`

### run ngrok and change .env:
- `APP_URL`
- `TELEGRAM_BOT_TOKEN`

### From the second time onwards
- `make up`

### Set webhook
- `php artisan telegram:webhook --setup`

### For stopping
- `make down`

### Laravel App
- URL: http://localhost

### Basic docker compose commands
- Build or rebuild services
    - `docker compose build`
- Create and start containers
    - `docker compose up -d`
- Stop and remove containers, networks
    - `docker compose down`
- Stop all services
    - `docker compose stop`
- Restart service containers
    - `docker compose restart`
- Run a command inside a container
    - `docker compose exec [container] [command]`

### Useful Laravel Commands
- Display basic information about your application
    - `php artisan about`
- Remove the configuration cache file
    - `php artisan config:clear`
- Flush the application cache
    - `php artisan cache:clear`
- Clear all cached events and listeners
    - `php artisan event:clear`
- Delete all the jobs from the specified queue
    - `php artisan queue:clear`
- Remove the route cache file
    - `php artisan route:clear`
- Clear all compiled view files
    - `php artisan view:clear`
- Remove the compiled class file
    - `php artisan clear-compiled`
- Remove the cached bootstrap files
    - `php artisan optimize:clear`
- Delete the cached mutex files created by scheduler
    - `php artisan schedule:clear-cache`
- Flush expired password reset tokens
    - `php artisan auth:clear-resets`
