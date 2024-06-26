<?php
// Sécurité de base pour empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Ajouter la metabox pour le champ masterPartner
function exposant_add_meta_boxes() {
    add_meta_box(
        'exposant_meta_box', // ID de la metabox
        'Informations sur l\'Exposant', // Titre
        'exposant_meta_box_callback', // Fonction de rappel
        'exposants', // Écran sur lequel afficher la metabox
        'normal', // Contexte
        'high' // Priorité
    );
}
add_action('add_meta_boxes', 'exposant_add_meta_boxes');

// Rendu de la metabox
function exposant_meta_box_callback($post) {
    // Ajouter un nonce pour la vérification plus tard
    wp_nonce_field('exposant_save_meta_box_data', 'exposant_meta_box_nonce');

    // Récupérer la valeur actuelle du champ
    $value = get_post_meta($post->ID, '_exposant_master_partner', true);

    echo '<label for="exposant_master_partner">';
    echo 'Partenaire principal';
    echo '</label> ';
    echo '<input type="checkbox" id="exposant_master_partner" name="exposant_master_partner" value="1" ' . checked($value, '1', false) . ' />';
}

// Sauvegarder les données de la metabox
function exposant_save_meta_box_data($post_id) {
    // Vérifier le nonce pour s'assurer qu'il est valide.
    if (!isset($_POST['exposant_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['exposant_meta_box_nonce'], 'exposant_save_meta_box_data')) {
        return;
    }

    // Vérifier si l'utilisateur a la permission de sauvegarder.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Ne pas enregistrer les données lors d'un autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Vérifier que les données soient définies.
    if (!isset($_POST['exposant_master_partner'])) {
        return;
    }

    // Assainir les données utilisateur.
    $my_data = sanitize_text_field($_POST['exposant_master_partner']);

    // Mettre à jour les métadonnées du post.
    update_post_meta($post_id, '_exposant_master_partner', $my_data);
}
add_action('save_post', 'exposant_save_meta_box_data');
