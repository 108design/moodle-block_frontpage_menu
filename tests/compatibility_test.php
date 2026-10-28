<?php
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for tests/compatibility_test.php.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   108design source-available software license; see LICENSE.md
 */

namespace block_frontpage_menu;

defined('MOODLE_INTERNAL') || die();

/** Static compatibility regression tests. */
final class compatibility_test extends \basic_testcase {
    public function test_footer_uses_cross_bootstrap_classes(): void {
        $source = file_get_contents(__DIR__ . '/../block_frontpage_menu.php');

        $this->assertStringContainsString('badge badge-secondary', $source);
        $this->assertStringContainsString('block-frontpage-menu-gap-2', $source);
        $this->assertStringNotContainsString('text-bg-', $source);
        $this->assertStringNotContainsString(' gap-2', $source);
    }

    public function test_configuration_delegates_to_the_active_parent_authoring_gate(): void {
        $source = file_get_contents(__DIR__ . '/../classes/local/authority.php');

        $this->assertStringContainsString('\\local_menubuilder\\local\\gate::require_authoring()', $source);
        $this->assertStringContainsString('\\local_frontpage\\local\\licensing\\gate::MENUS_AUTHORING', $source);
        $this->assertFileDoesNotExist(__DIR__ . '/../classes/local/licensing/feature_provider.php');
        $this->assertFileDoesNotExist(__DIR__ . '/../classes/local/licensing/adapter.php');
    }
}
