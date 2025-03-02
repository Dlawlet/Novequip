# WordPress E-commerce Site with Docker

This is a Docker-based WordPress development environment with WooCommerce support for the NovEquip e-commerce store.

## Services
- WordPress (http://localhost:8000)
- phpMyAdmin (http://localhost:8080)
- MySQL 8.0
- Redis (for object caching)

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
- `php.ini`: Custom PHP configuration
- `mysql-custom.cnf`: Custom MySQL configuration
- `sample-products.csv`: Sample product data for import
- `setup-attributes.php`: WooCommerce attribute setup script
- `download-product-images.sh`: Script to download sample product images
- `novequip-woocommerce-extensions/`: Custom WooCommerce extensions plugin

## Setting Up E-commerce Features

### 1. Import Sample Products
After activating WooCommerce:
1. Go to WooCommerce > Products > Import
2. Upload the `sample-products.csv` file
3. Follow the import wizard

### 2. Set Up Product Attributes
1. Copy `setup-attributes.php` to your WordPress root directory
2. Run the script from WordPress admin or via WP-CLI:
   ```
   wp eval-file setup-attributes.php
   ```

### 3. Download Product Images
1. Run the download script:
   ```bash
   bash download-product-images.sh
   ```
2. Images will be saved to `wp-content/uploads/product-images/`

### 4. Install Custom WooCommerce Extensions
1. Copy the `novequip-woocommerce-extensions` folder to `wp-content/plugins/`
2. Activate the plugin from WordPress admin
3. Configure settings at WooCommerce > NovEquip Settings

## Performance Optimizations
- Redis object caching enabled
- Enhanced PHP settings (memory limits, OpCache)
- MySQL performance tuning
- WP Super Cache for page caching

## Notes
- WordPress site data persists in the `wp_data` volume
- Database data persists in the `db_data` volume
- Local `wp-content` directory is mounted to preserve themes and plugins
