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
namespace Yabe\Oxybender\Core;

use Exception;
use _YabeOxybender\OXYBENDER;
use Yabe\Oxybender\Utils\AssetVite;
/**
 * @since 1.0.0
 */
class OxygenEditor
{
    /**
     * Stores the instance, implementing a Singleton pattern.
     */
    private static self $instance;
    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    private function __construct()
    {
    }
    /**
     * Singletons should not be cloneable.
     */
    private function __clone()
    {
    }
    /**
     * Singletons should not be restorable from strings.
     *
     * @throws Exception Cannot unserialize a singleton.
     */
    public function __wakeup()
    {
        throw new Exception('Cannot unserialize a singleton.');
    }
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static property. On subsequent runs, it returns the client existing
     * object stored in the static property.
     */
    public static function get_instance() : self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function init()
    {
        \add_action('oxygen_enqueue_iframe_scripts', fn() => $this->iframe_assets(), 1000000);
        \add_action('oxygen_enqueue_ui_scripts', fn() => $this->editor_assets(), 1000000);
    }
    public function iframe_assets()
    {
        \do_action('a!yabe/oxybender/core/oxygeneditor:iframe_assets.start');
        AssetVite::get_instance()->enqueue_asset('assets/oxygen/iframe/main.js', ['handle' => OXYBENDER::WP_OPTION . ':iframe', 'in_footer' => \true]);
        \do_action('a!yabe/oxybender/core/oxygeneditor:iframe_assets.end');
    }
    public function editor_assets()
    {
        \do_action('a!yabe/oxybender/core/oxygeneditor:editor_assets.start');
        AssetVite::get_instance()->enqueue_asset('assets/oxygen/editor/main.js', ['handle' => OXYBENDER::WP_OPTION . ':editor', 'in_footer' => \true]);
        // wp_localize_script(OXYBENDER::WP_OPTION . ':editor', 'oxybender', [
        //     '_version' => OXYBENDER::VERSION,
        //     '_wpnonce' => wp_create_nonce(OXYBENDER::WP_OPTION),
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
        \do_action('a!yabe/oxybender/core/oxygeneditor:editor_assets.end');
    }
}
