# HOMIQIO API

Backend API for the HOMIQIO application, built with Laravel 12, PHP 8.4, and Docker.

## 🚀 Quick Start

### Prerequisites

- Docker Desktop installed and running
- No other services running on ports 8000, 3307, 6379, or 8081

### Essential Docker Commands

```bash
# Start Docker containers
docker compose up -d

# Stop Docker containers
docker compose down

# View container status
docker ps

# View logs (follow mode)
docker compose logs -f

# View logs for specific service
docker compose logs -f app

# Rebuild containers (use after Dockerfile changes)
docker compose build --no-cache && docker compose up -d

# Run migrations
docker exec homiqio-app php artisan migrate

# Clear caches
docker exec homiqio-app php artisan optimize:clear
```

### First-Time Setup

```bash
# Clone the repository
git clone https://github.com/Handsome072/ap-homiqio.git
cd ap-homiqio

# Start the Docker containers
docker compose up -d

# Run database migrations
docker exec homiqio-app php artisan migrate
```

---

## 🔗 Access URLs

| Service | URL | Description |
|---------|-----|-------------|
| **Laravel API** | http://localhost:8000 | Main API endpoint |
| **API Health Check** | http://localhost:8000/api/health | Health check endpoint |
| **phpMyAdmin** | http://localhost:8081 | Database management UI |
| **MySQL** | localhost:3307 | Database connection (external) |
| **Redis** | localhost:6379 | Cache/Queue connection |

---

## 🗄️ Database Credentials

| Setting | Value |
|---------|-------|
| **Host** | `mysql` (inside Docker) / `localhost` (external) |
| **Port** | `3306` (inside Docker) / `3307` (external) |
| **Database** | `homiqio` |
| **Username** | `sail` |
| **Password** | `password` |

### Connecting from External Tools (e.g., TablePlus, DBeaver)

```
Host: 127.0.0.1
Port: 3307
Database: homiqio
Username: sail
Password: password
```

---

## 📋 Common Commands

### Artisan Commands

```bash
# Run migrations
docker exec homiqio-app php artisan migrate

# Fresh migration (drops all tables)
docker exec homiqio-app php artisan migrate:fresh

# Seed the database
docker exec homiqio-app php artisan db:seed

# Create a new controller
docker exec homiqio-app php artisan make:controller Api/ExampleController

# Create a new model with migration
docker exec homiqio-app php artisan make:model Example -m

# Clear all caches
docker exec homiqio-app php artisan optimize:clear
```

### Composer Commands

```bash
# Install dependencies
docker exec homiqio-app composer install

# Update dependencies
docker exec homiqio-app composer update

# Add a package
docker exec homiqio-app composer require package/name
```

### Access Container Shell

```bash
# Open a bash shell inside the container
docker exec -it homiqio-app bash
```

---

## 🔧 Troubleshooting

### Permission Issues

If you encounter permission errors with storage or cache directories:

```bash
# Fix storage permissions inside the container
docker exec homiqio-app chmod -R 775 storage bootstrap/cache
docker exec homiqio-app chown -R www-data:www-data storage bootstrap/cache
```

### Port Already in Use

If ports are already in use, edit `docker-compose.yml` and change the port mappings:

```yaml
ports:
  - "8001:80"   # Change 8000 to 8001 for Laravel
```

Then restart containers:

```bash
docker compose down
docker compose up -d
```

### Docker Containers Not Starting

```bash
# Check container status
docker ps -a

# View all logs
docker compose logs

# View logs for specific service
docker compose logs app
docker compose logs mysql
```

### Database Connection Issues

1. Ensure MySQL container is healthy:
   ```bash
   docker ps
   ```
   Look for `(healthy)` status next to `homiqio-mysql`

2. Wait for MySQL to be ready (may take 30-60 seconds on first start)

3. Check database exists:
   ```bash
   docker exec homiqio-mysql mysql -u sail -ppassword -e "SHOW DATABASES;"
   ```

### Clear All Caches

```bash
docker exec homiqio-app php artisan optimize:clear
docker exec homiqio-app php artisan config:clear
docker exec homiqio-app php artisan cache:clear
docker exec homiqio-app php artisan route:clear
docker exec homiqio-app php artisan view:clear
```

---

## 📁 Project Structure

```
api-homiqio/
├── app/                 # Application code
│   ├── Http/
│   │   ├── Controllers/ # API Controllers
│   │   └── Middleware/  # HTTP Middleware
│   └── Models/          # Eloquent Models
├── bootstrap/           # Framework bootstrap files
├── config/              # Configuration files
├── database/
│   ├── migrations/      # Database migrations
│   └── seeders/         # Database seeders
├── docker/              # Docker configuration files
│   ├── nginx.conf       # Nginx server configuration
│   └── supervisord.conf # Supervisor process manager config
├── routes/
│   ├── api.php          # API routes
│   └── web.php          # Web routes
├── storage/             # Logs, cache, uploads
├── tests/               # Test files
├── Dockerfile           # Docker image definition
├── docker-compose.yml   # Docker Compose orchestration
├── .env                 # Environment configuration
└── .env.example         # Environment template
```

---

## 🔐 Frontend Integration

This API is configured to accept requests from the HOMIQIO frontend (Next.js) running at `http://localhost:3000`.

CORS is configured in `config/cors.php`. To change the allowed frontend URL, update the `.env` file:

```env
FRONTEND_URL=http://localhost:3000
```

---

## � Docker Services

| Container | Image | Purpose |
|-----------|-------|---------|
| `homiqio-app` | PHP 8.4-fpm + Nginx | Laravel application |
| `homiqio-mysql` | MySQL 8.0 | Database server |
| `homiqio-redis` | Redis Alpine | Cache & queue |
| `homiqio-phpmyadmin` | phpMyAdmin | Database UI |

## 📚 Documentation

- [Laravel 12 Documentation](https://laravel.com/docs)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Laravel API Resources](https://laravel.com/docs/eloquent-resources)
