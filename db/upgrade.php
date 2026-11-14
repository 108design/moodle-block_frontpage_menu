<?php
// This file is part of Moodle - https://moodle.org/
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for db/upgrade.php.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   108design source-available software license; see LICENSE.md
 */
defined('MOODLE_INTERNAL') || die();

/** Upgrade steps for the Frontpage Menu block. */
function xmldb_block_frontpage_menu_upgrade(int $oldversion): bool {
    global $DB;

    if ($oldversion < 2026082100) {
        // The former Course Explorer profile described a source feature as a visual style. Existing blocks retain
        // their wide layout while Explorer source items continue to enhance themselves automatically at runtime.
        foreach ($DB->get_records('block_instances', ['blockname' => 'frontpage_menu']) as $instance) {
            $config = @unserialize(base64_decode((string) $instance->configdata));
            if (!is_object($config) || ($config->profile ?? '') !== 'course-explorer') {
                continue;
            }
            $config->profile = 'wide';
            $DB->set_field('block_instances', 'configdata', base64_encode(serialize($config)), ['id' => $instance->id]);
        }
        upgrade_block_savepoint(true, 2026082100, 'frontpage_menu');
    }
    return true;
}
