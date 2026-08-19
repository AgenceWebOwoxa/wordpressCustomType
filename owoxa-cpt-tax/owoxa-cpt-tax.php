<?php
/**
 * Plugin Name:       Owoxa CPT & Taxonomies
 * Plugin URI:        https://owoxa.com
 * Description:       Plugin léger pour enregistrer des Custom Post Types et des Taxonomies. Réalisé en Vibe Coding avec Grok.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Agence Web Owoxa
 * Author URI:        https://owoxa.com
 * License:           CC0 1.0 Universal
 * License URI:       https://creativecommons.org/publicdomain/zero/1.0/
 * Text Domain:       owoxa-cpt-tax
 * Domain Path:       /languages
 *
 * @package Owoxa_CPT_Tax
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Constantes du plugin
 */
define( 'OWOXA_CPT_TAX_VERSION', '1.0.0' );
define( 'OWOXA_CPT_TAX_FILE', __FILE__ );
define( 'OWOXA_CPT_TAX_PATH', plugin_dir_path( __FILE__ ) );
define( 'OWOXA_CPT_TAX_URL', plugin_dir_url( __FILE__ ) );
define( 'OWOXA_CPT_TAX_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Chargement des classes
 */
require_once OWOXA_CPT_TAX_PATH . 'includes/class-cpt.php';
require_once OWOXA_CPT_TAX_PATH . 'includes/class-taxonomies.php';

/**
 * Initialisation du plugin
 */
function owoxa_cpt_tax_init() {
	// Enregistrement des Custom Post Types
	Owoxa_CPT::register();

	// Enregistrement des Taxonomies
	Owoxa_Taxonomies::register();
}
add_action( 'init', 'owoxa_cpt_tax_init' );

/**
 * Activation du plugin
 */
function owoxa_cpt_tax_activate() {
	// On force l'enregistrement des CPT/Tax pour flush les rewrite rules
	owoxa_cpt_tax_init();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'owoxa_cpt_tax_activate' );

/**
 * Désactivation du plugin
 */
function owoxa_cpt_tax_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'owoxa_cpt_tax_deactivate' );
