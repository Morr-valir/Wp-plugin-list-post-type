<?php
// Sécurité de base pour empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Fonction pour enregistrer le custom post type
function exposant_register_post_type() {
    $labels = array(
        'name'                  => _x('Exposants', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Exposant', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Exposants', 'text_domain'),
        'all_items'             => __('Tous les exposants', 'text_domain'),
        'add_new'               => __('Ajouter un nouveau', 'text_domain'),
        'add_new_item'          => __('Ajouter un nouvel exposant', 'text_domain'),
        'edit_item'             => __('Éditer l\'exposant', 'text_domain'),
        'new_item'              => __('Nouvel exposant', 'text_domain'),
        'view_item'             => __('Voir l\'exposant', 'text_domain'),
        'view_items'            => __('Voir les exposants', 'text_domain'),
        'search_items'          => __('Rechercher des exposants', 'text_domain'),
        'not_found'             => __('Aucun exposant trouvé', 'text_domain'),
        'not_found_in_trash'    => __('Aucun exposant trouvé dans la corbeille', 'text_domain'),
        'parent_item_colon'     => __('Exposant parent', 'text_domain'),
        'featured_image'        => __('Image à la une', 'text_domain'),
        'set_featured_image'    => __('Définir l\'image à la une', 'text_domain'),
        'remove_featured_image' => __('Supprimer l\'image à la une', 'text_domain'),
        'use_featured_image'    => __('Utiliser comme image à la une', 'text_domain'),
        'archives'              => __('Archives des exposants', 'text_domain'),
        'insert_into_item'      => __('Insérer dans l\'exposant', 'text_domain'),
        'uploaded_to_this_item' => __('Téléversé dans cet exposant', 'text_domain'),
        'filter_items_list'     => __('Filtrer la liste des exposants', 'text_domain'),
        'items_list_navigation' => __('Navigation de la liste des exposants', 'text_domain'),
        'items_list'            => __('Liste des exposants', 'text_domain'),
        'attributes'            => __('Attributs des exposants', 'text_domain'),
        'name_admin_bar'        => __('Exposant', 'text_domain'),
        'item_published'        => __('Exposant publié', 'text_domain'),
        'item_published_privately' => __('Exposant publié en privé', 'text_domain'),
        'item_reverted_to_draft' => __('Exposant retourné en brouillon', 'text_domain'),
        'item_scheduled'        => __('Exposant planifié', 'text_domain'),
        'item_updated'          => __('Exposant mis à jour', 'text_domain'),
    );

    $args = array(
        'label'                 => __('Exposant', 'text_domain'),
        'description'           => __('Post Type pour les exposants', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 28,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => false,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug' => '',
            'with_front' => true
        ),
        'query_var'             => true,
    );
    register_post_type('exposants', $args);
}

// Hook dans l'action init
add_action('init', 'exposant_register_post_type');
