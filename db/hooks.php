<?php
// This file is part of Moodle - https://moodle.org/
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for db/hooks.php.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   108design source-available software license; see LICENSE.md
 */
defined('MOODLE_INTERNAL') || die();

$callbacks = [];

// Decorative product identity is restricted to the native administration surfaces.
$callbacks[] = [
    'hook' => \core\hook\output\before_standard_head_html_generation::class,
    'callback' => [\block_frontpage_menu\local\admin_branding::class, 'head'],
];
$callbacks[] = [
    'hook' => \core\hook\output\before_http_headers::class,
    'callback' => [\block_frontpage_menu\local\admin_branding::class, 'prepare'],
];
$callbacks[] = [
    'hook' => \core\hook\output\before_standard_footer_html_generation::class,
    'callback' => [\block_frontpage_menu\output\context_help::class, 'footer'],
];

// Independent signed update-package guard.
$callbacks[] = [
    'hook' => \core\hook\after_config::class,
    'callback' => [\block_frontpage_menu\local\update_guard::class, 'after_config'],
    'priority' => 1002,
];
