#!/bin/bash

echo "Setting up VS Code/Cursor IDE for Laravel Blade development..."

# Check if code command is available (VS Code or Cursor)
if command -v code &> /dev/null; then
    echo "Installing recommended extensions..."
    
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
    
    echo "Extensions installed successfully!"
    echo ""
    echo "Please restart your IDE for the changes to take effect."
    echo "Blade files should now have proper syntax highlighting."
else
    echo "VS Code/Cursor 'code' command not found."
    echo "Please install the extensions manually from the VS Code marketplace:"
    echo ""
    echo "Required extensions:"
    echo "- Laravel Blade Snippets (onecentlin.laravel-blade)"
    echo "- Laravel 5 Snippets (onecentlin.laravel5-snippets)"
    echo "- Laravel Extension Pack (onecentlin.laravel-extension-pack)"
    echo "- PHP Intelephense (bmewburn.vscode-intelephense-client)"
    echo "- PHP DocBlocker (neilbrayfield.php-docblocker)"
    echo "- Tailwind CSS IntelliSense (bradlc.vscode-tailwindcss)"
    echo "- Prettier (esbenp.prettier-vscode)"
fi 