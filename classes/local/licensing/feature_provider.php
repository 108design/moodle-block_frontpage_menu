<?php
namespace block_frontpage_menu\local\licensing;

defined('MOODLE_INTERNAL') || die();

/** The block renders existing menus safely; selecting a source belongs to Menu Builder authoring. */
final class feature_provider {
    public static function manifest(): array {
        return ['block_frontpage_menu/configuration' => [
            'label' => get_string('pluginname', 'block_frontpage_menu'),
            'mode' => 'entitled', 'entitlements' => ['menubuilder.pro'], 'operation' => 'authoring',
            'policyarea' => 'frontpage', 'policyproduct' => 'menus',
            'policyproductlabel' => get_string('licensepolicyproduct', 'block_frontpage_menu'),
            'policyitemlabel' => get_string('licensepolicyitem', 'block_frontpage_menu'),
            'policyorder' => 40,
            'degradation' => 'Existing configured blocks keep rendering; instance configuration is read-only.',
            'discovery' => 'Presented with the Frontpage Menu Builder module, never to ordinary viewers.',
            'adapter' => adapter::class,
        ]];
    }
}
