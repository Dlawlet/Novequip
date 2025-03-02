# WordPress E-commerce Site with Docker

This is a Docker-based WordPress development environment with WooCommerce support.

## Services
- WordPress (http://localhost:8000)
- phpMyAdmin (http://localhost:8080)
- MySQL 8.0

## Quick Start

1. Start the environment:
```bash
docker compose up -d
```

2. Access WordPress:
   - Open http://localhost:8000
   - Complete the WordPress installation
   - Install and activate WooCommerce plugin

3. Database Management:
   - Access phpMyAdmin at http://localhost:8080
   - Username: wordpress
   - Password: wordpress

## Default Credentials

### WordPress Database
- Database: wordpress
- Username: wordpress
- Password: wordpress

### MySQL Root
- Password: somewordpress

## Stopping the Environment
```bash
docker compose down
```

To completely remove all data (including database):
```bash
docker compose down -v
```

## File Structure
- `wp-content/`: WordPress themes, plugins, and uploads
- `docker-compose.yml`: Docker services configuration

## Notes
- WordPress site data persists in the `wp_data` volume
- Database data persists in the `db_data` volume
- Local `wp-content` directory is mounted to preserve themes and plugins
