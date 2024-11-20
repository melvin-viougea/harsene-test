<?php
/**
 * Plugin Name: Crawler
 * Description: Plugin pour visualiser les liens internes à partir de la page d’accueil.
 * Version: 1.1
 * Author: Melvin VIougea
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'crawler_add_admin_page');

function crawler_add_admin_page() {
    add_menu_page(
        __('Crawler', 'crawler'),
        __('Crawler', 'crawler'),
        'manage_options',
        'crawler',
        'crawler_render_admin_page',
        'dashicons-networking',
        100
    );
}

function crawler_render_admin_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Harsene Test Technique - Crawler', 'crawler'); ?></h1>
        <p><?php _e('Liens trouvés sur la page d’accueil :', 'crawler'); ?></p>

        <?php
        $links = crawler_get_homepage_links();

        if (!empty($links['links'])) {
            echo '<table style="width:100%; border-collapse:collapse; margin-top:20px;">';
            echo '<thead>';
            echo '<tr style="background-color:#f2f2f2; text-align:left;">';
            echo '<th style="padding:8px; border:1px solid #ddd;">' . __('Lien', 'crawler') . '</th>';
            echo '<th style="padding:8px; border:1px solid #ddd;">' . __('Type', 'crawler') . '</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($links['links'] as $link) {
                $type = $link['internal'] ? __('Interne', 'crawler') : __('Externe', 'crawler');
                echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;"><a href="' . esc_url($link['url']) . '" target="_blank">' . esc_html($link['url']) . '</a></td>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . esc_html($type) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>' . __('Aucun lien trouvé ou erreur lors du scan.', 'crawler') . '</p>';
        }

        if (!empty($links['error'])) {
            echo '<p style="color:red;">' . __('Erreur :', 'crawler') . ' ' . esc_html($links['error']) . '</p>';
        }
        ?>
    </div>
    <?php
}

function crawler_get_homepage_links() {
    $cached_links = get_transient('crawler_homepage_links');
    if ($cached_links !== false) {
        return $cached_links;
    }

    $homepage_url = home_url();
    $response = wp_remote_get($homepage_url);

    if (is_wp_error($response)) {
        return [
            'links' => [],
            'error' => $response->get_error_message(),
        ];
    }

    $html = wp_remote_retrieve_body($response);

    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $links = [];
    $tags = $dom->getElementsByTagName('a');

    foreach ($tags as $tag) {
        $href = $tag->getAttribute('href');
        if (!empty($href)) {
            $is_internal = strpos($href, $homepage_url) !== false || strpos($href, '/') === 0;
            $links[] = [
                'url' => $is_internal ? home_url($href) : $href,
                'internal' => $is_internal,
            ];
        }
    }

    $result = [
        'links' => $links,
        'error' => '',
    ];

    set_transient('crawler_homepage_links', $result, HOUR_IN_SECONDS);

    return $result;
}
