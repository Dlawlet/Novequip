# Simple WordPress Restore Script
# This script restores a WordPress site from a backup created by backup-wordpress-simple.ps1

# Ask for the backup file
$backupZip = Read-Host "Enter the path to your backup ZIP file (e.g., wordpress-backup-20250313.zip)"
$extractPath = "wp-restore-temp"

# Create temp directory and extract backup
Write-Host "Extracting backup archive..." -ForegroundColor Cyan
New-Item -Path $extractPath -ItemType Directory -Force -ErrorAction SilentlyContinue
Expand-Archive -Path $backupZip -DestinationPath $extractPath -Force

# Get the backup directory name (it's the only directory in the extract path)
$backupDir = Get-ChildItem -Path $extractPath -Directory | Select-Object -First 1 -ExpandProperty FullName

# 1. Copy configuration files
Write-Host "Restoring configuration files..." -ForegroundColor Cyan
if (Test-Path "$backupDir\docker-compose.yml") {
    Copy-Item "$backupDir\docker-compose.yml" ./ -Force
    Write-Host "  - docker-compose.yml restored" -ForegroundColor Green
}
if (Test-Path "$backupDir\php.ini") {
    Copy-Item "$backupDir\php.ini" ./ -Force
    Write-Host "  - php.ini restored" -ForegroundColor Green
}
if (Test-Path "$backupDir\mysql-custom.cnf") {
    Copy-Item "$backupDir\mysql-custom.cnf" ./ -Force
    Write-Host "  - mysql-custom.cnf restored" -ForegroundColor Green
}

# 2. Restore uploads directory
Write-Host "Restoring uploads directory..." -ForegroundColor Cyan
if (Test-Path "$backupDir\uploads.zip") {
    # Make sure the uploads directory exists
    New-Item -Path "wp-content\uploads" -ItemType Directory -Force -ErrorAction SilentlyContinue
    
    # Extract the uploads zip
    Expand-Archive -Path "$backupDir\uploads.zip" -DestinationPath "wp-content" -Force
    Write-Host "Uploads directory restored!" -ForegroundColor Green
} else {
    Write-Host "Uploads backup not found in archive!" -ForegroundColor Yellow
}

# 3. Start containers if they're not running
Write-Host "Starting Docker containers..." -ForegroundColor Cyan
docker-compose up -d
Start-Sleep -Seconds 10  # Give containers time to start

# 4. Restore database
Write-Host "Restoring database..." -ForegroundColor Cyan
if (Test-Path "$backupDir\database.sql") {
    # Use docker-compose exec to restore the database
    Get-Content "$backupDir\database.sql" | docker-compose exec -T database mysql -u wordpress -pwordpress wordpress
    Write-Host "Database restored successfully!" -ForegroundColor Green
} else {
    Write-Host "Database backup not found in archive!" -ForegroundColor Red
}

# 5. Clean up
Remove-Item -Recurse -Force $extractPath

Write-Host "WordPress restoration completed!" -ForegroundColor Green
Write-Host "Your site should now be accessible at http://localhost:8080" -ForegroundColor Green
Write-Host "phpMyAdmin is available at http://localhost:8081" -ForegroundColor Green
