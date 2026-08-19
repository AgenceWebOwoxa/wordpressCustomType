<?php
/**
 * Enregistrement dynamique des Taxonomies
 *
 * @package Owoxa_CPT_Tax
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe Owoxa_Taxonomies
 */
class Owoxa_Taxonomies {

	/**
	 * Enregistre toutes les Taxonomies stockées
	 *
	 * @return void
	 */
	public static function register() {
		$taxes = Owoxa_Storage::get_taxonomies();

		if ( empty( $taxes ) ) {
			return;
		}

		foreach ( $taxes as $slug => $data ) {
			self::register_single( $slug, $data );
		}
	}

	/**
	 * Enregistre une seule Taxonomie
	 *
	 * @param string $slug
	 * @param array  $data
	 * @return void
	 */
	private static function register_single( $slug, $data ) {

		$singular = isset( $data['singular'] ) ? $data['singular'] : ucfirst( $slug );
		$plural   = isset( $data['plural'] ) ? $data['plural'] : $singular . 's';

		$labels = array(
			'name'                       => $plural,
			'singular_name'              => $singular,
			'search_items'               => sprintf( __( 'Rechercher des %s', 'owoxa-cpt-tax' ), $plural ),
			'all_items'                  => sprintf( __( 'Tous les %s', 'owoxa-cpt-tax' ), $plural ),
			'parent_item'                => sprintf( __( 'Parent %s', 'owoxa-cpt-tax' ), $singular ),
			'parent_item_colon'          => sprintf( __( 'Parent %s :', 'owoxa-cpt-tax' ), $singular ),
			'edit_item'                  => sprintf( __( 'Modifier %s', 'owoxa-cpt-tax' ), $singular ),
			'update_item'                => sprintf( __( 'Mettre à jour %s', 'owoxa-cpt-tax' ), $singular ),
			'add_new_item'               => sprintf( __( 'Ajouter un %s', 'owoxa-cpt-tax' ), $singular ),
			'new_item_name'              => sprintf( __( 'Nouveau nom de %s', 'owoxa-cpt-tax' ), $singular ),
			'menu_name'                  => $plural,
		);

		$object_type = isset( $data['object_type'] ) && is_array( $data['object_type'] ) ? $data['object_type'] : array();

		$args = array(
			'hierarchical'      => isset( $data['hierarchical'] ) ? (bool) $data['hierarchical'] : true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $slug ),
			'show_in_rest'      => true,
		);

		register_taxonomy( $slug, $object_type, $args );
	}
}
