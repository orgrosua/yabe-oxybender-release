<?php

/*
 * This file is part of the Yabe package.
 *
 * (c) Joshua Gugun Siagian <suabahasa@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace Yabe\Oxybender\Admin;

use _YabeOxybender\OXYBENDER;
use Yabe\Oxybender\Utils\AssetVite;
class AdminPage
{
    public function __construct()
    {
        \add_action('admin_menu', fn() => $this->add_admin_menu(), 1000001);
    }
    public static function get_page_url() : string
    {
        return \add_query_arg(['page' => OXYBENDER::WP_OPTION], \admin_url('admin.php'));
    }
    public function add_admin_menu()
    {
        $hook = \add_submenu_page('ct_dashboard_page', \__('Yabe Oxybender', 'yabe-oxybender'), \__('Yabe Oxybender', 'yabe-oxybender'), 'manage_options', OXYBENDER::WP_OPTION, fn() => $this->render(), 1000001);
        \add_action('load-' . $hook, fn() => $this->init_hooks());
    }
    private function render()
    {
        \add_filter('admin_footer_text', static fn($text) => 'Thank you for using <b>Oxybender</b>! Join us on the <a href="https://www.facebook.com/groups/1142662969627943" target="_blank">Facebook Group</a>.', 1000001);
        \add_filter('update_footer', static fn($text) => $text . ' | Oxybender ' . OXYBENDER::VERSION, 1000001);
        echo '<div id="oxybender-app" class=""></div>';
    }
    private function init_hooks()
    {
        \add_action('admin_enqueue_scripts', fn() => $this->enqueue_scripts(), 1000001);
    }
    private function enqueue_scripts()
    {
        $handle = OXYBENDER::WP_OPTION . ':admin';
        AssetVite::get_instance()->enqueue_asset('assets/admin/main.js', ['handle' => $handle, 'in_footer' => \true]);
        // wp_set_script_translations($handle, 'yabe-oxybender');
        // wp_localize_script($handle, 'oxybender', [
        //     '_version' => OXYBENDER::VERSION,
        //     '_wpnonce' => wp_create_nonce(OXYBENDER::WP_OPTION),
        //     'web_history' => self::get_page_url(),
        //     'rest_api' => [
        //         'nonce' => wp_create_nonce('wp_rest'),
        //         'root' => esc_url_raw(rest_url()),
        //         'namespace' => OXYBENDER::REST_NAMESPACE,
        //         'url' => esc_url_raw(rest_url(OXYBENDER::REST_NAMESPACE)),
        //     ],
        //     'assets' => [
        //         'url' => AssetVite::asset_base_url(),
        //     ],
        //     'site_meta' => [
        //         'name' => get_bloginfo('name'),
        //         'site_url' => get_site_url(),
        //     ],
        // ]);
    }
}
