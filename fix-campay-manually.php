<?php
/**
 * Code pour corriger manuellement le plugin CamPay
 * 
 * Copiez ce bloc de code au début de la classe WC_CamPay_Gateway
 * dans le fichier wp-content/plugins/campay-api/campay-api.php
 */

class WC_CamPay_Gateway extends WC_Payment_Gateway {
    // Déclarations des propriétés pour éviter les avertissements de dépréciation
    public $testmode;
    public $dollar_activated;
    public $card_activated;
    public $euro_activated;
    public $usd_xaf;
    public $euro_xaf;
    public $version;
    public $campay_username;
    public $campay_password;
    public $debugging;
    public $title;
    public $description;
    public $live_url;
    public $test_url;
    
    // Le reste de la classe reste inchangé...
}
?>
