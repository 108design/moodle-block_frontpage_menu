<?php
/**
 * Block configuration help.
 *
 * @package block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license 108design source-available software license; see LICENSE.md
 */

defined('MOODLE_INTERNAL') || die();
/**
 * Return the component control for the native navigation bar.
 *
 * @param \renderer_base $renderer Native renderer used for output.
 * @return string
 */
function block_frontpage_menu_render_navbar_output(\renderer_base $renderer): string {
    return \block_frontpage_menu\output\context_help::navbar($renderer);
}
