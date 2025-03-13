# Stop containers
docker-compose down

# Create backup directory
$backupDir = "wordpress-backup-$(Get-Date -Format 'yyyyMMdd')"
New-Item -Path $backupDir -ItemType Directory -Force

# Get current directory path and convert to Docker-compatible path
$currentPath = (Get-Location).Path
$dockerPath = $currentPath -replace '\\', '/' -replace '^([A-Za-z]):', '//$1'

# Backup docker volumes
docker run --rm -v novequip_db_data:/source -v "${dockerPath}/${backupDir}:/backup" alpine tar -czf /backup/db_data.tar.gz -C /source .
docker run --rm -v novequip_wp_data:/source -v "${dockerPath}/${backupDir}:/backup" alpine tar -czf /backup/wp_data.tar.gz -C /source .

# Backup wp-content directory (for customizations)
Compress-Archive -Path "wp-content" -DestinationPath "$backupDir/wp-content.zip" -Force

# Backup docker-compose and configuration files
Copy-Item docker-compose.yml $backupDir/
Copy-Item mysql-custom.cnf $backupDir/ -ErrorAction SilentlyContinue
Copy-Item php.ini $backupDir/ -ErrorAction SilentlyContinue
Copy-Item .env $backupDir/ -ErrorAction SilentlyContinue

# Create final backup archive
Compress-Archive -Path $backupDir -DestinationPath "wordpress-backup-$(Get-Date -Format 'yyyyMMdd').zip" -Force

# Cleanup
Remove-Item -Recurse -Force $backupDir

# Restart containers
docker-compose up -d

Write-Host "Backup completed: wordpress-backup-$(Get-Date -Format 'yyyyMMdd').zip"
