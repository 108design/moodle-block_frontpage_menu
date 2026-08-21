<?php
defined('MOODLE_INTERNAL') || die();

$plugin->component = 'block_frontpage_menu';
$plugin->version = 2026082100;
$plugin->requires = 2024100700; // Moodle 4.5.
$plugin->dependencies = ['local_frontpage' => 2026082002];
$plugin->maturity = MATURITY_BETA;
$plugin->release = '0.7.1-beta';
