# Extract backup archive
$backupZip = Read-Host "Enter the path to your backup ZIP file"
$extractPath = "wordpress-restore-temp"
Expand-Archive -Path $backupZip -DestinationPath $extractPath -Force

# Get the backup directory name (it's the only directory in the extract path)
$backupDir = Get-ChildItem -Path $extractPath -Directory | Select-Object -First 1 -ExpandProperty FullName

# Copy configuration files
Copy-Item "$backupDir/docker-compose.yml" ./ -Force
Copy-Item "$backupDir/mysql-custom.cnf" ./ -Force -ErrorAction SilentlyContinue
Copy-Item "$backupDir/php.ini" ./ -Force -ErrorAction SilentlyContinue
Copy-Item "$backupDir/.env" ./ -Force -ErrorAction SilentlyContinue

# Extract wp-content backup
Expand-Archive -Path "$backupDir/wp-content.zip" -DestinationPath ./ -Force

# Stop any running containers
docker-compose down -v

# Create volumes if they don't exist
docker volume create novequip_db_data
docker volume create novequip_wp_data

# Get current directory path and convert to Docker-compatible path
$currentPath = (Get-Location).Path
$dockerPath = $currentPath -replace '\\', '/' -replace '^([A-Za-z]):', '//$1'

# Restore volume data
docker run --rm -v novequip_db_data:/target -v "${dockerPath}/$backupDir:/backup" alpine sh -c "tar -xzf /backup/db_data.tar.gz -C /target"
docker run --rm -v novequip_wp_data:/target -v "${dockerPath}/$backupDir:/backup" alpine sh -c "tar -xzf /backup/wp_data.tar.gz -C /target"

# Start containers
docker-compose up -d

# Cleanup
Remove-Item -Recurse -Force $extractPath

Write-Host "WordPress restoration completed successfully!"
