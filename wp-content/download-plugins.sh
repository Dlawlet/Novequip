#!/bin/bash

# Download Redis Cache plugin
wget https://downloads.wordpress.org/plugin/redis-cache.2.4.0.zip -O /tmp/redis-cache.zip
unzip /tmp/redis-cache.zip -d /var/www/html/wp-content/plugins/
rm /tmp/redis-cache.zip

# Download Query Monitor (helpful for debugging performance)
wget https://downloads.wordpress.org/plugin/query-monitor.3.13.0.zip -O /tmp/query-monitor.zip
unzip /tmp/query-monitor.zip -d /var/www/html/wp-content/plugins/
rm /tmp/query-monitor.zip

# Download WP Super Cache
wget https://downloads.wordpress.org/plugin/wp-super-cache.1.9.4.zip -O /tmp/wp-super-cache.zip
unzip /tmp/wp-super-cache.zip -d /var/www/html/wp-content/plugins/
rm /tmp/wp-super-cache.zip

# Set correct permissions
chown -R www-data:www-data /var/www/html/wp-content/plugins/
