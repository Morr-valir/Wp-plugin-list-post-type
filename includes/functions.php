<?php
// Sécurité de base pour empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Fonction pour générer le shortcode
function exposant_shortcode($atts) {
    // Récupérer les valeurs des options
    $default_posts_per_page = get_option('exposant_posts_per_page', -1);
    $default_post_type = get_option('exposant_custom_post_type', 'exposant');

    // Extraire les attributs du shortcode
    $atts = shortcode_atts(
        array(
            'posts_per_page' => $default_posts_per_page,
            'post_type' => $default_post_type,
            'master_partner' => 'false',
        ),
        $atts,
        'exposant'
    );

    // Préparer les arguments pour WP_Query
    $args = array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page'],
        'orderby' => 'title', // Tri par titre
        'order' => 'ASC',     // Ordre croissant
        'meta_query' => array()
    );

    // Filtrer par master_partner si nécessaire
    if ($atts['master_partner'] === 'true') {
        $args['meta_query'][] = array(
            'key' => '_exposant_master_partner',
            'value' => '1',
            'compare' => '='
        );
    }

    $query = new WP_Query($args);

    // Démarrer la capture du contenu
    ob_start();

    if ($query->have_posts()) {
        echo '<div class="exposant-row">';
        while ($query->have_posts()) {
            $query->the_post();
            // Récupérer les informations nécessaires
            $post_slug = get_post_field('post_name', get_post());
            $post_thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $post_title = get_the_title();
            $post_excerpt = get_the_excerpt();

            // Récupérer la valeur du champ personnalisé _exposant_master_partner
            $is_master = get_post_meta(get_the_ID(), '_exposant_master_partner', true);

            // Déterminer la valeur de l'attribut data-card-master
            $data_card_master = $is_master === '1' ? 'true' : 'false';

            // Générer le HTML pour chaque exposant
            ?>
            <a class="expolink" href="<?php echo esc_url(get_permalink()); ?>" target="_blank">
                <div class="expolist" data-card-master="<?php echo $data_card_master; ?>">
                    <figure>
                        <img src="<?php echo esc_url($post_thumb); ?>" alt="<?php echo esc_attr($post_title); ?>">
                    </figure>
                    <main>
                        <h1><?php echo esc_html($post_title); ?></h1>    
                        <p>
                            <?php echo esc_html($post_excerpt); ?>
                        </p>
                    </main>    
                </div>
            </a>
            <?php
        }
        echo '</div>';
    } else {
        echo 'Aucun exposant trouvé.';
    }

    // Restaurer la postdata originale
    wp_reset_postdata();

    // Retourner le contenu capturé
    return ob_get_clean();
}

// Ajouter le shortcode [exposant]
add_shortcode('exposant', 'exposant_shortcode');

// Fonction pour enqueuer le style CSS
function exposant_enqueue_styles() {
    // Enqueue le fichier CSS
    wp_enqueue_style('exposant-style', plugin_dir_url(__FILE__) . '../assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'exposant_enqueue_styles');
