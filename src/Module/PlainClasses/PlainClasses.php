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
namespace Yabe\Oxybender\Module\PlainClasses;

use Yabe\Oxybender\Module\ModuleInterface;
/**
 * @since 1.0.0
 */
class PlainClasses implements ModuleInterface
{
    public function __construct()
    {
        \add_action('a!yabe/oxybender/core/oxygeneditor:editor_assets.end', fn() => $this->register_autocomplete());
    }
    public function get_name() : string
    {
        return 'plain-classes';
    }
    public function register_autocomplete()
    {
        \do_action('a!yabe/oxybender/module/plainclasses:register_autocomplete');
    }
}
