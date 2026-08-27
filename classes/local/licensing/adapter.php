<?php
namespace block_frontpage_menu\local\licensing;

defined('MOODLE_INTERNAL') || die();

/** Observe the active Menu Builder without creating a second activation authority. */
final class adapter {
    public static function observe(string $entitlement): array {
        $authority = '\\local_menubuilder\\local\\authority';
        $standalone = '\\local_menubuilder\\local\\licensing\\adapter';
        if (class_exists($authority) && $authority::active()
                && class_exists($standalone) && method_exists($standalone, 'observe')) {
            return $standalone::observe($entitlement);
        }
        $frontpage = '\\local_frontpage\\local\\licensing\\adapter';
        if (class_exists($frontpage) && method_exists($frontpage, 'observe')) {
            return $frontpage::observe($entitlement);
        }
        if (class_exists($standalone) && method_exists($standalone, 'observe')) {
            return $standalone::observe($entitlement);
        }
        return ['active' => false, 'configured' => false, 'source' => 'block_frontpage_menu'];
    }
}
