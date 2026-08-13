<?php
namespace block_frontpage_menu\privacy;

/** This block stores configuration only and no personal data. */
final class provider implements \core_privacy\local\metadata\null_provider {
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
