<?php
// Sécurité de base pour empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Ajouter une page de menu dans l'admin
function exposant_add_admin_menu() {
    add_menu_page(
        'Options liste Exposants', // Titre de la page
        'Options liste Exposants', // Titre du menu
        'manage_options', // Capacité requise
        'exposant-options', // Slug de la page
        'exposant_options_page', // Fonction de rappel
        'dashicons-admin-generic', // Icône du menu
        29 // Position
    );
}
add_action('admin_menu', 'exposant_add_admin_menu');

// Afficher le contenu de la page des options
function exposant_options_page() {
    ?>
    <div class="wrap">
        <h1>Options liste Exposants</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('exposant_options_group');
            do_settings_sections('exposant-options');
            submit_button();
            ?>
        </form>
        <h2>Shortcode à utiliser</h2>
        <p>Utilisez le shortcode suivant pour afficher les exposants :</p>
        <ul>
            <li><code>[exposant]</code> - Affiche tous les exposants.</li>
            <li><code>[exposant master_partner="true"]</code> - Affiche uniquement les exposants où le champ <strong>masterPartner</strong> est défini à <strong>true</strong>.</li>
        </ul>
    </div>
    <?php
}

// Initialiser les options
function exposant_settings_init() {
    register_setting('exposant_options_group', 'exposant_posts_per_page');
    register_setting('exposant_options_group', 'exposant_custom_post_type');

    add_settings_section(
        'exposant_settings_section',
        'Paramètres de la liste',
        'exposant_settings_section_callback',
        'exposant-options'
    );

    add_settings_field(
        'exposant_posts_per_page',
        'Nombre de posts par page',
        'exposant_posts_per_page_render',
        'exposant-options',
        'exposant_settings_section'
    );

    add_settings_field(
        'exposant_custom_post_type',
        'Type de publication',
        'exposant_custom_post_type_render',
        'exposant-options',
        'exposant_settings_section'
    );
}
add_action('admin_init', 'exposant_settings_init');

function exposant_settings_section_callback() {
    echo 'Définissez les paramètres pour le shortcode des exposants.';
}

function exposant_posts_per_page_render() {
    $value = get_option('exposant_posts_per_page', -1);
    ?>
    <input type="number" name="exposant_posts_per_page" value="<?php echo esc_attr($value); ?>" />
    <?php
}

function exposant_custom_post_type_render() {
    $value = get_option('exposant_custom_post_type', 'exposant');
    $post_types = get_post_types(array('public' => true), 'objects');
    ?>
    <select name="exposant_custom_post_type">
        <?php foreach ($post_types as $post_type) : ?>
            <option value="<?php echo esc_attr($post_type->name); ?>" <?php selected($value, $post_type->name); ?>>
                <?php echo esc_html($post_type->labels->singular_name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}
