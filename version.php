<?php
defined('MOODLE_INTERNAL') || die();

$plugin->component = 'block_frontpage_menu';
$plugin->version = 2026081407;
$plugin->requires = 2024100700; // Moodle 4.5.
$plugin->dependencies = ['local_frontpage' => 2026081412];
$plugin->maturity = MATURITY_BETA;
$plugin->release = '0.5.1-beta';
