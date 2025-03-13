<?php
/**
 * Patch for CamPay API Plugin to Fix Deprecation Warnings
 * 
 * This direct patch modifies the CamPay plugin file to properly declare 
 * all properties and eliminate PHP 8.2+ deprecation warnings.
 */

// Path to the plugin file
$plugin_file = __DIR__ . '/wp-content/plugins/campay-api/campay-api.php';
$backup_file = __DIR__ . '/wp-content/plugins/campay-api/campay-api.php.bak-' . date('Y-m-d');

// Check if the plugin file exists
if (!file_exists($plugin_file)) {
    echo "ERROR: Le fichier du plugin CamPay n'a pas été trouvé à: $plugin_file\n";
    echo "Veuillez vérifier que le plugin est installé.\n";
    exit(1);
}

// Create a backup of the original file
if (!file_exists($backup_file)) {
    if (copy($plugin_file, $backup_file)) {
        echo "Une sauvegarde du fichier original a été créée: $backup_file\n";
    } else {
        echo "AVERTISSEMENT: Impossible de créer une sauvegarde du fichier.\n";
    }
}

// Read the original plugin code
$code = file_get_contents($plugin_file);
if ($code === false) {
    echo "ERROR: Impossible de lire le fichier du plugin.\n";
    exit(1);
}

// Define the class pattern
$class_pattern = '/class\s+WC_CamPay_Gateway\s+extends\s+WC_Payment_Gateway\s*\{/';

// Define the property declarations to add
$property_declarations = "\n    // Declarations des propriétés pour éviter les avertissements de dépréciation
    public \$testmode;
    public \$dollar_activated;
    public \$card_activated;
    public \$euro_activated;
    public \$usd_xaf;
    public \$euro_xaf;
    public \$version;
    public \$campay_username;
    public \$campay_password;
    public \$debugging;
    public \$title;
    public \$description;
    public \$live_url;
    public \$test_url;\n";

// Check if the properties are already declared (in case this script ran before)
if (strpos($code, 'public $testmode;') !== false) {
    echo "Les propriétés sont déjà déclarées dans le plugin. Aucune modification nécessaire.\n";
    exit(0);
}

// Replace the class definition with the class definition + property declarations
if (preg_match($class_pattern, $code)) {
    $modified_code = preg_replace($class_pattern, '$0' . $property_declarations, $code, 1);
    
    // Write the modified code back to the file
    if (file_put_contents($plugin_file, $modified_code)) {
        echo "SUCCÈS: Le plugin CamPay a été corrigé avec succès!\n";
        echo "Les avertissements de dépréciation ne devraient plus apparaître.\n";
    } else {
        echo "ERROR: Impossible d'écrire les modifications dans le fichier du plugin.\n";
        echo "Veuillez vérifier les permissions.\n";
    }
} else {
    echo "ERROR: Impossible de trouver la définition de la classe WC_CamPay_Gateway dans le fichier.\n";
    echo "Le fichier du plugin peut avoir une structure différente de celle attendue.\n";
}

echo "\nInstructions :\n";
echo "1. Rafraîchissez votre site WordPress\n";
echo "2. Les avertissements de dépréciation devraient maintenant être résolus\n";
echo "3. Si vous rencontrez des problèmes, la sauvegarde est disponible à: $backup_file\n";
?>
