<?php
/**
 * Gestion du stockage (wp_options)
 *
 * @package Owoxa_CPT_Tax
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe Owoxa_Storage
 */
class Owoxa_Storage {

	const OPTION_CPT = 'owoxa_cpt_tax_post_types';
	const OPTION_TAX = 'owoxa_cpt_tax_taxonomies';

	/**
	 * Récupère tous les Custom Post Types enregistrés
	 *
	 * @return array
	 */
	public static function get_post_types() {
		$cpts = get_option( self::OPTION_CPT, array() );
		return is_array( $cpts ) ? $cpts : array();
	}

	/**
	 * Sauvegarde les Custom Post Types
	 *
	 * @param array $cpts
	 * @return bool
	 */
	public static function save_post_types( $cpts ) {
		return update_option( self::OPTION_CPT, $cpts, false );
	}

	/**
	 * Récupère un CPT par son slug
	 *
	 * @param string $slug
	 * @return array|null
	 */
	public static function get_post_type( $slug ) {
		$cpts = self::get_post_types();
		return isset( $cpts[ $slug ] ) ? $cpts[ $slug ] : null;
	}

	/**
	 * Ajoute ou met à jour un CPT
	 *
	 * @param string $slug
	 * @param array  $data
	 * @return bool
	 */
	public static function save_post_type( $slug, $data ) {
		$cpts          = self::get_post_types();
		$cpts[ $slug ] = $data;
		return self::save_post_types( $cpts );
	}

	/**
	 * Supprime un CPT
	 *
	 * @param string $slug
	 * @return bool
	 */
	public static function delete_post_type( $slug ) {
		$cpts = self::get_post_types();
		if ( isset( $cpts[ $slug ] ) ) {
			unset( $cpts[ $slug ] );
			return self::save_post_types( $cpts );
		}
		return false;
	}

	/**
	 * Récupère toutes les Taxonomies enregistrées
	 *
	 * @return array
	 */
	public static function get_taxonomies() {
		$taxes = get_option( self::OPTION_TAX, array() );
		return is_array( $taxes ) ? $taxes : array();
	}

	/**
	 * Sauvegarde les Taxonomies
	 *
	 * @param array $taxes
	 * @return bool
	 */
	public static function save_taxonomies( $taxes ) {
		return update_option( self::OPTION_TAX, $taxes, false );
	}

	/**
	 * Récupère une taxonomie par son slug
	 *
	 * @param string $slug
	 * @return array|null
	 */
	public static function get_taxonomy( $slug ) {
		$taxes = self::get_taxonomies();
		return isset( $taxes[ $slug ] ) ? $taxes[ $slug ] : null;
	}

	/**
	 * Ajoute ou met à jour une taxonomie
	 *
	 * @param string $slug
	 * @param array  $data
	 * @return bool
	 */
	public static function save_taxonomy( $slug, $data ) {
		$taxes          = self::get_taxonomies();
		$taxes[ $slug ] = $data;
		return self::save_taxonomies( $taxes );
	}

	/**
	 * Supprime une taxonomie
	 *
	 * @param string $slug
	 * @return bool
	 */
	public static function delete_taxonomy( $slug ) {
		$taxes = self::get_taxonomies();
		if ( isset( $taxes[ $slug ] ) ) {
			unset( $taxes[ $slug ] );
			return self::save_taxonomies( $taxes );
		}
		return false;
	}
}
