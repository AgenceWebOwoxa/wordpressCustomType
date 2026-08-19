<?php
/**
 * Classe d'enregistrement des Custom Post Types
 *
 * @package Owoxa_CPT_Tax
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe Owoxa_CPT
 */
class Owoxa_CPT {

	/**
	 * Enregistre tous les Custom Post Types
	 *
	 * @return void
	 */
	public static function register() {

		/**
		 * Exemple de Custom Post Type (à adapter / supprimer selon besoin)
		 *
		 * Pour ajouter un nouveau CPT, dupliquer le bloc register_post_type ci-dessous.
		 */

		/*
		$labels = array(
			'name'                  => _x( 'Items', 'Post type general name', 'owoxa-cpt-tax' ),
			'singular_name'         => _x( 'Item', 'Post type singular name', 'owoxa-cpt-tax' ),
			'menu_name'             => _x( 'Items', 'Admin Menu text', 'owoxa-cpt-tax' ),
			'name_admin_bar'        => _x( 'Item', 'Add New on Toolbar', 'owoxa-cpt-tax' ),
			'add_new'               => __( 'Add New', 'owoxa-cpt-tax' ),
			'add_new_item'          => __( 'Add New Item', 'owoxa-cpt-tax' ),
			'new_item'              => __( 'New Item', 'owoxa-cpt-tax' ),
			'edit_item'             => __( 'Edit Item', 'owoxa-cpt-tax' ),
			'view_item'             => __( 'View Item', 'owoxa-cpt-tax' ),
			'all_items'             => __( 'All Items', 'owoxa-cpt-tax' ),
			'search_items'          => __( 'Search Items', 'owoxa-cpt-tax' ),
			'parent_item_colon'     => __( 'Parent Items:', 'owoxa-cpt-tax' ),
			'not_found'             => __( 'No items found.', 'owoxa-cpt-tax' ),
			'not_found_in_trash'    => __( 'No items found in Trash.', 'owoxa-cpt-tax' ),
			'featured_image'        => _x( 'Item Cover Image', 'Overrides the “Featured Image” phrase', 'owoxa-cpt-tax' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase', 'owoxa-cpt-tax' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase', 'owoxa-cpt-tax' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase', 'owoxa-cpt-tax' ),
			'archives'              => _x( 'Item archives', 'The post type archive label', 'owoxa-cpt-tax' ),
			'insert_into_item'      => _x( 'Insert into item', 'Overrides the “Insert into post” phrase', 'owoxa-cpt-tax' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this item', 'Overrides the “Uploaded to this post” phrase', 'owoxa-cpt-tax' ),
			'filter_items_list'     => _x( 'Filter items list', 'Screen reader text', 'owoxa-cpt-tax' ),
			'items_list_navigation' => _x( 'Items list navigation', 'Screen reader text', 'owoxa-cpt-tax' ),
			'items_list'            => _x( 'Items list', 'Screen reader text', 'owoxa-cpt-tax' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'item' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'menu_icon'          => 'dashicons-admin-post',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			'show_in_rest'       => true, // Gutenberg + API REST
		);

		register_post_type( 'owoxa_item', $args );
		*/

		// Aucun CPT enregistré pour l'instant.
		// Ajoutez vos register_post_type() ici.
	}
}
