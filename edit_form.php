<?php
// This file is part of Moodle - https://moodle.org/
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for edit_form.php.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   108design source-available software license; see LICENSE.md
 */
defined('MOODLE_INTERNAL') || die();

/** Instance settings for a freely placed canonical Frontpage menu. */
final class block_frontpage_menu_edit_form extends block_edit_form {
    /** Initialise help in the native block configuration form. */
    public function render(): string {
        \block_frontpage_menu\output\context_help::initialise();
        return parent::render();
    }

    protected function specific_definition($mform): void {
        global $PAGE;

        \block_frontpage_menu\local\authority::require_authoring();
        \block_frontpage_menu\output\context_help::prepare('menus');
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        $mform->addElement('text', 'config_title', get_string('title', 'block_frontpage_menu'), [
            'maxlength' => 255,
        ]);
        $mform->setType('config_title', PARAM_TEXT);
        $choices = [];
        if (\block_frontpage_menu\local\authority::available()) {
            foreach (\block_frontpage_menu\local\authority::source_choices() as $group => $groupchoices) {
                foreach ($groupchoices as $value => $label) {
                    $choices[$value] = $group . ' — ' . $label;
                }
            }
        }
        $mform->addElement('autocomplete', 'config_menusource', get_string('menu', 'block_frontpage_menu') . ' '
            . \block_frontpage_menu\output\context_help::icon('blocksource'),
            ['' => get_string('choosedots')] + $choices);
        $mform->setType('config_menusource', PARAM_RAW_TRIMMED);
        $mform->setDefault('config_menusource', $this->block->config->menusource ?? '');
        $mform->addRule('config_menusource', get_string('required'), 'required', null, 'client');
        $mform->addElement('select', 'config_profile', get_string('style', 'block_frontpage_menu') . ' '
            . \block_frontpage_menu\output\context_help::icon('blockprofile'), [
            'compact' => get_string('profilecompact', 'block_frontpage_menu'),
            'wide' => get_string('profilewide', 'block_frontpage_menu'),
        ]);
        $mform->setDefault('config_profile', 'compact');
        $mform->addElement('select', 'config_padding', get_string('density', 'block_frontpage_menu'), [
            'compact' => get_string('paddingcompact', 'block_frontpage_menu'),
            'normal' => get_string('paddingnormal', 'block_frontpage_menu'),
            'spacious' => get_string('paddingspacious', 'block_frontpage_menu'),
        ]);
        $mform->setDefault('config_padding', 'compact');
        $mform->addHelpButton('config_padding', 'density', 'block_frontpage_menu');
        // A dynamic block form renders without the parent page's navigation callbacks.
        $mform->addElement('html', \block_frontpage_menu\output\context_help::render()
            . \block_frontpage_menu\output\context_help::navbar($PAGE->get_renderer('core')));
    }

    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);
        $source = trim((string) ($data['config_menusource'] ?? ''));
        if (!in_array(($data['config_profile'] ?? ''), ['compact', 'wide'], true)) {
            $errors['config_profile'] = get_string('invalidprofile', 'block_frontpage_menu');
        }
        if ($source !== '' && (!\block_frontpage_menu\local\authority::available()
                || \block_frontpage_menu\local\authority::source_info($source) === null)) {
            $errors['config_menusource'] = get_string('invalidsource', 'block_frontpage_menu');
        }
        return $errors;
    }
}
