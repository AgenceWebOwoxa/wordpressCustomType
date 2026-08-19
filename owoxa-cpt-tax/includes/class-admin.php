<?php
/**
 * Page d’administration (liste + formulaires)
 *
 * @package Owoxa_CPT_Tax
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe Owoxa_Admin
 */
class Owoxa_Admin {

	/**
	 * Initialise l'administration
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'handle_actions' ) );
	}

	/**
	 * Ajoute le menu d'administration
	 */
	public static function add_menu() {
		add_menu_page(
			__( 'Owoxa CPT & Tax', 'owoxa-cpt-tax' ),
			__( 'Owoxa CPT & Tax', 'owoxa-cpt-tax' ),
			'manage_options',
			'owoxa-cpt-tax',
			array( __CLASS__, 'render_page' ),
			'dashicons-admin-generic',
			58
		);
	}

	/**
	 * Gère les actions (ajout / modification / suppression)
	 */
	public static function handle_actions() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Suppression CPT
		if ( isset( $_GET['action'], $_GET['slug'], $_GET['_wpnonce'] ) && $_GET['action'] === 'delete_cpt' ) {
			if ( wp_verify_nonce( $_GET['_wpnonce'], 'owoxa_delete_cpt_' . $_GET['slug'] ) ) {
				Owoxa_Storage::delete_post_type( sanitize_key( $_GET['slug'] ) );
				flush_rewrite_rules();
				wp_safe_redirect( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=cpt&deleted=1' ) );
				exit;
			}
		}

		// Suppression Taxonomie
		if ( isset( $_GET['action'], $_GET['slug'], $_GET['_wpnonce'] ) && $_GET['action'] === 'delete_tax' ) {
			if ( wp_verify_nonce( $_GET['_wpnonce'], 'owoxa_delete_tax_' . $_GET['slug'] ) ) {
				Owoxa_Storage::delete_taxonomy( sanitize_key( $_GET['slug'] ) );
				flush_rewrite_rules();
				wp_safe_redirect( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=tax&deleted=1' ) );
				exit;
			}
		}

		// Sauvegarde CPT
		if ( isset( $_POST['owoxa_save_cpt'] ) && check_admin_referer( 'owoxa_save_cpt' ) ) {
			$slug = sanitize_key( $_POST['slug'] );

			if ( empty( $slug ) ) {
				wp_safe_redirect( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=cpt&error=slug' ) );
				exit;
			}

			$data = array(
				'singular'     => sanitize_text_field( $_POST['singular'] ),
				'plural'       => sanitize_text_field( $_POST['plural'] ),
				'public'       => isset( $_POST['public'] ) ? 1 : 0,
				'has_archive'  => isset( $_POST['has_archive'] ) ? 1 : 0,
				'hierarchical' => isset( $_POST['hierarchical'] ) ? 1 : 0,
				'menu_icon'    => sanitize_text_field( $_POST['menu_icon'] ),
				'supports'     => isset( $_POST['supports'] ) && is_array( $_POST['supports'] ) ? array_map( 'sanitize_key', $_POST['supports'] ) : array( 'title', 'editor' ),
			);

			Owoxa_Storage::save_post_type( $slug, $data );
			flush_rewrite_rules();

			wp_safe_redirect( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=cpt&saved=1' ) );
			exit;
		}

		// Sauvegarde Taxonomie
		if ( isset( $_POST['owoxa_save_tax'] ) && check_admin_referer( 'owoxa_save_tax' ) ) {
			$slug = sanitize_key( $_POST['slug'] );

			if ( empty( $slug ) ) {
				wp_safe_redirect( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=tax&error=slug' ) );
				exit;
			}

			$data = array(
				'singular'     => sanitize_text_field( $_POST['singular'] ),
				'plural'       => sanitize_text_field( $_POST['plural'] ),
				'hierarchical' => isset( $_POST['hierarchical'] ) ? 1 : 0,
				'object_type'  => isset( $_POST['object_type'] ) && is_array( $_POST['object_type'] ) ? array_map( 'sanitize_key', $_POST['object_type'] ) : array(),
			);

			Owoxa_Storage::save_taxonomy( $slug, $data );
			flush_rewrite_rules();

			wp_safe_redirect( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=tax&saved=1' ) );
			exit;
		}
	}

	/**
	 * Affiche la page d'administration
	 */
	public static function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'cpt';

		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'Owoxa CPT & Taxonomies', 'owoxa-cpt-tax' ) . '</h1>';

		// Notices
		if ( isset( $_GET['saved'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Enregistré avec succès.', 'owoxa-cpt-tax' ) . '</p></div>';
		}
		if ( isset( $_GET['deleted'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Supprimé avec succès.', 'owoxa-cpt-tax' ) . '</p></div>';
		}
		if ( isset( $_GET['error'] ) && $_GET['error'] === 'slug' ) {
			echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'Le slug est obligatoire.', 'owoxa-cpt-tax' ) . '</p></div>';
		}

		// Onglets
		echo '<h2 class="nav-tab-wrapper">';
		printf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			esc_url( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=cpt' ) ),
			$tab === 'cpt' ? 'nav-tab-active' : '',
			esc_html__( 'Custom Post Types', 'owoxa-cpt-tax' )
		);
		printf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			esc_url( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=tax' ) ),
			$tab === 'tax' ? 'nav-tab-active' : '',
			esc_html__( 'Taxonomies', 'owoxa-cpt-tax' )
		);
		echo '</h2>';

		if ( $tab === 'tax' ) {
			self::render_taxonomies_tab();
		} else {
			self::render_cpt_tab();
		}

		echo '</div>';
	}

	/**
	 * Onglet Custom Post Types
	 */
	private static function render_cpt_tab() {
		$cpts = Owoxa_Storage::get_post_types();
		$edit_slug = isset( $_GET['edit'] ) ? sanitize_key( $_GET['edit'] ) : '';
		$edit_data = $edit_slug ? Owoxa_Storage::get_post_type( $edit_slug ) : null;

		// Liste
		echo '<h2>' . esc_html__( 'Liste des Custom Post Types', 'owoxa-cpt-tax' ) . '</h2>';

		if ( empty( $cpts ) ) {
			echo '<p>' . esc_html__( 'Aucun Custom Post Type pour le moment.', 'owoxa-cpt-tax' ) . '</p>';
		} else {
			echo '<table class="wp-list-table widefat fixed striped">';
			echo '<thead><tr>';
			echo '<th>' . esc_html__( 'Slug', 'owoxa-cpt-tax' ) . '</th>';
			echo '<th>' . esc_html__( 'Singulier', 'owoxa-cpt-tax' ) . '</th>';
			echo '<th>' . esc_html__( 'Pluriel', 'owoxa-cpt-tax' ) . '</th>';
			echo '<th>' . esc_html__( 'Actions', 'owoxa-cpt-tax' ) . '</th>';
			echo '</tr></thead><tbody>';

			foreach ( $cpts as $slug => $data ) {
				echo '<tr>';
				echo '<td><code>' . esc_html( $slug ) . '</code></td>';
				echo '<td>' . esc_html( $data['singular'] ) . '</td>';
				echo '<td>' . esc_html( $data['plural'] ) . '</td>';
				echo '<td>';
				printf(
					'<a href="%s">%s</a> | ',
					esc_url( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=cpt&edit=' . $slug ) ),
					esc_html__( 'Modifier', 'owoxa-cpt-tax' )
				);
				printf(
					'<a href="%s" onclick="return confirm(\'%s\');">%s</a>',
					wp_nonce_url( admin_url( 'admin.php?page=owoxa-cpt-tax&action=delete_cpt&slug=' . $slug ), 'owoxa_delete_cpt_' . $slug ),
					esc_js( __( 'Confirmer la suppression ?', 'owoxa-cpt-tax' ) ),
					esc_html__( 'Supprimer', 'owoxa-cpt-tax' )
				);
				echo '</td>';
				echo '</tr>';
			}

			echo '</tbody></table>';
		}

		// Formulaire
		echo '<h2>' . ( $edit_data ? esc_html__( 'Modifier le Custom Post Type', 'owoxa-cpt-tax' ) : esc_html__( 'Ajouter un Custom Post Type', 'owoxa-cpt-tax' ) ) . '</h2>';

		echo '<form method="post">';
		wp_nonce_field( 'owoxa_save_cpt' );

		echo '<table class="form-table">';

		// Slug
		echo '<tr>';
		echo '<th><label for="slug">' . esc_html__( 'Slug', 'owoxa-cpt-tax' ) . '</label></th>';
		echo '<td><input type="text" name="slug" id="slug" value="' . esc_attr( $edit_slug ) . '" class="regular-text" ' . ( $edit_data ? 'readonly' : 'required' ) . '>';
		echo '<p class="description">' . esc_html__( 'Identifiant unique (minuscules, tirets autorisés). Non modifiable après création.', 'owoxa-cpt-tax' ) . '</p></td>';
		echo '</tr>';

		// Singulier
		echo '<tr>';
		echo '<th><label for="singular">' . esc_html__( 'Nom singulier', 'owoxa-cpt-tax' ) . '</label></th>';
		echo '<td><input type="text" name="singular" id="singular" value="' . esc_attr( $edit_data['singular'] ?? '' ) . '" class="regular-text" required></td>';
		echo '</tr>';

		// Pluriel
		echo '<tr>';
		echo '<th><label for="plural">' . esc_html__( 'Nom pluriel', 'owoxa-cpt-tax' ) . '</label></th>';
		echo '<td><input type="text" name="plural" id="plural" value="' . esc_attr( $edit_data['plural'] ?? '' ) . '" class="regular-text" required></td>';
		echo '</tr>';

		// Public
		echo '<tr>';
		echo '<th>' . esc_html__( 'Public', 'owoxa-cpt-tax' ) . '</th>';
		echo '<td><label><input type="checkbox" name="public" value="1" ' . checked( $edit_data['public'] ?? 1, 1, false ) . '> ' . esc_html__( 'Oui', 'owoxa-cpt-tax' ) . '</label></td>';
		echo '</tr>';

		// Archive
		echo '<tr>';
		echo '<th>' . esc_html__( 'Archive', 'owoxa-cpt-tax' ) . '</th>';
		echo '<td><label><input type="checkbox" name="has_archive" value="1" ' . checked( $edit_data['has_archive'] ?? 1, 1, false ) . '> ' . esc_html__( 'Activer l’archive', 'owoxa-cpt-tax' ) . '</label></td>';
		echo '</tr>';

		// Hiérarchique
		echo '<tr>';
		echo '<th>' . esc_html__( 'Hiérarchique', 'owoxa-cpt-tax' ) . '</th>';
		echo '<td><label><input type="checkbox" name="hierarchical" value="1" ' . checked( $edit_data['hierarchical'] ?? 0, 1, false ) . '> ' . esc_html__( 'Comme les pages', 'owoxa-cpt-tax' ) . '</label></td>';
		echo '</tr>';

		// Icône
		echo '<tr>';
		echo '<th><label for="menu_icon">' . esc_html__( 'Icône du menu', 'owoxa-cpt-tax' ) . '</label></th>';
		echo '<td><input type="text" name="menu_icon" id="menu_icon" value="' . esc_attr( $edit_data['menu_icon'] ?? 'dashicons-admin-post' ) . '" class="regular-text">';
		echo '<p class="description">' . esc_html__( 'Classe Dashicons (ex: dashicons-portfolio)', 'owoxa-cpt-tax' ) . '</p></td>';
		echo '</tr>';

		// Supports
		$current_supports = $edit_data['supports'] ?? array( 'title', 'editor' );
		$all_supports = array(
			'title'           => 'Titre',
			'editor'          => 'Éditeur',
			'thumbnail'       => 'Image à la une',
			'excerpt'         => 'Extrait',
			'custom-fields'   => 'Champs personnalisés',
			'revisions'       => 'Révisions',
			'page-attributes' => 'Attributs de page',
		);

		echo '<tr>';
		echo '<th>' . esc_html__( 'Supports', 'owoxa-cpt-tax' ) . '</th>';
		echo '<td>';
		foreach ( $all_supports as $key => $label ) {
			printf(
				'<label style="display:block;margin-bottom:4px;"><input type="checkbox" name="supports[]" value="%s" %s> %s</label>',
				esc_attr( $key ),
				checked( in_array( $key, $current_supports, true ), true, false ),
				esc_html( $label )
			);
		}
		echo '</td>';
		echo '</tr>';

		echo '</table>';

		submit_button( $edit_data ? __( 'Mettre à jour', 'owoxa-cpt-tax' ) : __( 'Ajouter le Custom Post Type', 'owoxa-cpt-tax' ), 'primary', 'owoxa_save_cpt' );

		if ( $edit_data ) {
			echo ' <a href="' . esc_url( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=cpt' ) ) . '" class="button">' . esc_html__( 'Annuler', 'owoxa-cpt-tax' ) . '</a>';
		}

		echo '</form>';
	}

	/**
	 * Onglet Taxonomies
	 */
	private static function render_taxonomies_tab() {
		$taxes = Owoxa_Storage::get_taxonomies();
		$cpts  = Owoxa_Storage::get_post_types();
		$edit_slug = isset( $_GET['edit'] ) ? sanitize_key( $_GET['edit'] ) : '';
		$edit_data = $edit_slug ? Owoxa_Storage::get_taxonomy( $edit_slug ) : null;

		// Liste
		echo '<h2>' . esc_html__( 'Liste des Taxonomies', 'owoxa-cpt-tax' ) . '</h2>';

		if ( empty( $taxes ) ) {
			echo '<p>' . esc_html__( 'Aucune taxonomie pour le moment.', 'owoxa-cpt-tax' ) . '</p>';
		} else {
			echo '<table class="wp-list-table widefat fixed striped">';
			echo '<thead><tr>';
			echo '<th>' . esc_html__( 'Slug', 'owoxa-cpt-tax' ) . '</th>';
			echo '<th>' . esc_html__( 'Singulier', 'owoxa-cpt-tax' ) . '</th>';
			echo '<th>' . esc_html__( 'Pluriel', 'owoxa-cpt-tax' ) . '</th>';
			echo '<th>' . esc_html__( 'Liée à', 'owoxa-cpt-tax' ) . '</th>';
			echo '<th>' . esc_html__( 'Actions', 'owoxa-cpt-tax' ) . '</th>';
			echo '</tr></thead><tbody>';

			foreach ( $taxes as $slug => $data ) {
				$linked = isset( $data['object_type'] ) ? implode( ', ', $data['object_type'] ) : '—';
				echo '<tr>';
				echo '<td><code>' . esc_html( $slug ) . '</code></td>';
				echo '<td>' . esc_html( $data['singular'] ) . '</td>';
				echo '<td>' . esc_html( $data['plural'] ) . '</td>';
				echo '<td>' . esc_html( $linked ) . '</td>';
				echo '<td>';
				printf(
					'<a href="%s">%s</a> | ',
					esc_url( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=tax&edit=' . $slug ) ),
					esc_html__( 'Modifier', 'owoxa-cpt-tax' )
				);
				printf(
					'<a href="%s" onclick="return confirm(\'%s\');">%s</a>',
					wp_nonce_url( admin_url( 'admin.php?page=owoxa-cpt-tax&action=delete_tax&slug=' . $slug ), 'owoxa_delete_tax_' . $slug ),
					esc_js( __( 'Confirmer la suppression ?', 'owoxa-cpt-tax' ) ),
					esc_html__( 'Supprimer', 'owoxa-cpt-tax' )
				);
				echo '</td>';
				echo '</tr>';
			}

			echo '</tbody></table>';
		}

		// Formulaire
		echo '<h2>' . ( $edit_data ? esc_html__( 'Modifier la Taxonomie', 'owoxa-cpt-tax' ) : esc_html__( 'Ajouter une Taxonomie', 'owoxa-cpt-tax' ) ) . '</h2>';

		echo '<form method="post">';
		wp_nonce_field( 'owoxa_save_tax' );

		echo '<table class="form-table">';

		// Slug
		echo '<tr>';
		echo '<th><label for="slug">' . esc_html__( 'Slug', 'owoxa-cpt-tax' ) . '</label></th>';
		echo '<td><input type="text" name="slug" id="slug" value="' . esc_attr( $edit_slug ) . '" class="regular-text" ' . ( $edit_data ? 'readonly' : 'required' ) . '>';
		echo '<p class="description">' . esc_html__( 'Identifiant unique (minuscules, tirets autorisés). Non modifiable après création.', 'owoxa-cpt-tax' ) . '</p></td>';
		echo '</tr>';

		// Singulier
		echo '<tr>';
		echo '<th><label for="singular">' . esc_html__( 'Nom singulier', 'owoxa-cpt-tax' ) . '</label></th>';
		echo '<td><input type="text" name="singular" id="singular" value="' . esc_attr( $edit_data['singular'] ?? '' ) . '" class="regular-text" required></td>';
		echo '</tr>';

		// Pluriel
		echo '<tr>';
		echo '<th><label for="plural">' . esc_html__( 'Nom pluriel', 'owoxa-cpt-tax' ) . '</label></th>';
		echo '<td><input type="text" name="plural" id="plural" value="' . esc_attr( $edit_data['plural'] ?? '' ) . '" class="regular-text" required></td>';
		echo '</tr>';

		// Hiérarchique
		echo '<tr>';
		echo '<th>' . esc_html__( 'Hiérarchique', 'owoxa-cpt-tax' ) . '</th>';
		echo '<td><label><input type="checkbox" name="hierarchical" value="1" ' . checked( $edit_data['hierarchical'] ?? 1, 1, false ) . '> ' . esc_html__( 'Comme les catégories (sinon comme les étiquettes)', 'owoxa-cpt-tax' ) . '</label></td>';
		echo '</tr>';

		// Object types (CPT liés)
		echo '<tr>';
		echo '<th>' . esc_html__( 'Lier aux Custom Post Types', 'owoxa-cpt-tax' ) . '</th>';
		echo '<td>';
		if ( empty( $cpts ) ) {
			echo '<p>' . esc_html__( 'Aucun CPT disponible. Créez d’abord un Custom Post Type.', 'owoxa-cpt-tax' ) . '</p>';
		} else {
			$current_types = $edit_data['object_type'] ?? array();
			foreach ( $cpts as $cpt_slug => $cpt_data ) {
				printf(
					'<label style="display:block;margin-bottom:4px;"><input type="checkbox" name="object_type[]" value="%s" %s> %s (%s)</label>',
					esc_attr( $cpt_slug ),
					checked( in_array( $cpt_slug, $current_types, true ), true, false ),
					esc_html( $cpt_data['plural'] ),
					esc_html( $cpt_slug )
				);
			}
		}
		echo '</td>';
		echo '</tr>';

		echo '</table>';

		submit_button( $edit_data ? __( 'Mettre à jour', 'owoxa-cpt-tax' ) : __( 'Ajouter la Taxonomie', 'owoxa-cpt-tax' ), 'primary', 'owoxa_save_tax' );

		if ( $edit_data ) {
			echo ' <a href="' . esc_url( admin_url( 'admin.php?page=owoxa-cpt-tax&tab=tax' ) ) . '" class="button">' . esc_html__( 'Annuler', 'owoxa-cpt-tax' ) . '</a>';
		}

		echo '</form>';
	}
}
