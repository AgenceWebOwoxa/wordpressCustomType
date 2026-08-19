<?php
/**
 * Enregistrement dynamique des Custom Post Types
 *
 * @package Owoxa_CPT_Tax
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe Owoxa_CPT
 */
class Owoxa_CPT {

	/**
	 * Enregistre tous les Custom Post Types stockés
	 *
	 * @return void
	 */
	public static function register() {
		$cpts = Owoxa_Storage::get_post_types();

		if ( empty( $cpts ) ) {
			return;
		}

		foreach ( $cpts as $slug => $data ) {
			self::register_single( $slug, $data );
		}
	}

	/**
	 * Enregistre un seul Custom Post Type
	 *
	 * @param string $slug
	 * @param array  $data
	 * @return void
	 */
	private static function register_single( $slug, $data ) {

		$singular = isset( $data['singular'] ) ? $data['singular'] : ucfirst( $slug );
		$plural   = isset( $data['plural'] ) ? $data['plural'] : $singular . 's';

		$labels = array(
			'name'                  => $plural,
			'singular_name'         => $singular,
			'menu_name'             => $plural,
			'name_admin_bar'        => $singular,
			'add_new'               => __( 'Ajouter', 'owoxa-cpt-tax' ),
			'add_new_item'          => sprintf( __( 'Ajouter un %s', 'owoxa-cpt-tax' ), $singular ),
			'new_item'              => sprintf( __( 'Nouveau %s', 'owoxa-cpt-tax' ), $singular ),
			'edit_item'             => sprintf( __( 'Modifier %s', 'owoxa-cpt-tax' ), $singular ),
			'view_item'             => sprintf( __( 'Voir %s', 'owoxa-cpt-tax' ), $singular ),
			'all_items'             => sprintf( __( 'Tous les %s', 'owoxa-cpt-tax' ), $plural ),
			'search_items'          => sprintf( __( 'Rechercher des %s', 'owoxa-cpt-tax' ), $plural ),
			'not_found'             => __( 'Aucun élément trouvé.', 'owoxa-cpt-tax' ),
			'not_found_in_trash'    => __( 'Aucun élément trouvé dans la corbeille.', 'owoxa-cpt-tax' ),
		);

		$supports = isset( $data['supports'] ) && is_array( $data['supports'] ) ? $data['supports'] : array( 'title', 'editor' );

		$args = array(
			'labels'             => $labels,
			'public'             => isset( $data['public'] ) ? (bool) $data['public'] : true,
			'publicly_queryable' => isset( $data['public'] ) ? (bool) $data['public'] : true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $slug ),
			'capability_type'    => 'post',
			'has_archive'        => isset( $data['has_archive'] ) ? (bool) $data['has_archive'] : true,
			'hierarchical'       => isset( $data['hierarchical'] ) ? (bool) $data['hierarchical'] : false,
			'menu_position'      => 20,
			'menu_icon'          => isset( $data['menu_icon'] ) && $data['menu_icon'] ? $data['menu_icon'] : 'dashicons-admin-post',
			'supports'           => $supports,
			'show_in_rest'       => true,
		);

		register_post_type( $slug, $args );
	}
}
