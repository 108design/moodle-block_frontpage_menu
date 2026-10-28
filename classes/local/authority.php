<?php
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for classes/local/authority.php.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   108design source-available software license; see LICENSE.md
 */
namespace block_frontpage_menu\local;

/** Compatibility facade for Frontpage-integrated and standalone Menu Builder authorities. */
final class authority {
    public static function component(): string {
        if (class_exists('\local_menubuilder\local\authority')
                && \local_menubuilder\local\authority::active()) {
            return 'local_menubuilder';
        }
        if (class_exists('\local_frontpage\menu')) {
            return 'local_frontpage';
        }
        if (class_exists('\local_menubuilder\menu')) {
            return 'local_menubuilder';
        }
        return '';
    }

    public static function available(): bool {
        return self::component() !== '';
    }

    public static function source_choices(): array {
        $class = self::component() === 'local_menubuilder' ? '\local_menubuilder\menu' : '\local_frontpage\menu';
        return class_exists($class) ? $class::source_choices() : [];
    }

    public static function source_info(string $source): ?array {
        $class = self::component() === 'local_menubuilder' ? '\local_menubuilder\menu' : '\local_frontpage\menu';
        $info = class_exists($class) ? $class::source_info($source) : null;
        if ($info !== null) {
            return array_merge($info, ['authority' => self::component()]);
        }
        // Published Frontpage segment sources have no Standalone equivalent; preserve existing block assignments.
        if ($class !== '\local_frontpage\menu' && class_exists('\local_frontpage\menu')) {
            $info = \local_frontpage\menu::source_info($source);
            return $info === null ? null : array_merge($info, ['authority' => 'local_frontpage']);
        }
        return null;
    }

    public static function render_source(string $source, array $options): string {
        $info = self::source_info($source);
        if (!$info) {
            return '';
        }
        $class = ($info['authority'] ?? self::component()) === 'local_menubuilder'
            ? '\local_menubuilder\menu' : '\local_frontpage\menu';
        return $class::render_source($source, $options);
    }

    public static function amd_component(): string {
        return self::component();
    }

    public static function can_manage(): bool {
        $context = \context_system::instance();
        return self::component() === 'local_menubuilder'
            ? has_capability('local/menubuilder:manage', $context)
            : has_capability('local/frontpage:managepages', $context);
    }

    public static function require_authoring(): void {
        if (self::component() === 'local_menubuilder') {
            \local_menubuilder\local\gate::require_authoring();
            return;
        }
        if (self::component() === 'local_frontpage') {
            \local_frontpage\local\licensing\gate::require(
                \local_frontpage\local\licensing\gate::MENUS_AUTHORING);
            return;
        }
        throw new \moodle_exception('authorityunavailable', 'block_frontpage_menu');
    }
}
