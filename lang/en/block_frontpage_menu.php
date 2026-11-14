<?php
// This file is part of Moodle - https://moodle.org/
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for lang/en/block_frontpage_menu.php.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   108design source-available software license; see LICENSE.md
 */
$string['pluginname'] = 'Menu Builder Block';
$string['title'] = 'Block title';
$string['menu'] = 'Menu source';
$string['style'] = 'Menu style';
$string['padding'] = 'Menu spacing';
$string['density'] = 'Density';
$string['fixedstyle'] = 'Compact block menu';
$string['profilecompact'] = 'Compact vertical menu';
$string['profilewide'] = 'Wide horizontal menu';
$string['profile_help'] = 'Use the compact profile in a side region. Wide profiles are intended for full-width content regions.';
$string['invalidprofile'] = 'The selected menu profile is invalid.';
$string['invalidsource'] = 'The selected menu source is no longer available.';
$string['sourcecentral'] = 'Central';
$string['sourcesegment'] = 'Segment';
$string['sourcelinkedsegment'] = 'Linked segment';
$string['configuresource'] = 'Configure menu';
$string['configure'] = 'Configure block';
$string['notconfigured'] = 'Select a Menu Builder menu for this block.';
$string['novisibleentries'] = 'The selected menu has no visible entries in the current view.';
$string['frontpageunavailable'] = 'The Menu Builder integration is currently unavailable.';
$string['privacy:metadata'] = 'The Menu Builder Block stores no personal data.';
$string['frontpage_menu:addinstance'] = 'Add a Menu Builder block';
$string['frontpage_menu:myaddinstance'] = 'Add a Menu Builder block to the dashboard';
$string['authorityunavailable'] = 'Set up Menu Builder before configuring this block.';
$string['paddingcompact'] = 'Compact';
$string['paddingnormal'] = 'Normal';
$string['paddingspacious'] = 'Spacious';

$string['pagehelp_menus_title'] = 'Menu Block Help';
$string['pagehelp_more'] = 'More in the help panel';
$string['contexthelptopics'] = 'Help Topics';
$string['pagehelp_blocksource'] = 'Menu Source';
$string['pagehelp_blocksource_help'] = 'The block references the current central definition. Use its source link to edit that menu.';
$string['pagehelp_blocksource_article'] = (
        '<p>Select the central menu to display. Multiple blocks may reference the same '
    . 'key; changes to the central menu appear in each block. The source host '
    . 'controls the menu structure and visibility.</p><p>The source selector lists '
    . 'the menus offered by the active provider. The block keeps the selected source '
    . 'reference and does not copy its content. A missing or conditionally empty '
    . 'source produces no menu for ordinary viewers; editors see a configuration '
    . 'placeholder.</p>'
    );
$string['pagehelp_blockprofile'] = 'Profile and Density';
$string['pagehelp_blockprofile_help'] = ('Choose Compact for vertical output or Wide for horizontal output. Match the '
    . 'actual space offered by your theme.');
$string['pagehelp_blockprofile_article'] = (
        '<p><strong>Compact vertical menu</strong> keeps branches stacked within the '
    . 'block. <strong>Wide horizontal menu</strong> lays root entries across the '
    . 'available width. Your theme determines the available block regions and their '
    . 'actual width.</p><p><strong>Density</strong> adjusts spacing. The selected '
    . 'profile does not change the central definition, its visibility conditions or '
    . 'the output in other blocks.</p>'
    );
$string['density_help'] = 'Adjust the spacing around the menu: Compact, Normal or Spacious.';

// Shared independent signed update protection.
$string['updateguard_heading'] = 'Update stopped';
$string['updateguard_component'] = 'The package for {$a} was rejected.';
$string['updateguard_hint'] = 'Use an approved package for the installed edition. You can review the operation again.';
$string['updateguard_unchanged'] = 'This request did not replace plugin files.';
$string['updateguard_help'] = 'The installed plugin checks the publisher signature, package contents, permitted update channel and compatibility before replacement. A valid signature does not authorise a different edition. If one package is rejected, the whole batch stops.';
$string['updateguard_signature'] = 'The publisher signature or package contents could not be verified.';
$string['updateguard_policy'] = 'This package does not match the installed edition or permitted package profile.';
$string['updateguard_channel'] = 'Updates through this channel are not enabled for this plugin.';
$string['updateguard_metadata'] = 'The version or dependency information is inconsistent.';
$string['updateguard_dependency'] = 'A required plugin version is missing. Update the dependency together with this plugin or beforehand.';
$string['updateguard_approval'] = 'The packages or installed state have changed since the preview. Review the operation again.';
$string['updateguard_busy'] = 'Another installation is running. Try again after it finishes.';
$string['updateguard_installed'] = 'The installed update protection is incomplete. Restore the files of the last approved installed version.';
$string['updateguard_operation'] = 'This combination of installation actions is not supported. Start a single update operation again.';
$string['updateguard_failed'] = 'The update could not be verified. No installation was started.';
$string['updateguard_back'] = 'Return to plugin overview';
// End shared independent signed update protection.
