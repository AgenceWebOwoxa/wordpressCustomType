<?php
/**
 * Classe d'enregistrement des Taxonomies
 *
 * @package Owoxa_CPT_Tax
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe Owoxa_Taxonomies
 */
class Owoxa_Taxonomies {

	/**
	 * Enregistre toutes les Taxonomies
	 *
	 * @return void
	 */
	public static function register() {

		/**
		 * Exemple de Taxonomie (à adapter / supprimer selon besoin)
		 *
		 * Pour ajouter une nouvelle taxonomie, dupliquer le bloc register_taxonomy ci-dessous.
		 */

		/*
		$labels = array(
			'name'                       => _x( 'Categories', 'taxonomy general name', 'owoxa-cpt-tax' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name', 'owoxa-cpt-tax' ),
			'search_items'               => __( 'Search Categories', 'owoxa-cpt-tax' ),
			'popular_items'              => __( 'Popular Categories', 'owoxa-cpt-tax' ),
			'all_items'                  => __( 'All Categories', 'owoxa-cpt-tax' ),
			'parent_item'                => __( 'Parent Category', 'owoxa-cpt-tax' ),
			'parent_item_colon'          => __( 'Parent Category:', 'owoxa-cpt-tax' ),
			'edit_item'                  => __( 'Edit Category', 'owoxa-cpt-tax' ),
			'update_item'                => __( 'Update Category', 'owoxa-cpt-tax' ),
			'add_new_item'               => __( 'Add New Category', 'owoxa-cpt-tax' ),
			'new_item_name'              => __( 'New Category Name', 'owoxa-cpt-tax' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'owoxa-cpt-tax' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'owoxa-cpt-tax' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'owoxa-cpt-tax' ),
			'not_found'                  => __( 'No categories found.', 'owoxa-cpt-tax' ),
			'menu_name'                  => __( 'Categories', 'owoxa-cpt-tax' ),
		);

		$args = array(
			'hierarchical'          => true,          // true = comme les catégories, false = comme les tags
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'item-category' ),
			'show_in_rest'          => true,          // Gutenberg + API REST
		);

		// Lie la taxonomie au CPT 'owoxa_item' (à adapter)
		register_taxonomy( 'owoxa_item_category', array( 'owoxa_item' ), $args );
		*/

		// Aucune taxonomie enregistrée pour l'instant.
		// Ajoutez vos register_taxonomy() ici.
	}
}
