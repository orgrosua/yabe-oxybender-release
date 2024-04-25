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

use DOMXPath;
use Exception;
use _YabeOxybender\Masterminds\HTML5;
/**
 * @since 1.0.0
 */
class Front
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
        \add_filter('do_shortcode_tag', fn($output, $tag) => $this->do_shortcode_tag($output, $tag), 10, 2);
    }
    public function do_shortcode_tag($output, $tag)
    {
        if (\strpos($tag, 'ct_') !== 0) {
            return $output;
        }
        $html5 = new HTML5();
        try {
            $dom = $html5->loadHTML($output);
            // traverse the DOM and merge the `plainclass` attribute with the `class` attribute
            $xpath = new DOMXPath($dom);
            $nodes = $xpath->query('//*[@plainclass]');
            foreach ($nodes as $node) {
                $plainclass = $node->getAttribute('plainclass');
                $node->removeAttribute('plainclass');
                $class = $node->getAttribute('class');
                $node->setAttribute('class', \trim($class . ' ' . $plainclass));
            }
            // save the modified HTML
            $output = $html5->saveHTML($dom);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $output;
    }
}
