# Create a simplified WordPress backup script that focuses on the essential parts
# This script backs up the database and uploads directory

# Create backup directory
$timestamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$backupDir = "wp-backup-$timestamp"
New-Item -Path $backupDir -ItemType Directory -Force

Write-Host "Starting WordPress backup..." -ForegroundColor Green

# 1. Export the database using docker-compose
Write-Host "Exporting database..." -ForegroundColor Cyan
docker-compose exec -T database mysqldump -u wordpress -pwordpress wordpress > "$backupDir/database.sql"
if ($LASTEXITCODE -eq 0) {
    Write-Host "Database export successful!" -ForegroundColor Green
} else {
    Write-Host "Database export failed!" -ForegroundColor Red
}

# 2. Backup uploads directory
Write-Host "Backing up uploads directory..." -ForegroundColor Cyan
if (Test-Path "wp-content\uploads") {
    try {
        # Create a zip file of the uploads directory
        Compress-Archive -Path "wp-content\uploads" -DestinationPath "$backupDir\uploads.zip" -Force
        Write-Host "Uploads backup successful!" -ForegroundColor Green
    } catch {
        Write-Host "Error backing up uploads: $_" -ForegroundColor Red
    }
} else {
    Write-Host "Uploads directory not found!" -ForegroundColor Yellow
}

# 3. Backup configuration files
Write-Host "Backing up configuration files..." -ForegroundColor Cyan
Copy-Item "docker-compose.yml" -Destination $backupDir -ErrorAction SilentlyContinue
Copy-Item "php.ini" -Destination $backupDir -ErrorAction SilentlyContinue
Copy-Item "mysql-custom.cnf" -Destination $backupDir -ErrorAction SilentlyContinue

# 4. Create final zip archive
Write-Host "Creating final backup archive..." -ForegroundColor Cyan
$finalBackupName = "wordpress-backup-$timestamp.zip"
Compress-Archive -Path $backupDir -DestinationPath $finalBackupName -Force

# 5. Clean up
Remove-Item -Recurse -Force $backupDir

Write-Host "Backup completed successfully: $finalBackupName" -ForegroundColor Green
Write-Host "Transfer this file to your new computer and use the restore script to restore your WordPress site."
