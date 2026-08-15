<?php

namespace block_frontpage_menu;

defined('MOODLE_INTERNAL') || die();

/** Static compatibility regression tests. */
final class compatibility_test extends \advanced_testcase {
    public function test_footer_uses_cross_bootstrap_classes(): void {
        $source = file_get_contents(__DIR__ . '/../block_frontpage_menu.php');

        $this->assertStringContainsString('badge badge-secondary', $source);
        $this->assertStringContainsString('block-frontpage-menu-gap-2', $source);
        $this->assertStringNotContainsString('text-bg-', $source);
        $this->assertStringNotContainsString(' gap-2', $source);
    }
}
