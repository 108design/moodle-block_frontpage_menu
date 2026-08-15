<?php
namespace block_frontpage_menu\local\licensing;

defined('MOODLE_INTERNAL') || die();

/** Reuse Frontpage standalone observation without creating a second activation authority. */
final class adapter {
    public static function observe(string $entitlement): array {
        $frontpage = '\\local_frontpage\\local\\licensing\\adapter';
        if (class_exists($frontpage) && method_exists($frontpage, 'observe')) {
            return $frontpage::observe($entitlement);
        }
        return ['active' => false, 'configured' => false, 'source' => 'local_frontpage'];
    }
}
