#!/bin/bash
# Script pour corriger directement les avertissements de dépréciation du plugin CamPay
# Ce script utilise une approche différente et plus directe

echo "Correction des avertissements de dépréciation du plugin CamPay..."

# Vérifier si le fichier du plugin existe
if [ ! -f "wp-content/plugins/campay-api/campay-api.php" ]; then
    echo "ERREUR: Plugin CamPay non trouvé. Veuillez vérifier qu'il est installé."
    exit 1
fi

# Créer une sauvegarde
BACKUP_FILE="wp-content/plugins/campay-api/campay-api.php.backup-$(date +%Y%m%d)"
cp wp-content/plugins/campay-api/campay-api.php "$BACKUP_FILE"
echo "Sauvegarde créée: $BACKUP_FILE"

# Vérifier si les propriétés sont déjà déclarées
if grep -q "public \$testmode;" wp-content/plugins/campay-api/campay-api.php; then
    echo "Les propriétés sont déjà déclarées. Aucune modification nécessaire."
    exit 0
fi

# Ajouter les déclarations de propriétés après la définition de classe
TEMP_FILE=$(mktemp)
awk '
    /class WC_CamPay_Gateway extends WC_Payment_Gateway/ {
        print $0;
        print "";
        print "    // Déclarations des propriétés pour éviter les avertissements de dépréciation";
        print "    public $testmode;";
        print "    public $dollar_activated;";
        print "    public $card_activated;";
        print "    public $euro_activated;";
        print "    public $usd_xaf;";
        print "    public $euro_xaf;";
        print "    public $version;";
        print "    public $campay_username;";
        print "    public $campay_password;";
        print "    public $debugging;";
        print "    public $title;";
        print "    public $description;";
        print "    public $live_url;";
        print "    public $test_url;";
        print "";
        next;
    }
    { print $0; }
' wp-content/plugins/campay-api/campay-api.php > "$TEMP_FILE"

# Remplacer le fichier original par la version modifiée
mv "$TEMP_FILE" wp-content/plugins/campay-api/campay-api.php

echo "SUCCÈS: Le plugin CamPay a été corrigé!"
echo "Les avertissements de dépréciation ne devraient plus apparaître."
echo ""
echo "Instructions :"
echo "1. Rafraîchissez votre site WordPress"
echo "2. Les avertissements devraient maintenant être résolus"
echo "3. Si vous rencontrez des problèmes, la sauvegarde est disponible à: $BACKUP_FILE"
