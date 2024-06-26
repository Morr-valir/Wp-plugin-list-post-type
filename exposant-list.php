<?php
/*
Plugin Name: Exposant list
Description: Un plugin pour afficher une ligne d'éléments du custom post type "exposant" via un shortcode.
Version: 1.0
Author: Picard Matthieu
*/

// Sécurité de base pour empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Inclure les fonctions du plugin
include_once(plugin_dir_path(__FILE__) . 'includes/functions.php'); // logique plugin
include_once(plugin_dir_path(__FILE__) . 'includes/admin-menu.php'); // menu admin custom
require_once plugin_dir_path(__FILE__) . 'includes/custom-post-type.php'; //custom post type exposant
require_once plugin_dir_path(__FILE__) . 'includes/custom-meta-boxes.php'; // custom fields exposant