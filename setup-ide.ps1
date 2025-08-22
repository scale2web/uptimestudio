Write-Host "Setting up VS Code/Cursor IDE for Laravel Blade development..." -ForegroundColor Green

# Check if code command is available (VS Code or Cursor)
try {
    $codePath = Get-Command code -ErrorAction Stop
    Write-Host "Found code command at: $($codePath.Source)" -ForegroundColor Yellow
    
    Write-Host "Installing recommended extensions..." -ForegroundColor Yellow
    
    # Laravel Blade extension
    code --install-extension onecentlin.laravel-blade
    
    # Laravel snippets
    code --install-extension onecentlin.laravel5-snippets
    
    # Laravel extension pack
    code --install-extension onecentlin.laravel-extension-pack
    
    # PHP IntelliSense
    code --install-extension bmewburn.vscode-intelephense-client
    
    # PHP DocBlocker
    code --install-extension neilbrayfield.php-docblocker
    
    # Tailwind CSS IntelliSense
    code --install-extension bradlc.vscode-tailwindcss
    
    # Prettier
    code --install-extension esbenp.prettier-vscode
    
    Write-Host "Extensions installed successfully!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Please restart your IDE for the changes to take effect." -ForegroundColor Yellow
    Write-Host "Blade files should now have proper syntax highlighting." -ForegroundColor Yellow
    
} catch {
    Write-Host "VS Code/Cursor 'code' command not found." -ForegroundColor Red
    Write-Host "Please install the extensions manually from the VS Code marketplace:" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Required extensions:" -ForegroundColor Cyan
    Write-Host "- Laravel Blade Snippets (onecentlin.laravel-blade)" -ForegroundColor White
    Write-Host "- Laravel 5 Snippets (onecentlin.laravel5-snippets)" -ForegroundColor White
    Write-Host "- Laravel Extension Pack (onecentlin.laravel-extension-pack)" -ForegroundColor White
    Write-Host "- PHP Intelephense (bmewburn.vscode-intelephense-client)" -ForegroundColor White
    Write-Host "- PHP DocBlocker (neilbrayfield.php-docblocker)" -ForegroundColor White
    Write-Host "- Tailwind CSS IntelliSense (bradlc.vscode-tailwindcss)" -ForegroundColor White
    Write-Host "- Prettier (esbenp.prettier-vscode)" -ForegroundColor White
} 