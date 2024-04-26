<?php

/**
 * Yabe Oxybender - The Oxygen builder extension
 *
 * @wordpress-plugin
 * Plugin Name:         Yabe Oxybender
 * Plugin URI:          https://oxybender.yabe.land
 * Description:         The Oxygen builder extension
 * Version:             1.0.1
 * Requires at least:   6.0
 * Requires PHP:        7.4
 * Author:              Rosua
 * Author URI:          https://yabe.land
 * Donate link:         https://ko-fi.com/Q5Q75XSF7
 * Text Domain:         yabe-oxybender
 * Domain Path:         /languages
 * License:             GPL-3.0-or-later
 *
 * @package             Yabe
 * @author              Joshua Gugun Siagian <suabahasa@gmail.com>
 */
declare (strict_types=1);
namespace _YabeOxybender;

use Yabe\Oxybender\Plugin;
use Yabe\Oxybender\Utils\Requirement;
\defined('ABSPATH') || exit;
if (\file_exists(__DIR__ . '/vendor/scoper-autoload.php')) {
    require_once __DIR__ . '/vendor/scoper-autoload.php';
} else {
    require_once __DIR__ . '/vendor/autoload.php';
}
$requirement = new Requirement();
$requirement->php('7.4')->wp('6.0')->plugins([['slug' => 'oxygen/functions.php', 'name' => 'Oxygen', 'version' => '4.8.1']]);
if ($requirement->met()) {
    Plugin::get_instance()->boot();
} else {
    \add_action('admin_notices', fn() => $requirement->printNotice(), 0, 0);
}
