<?php
defined('MOODLE_INTERNAL') || die();

/** Instance settings for a freely placed canonical Frontpage menu. */
final class block_frontpage_menu_edit_form extends block_edit_form {
    protected function specific_definition($mform): void {
        \block_frontpage_menu\local\authority::require_authoring();
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
        $mform->addElement('autocomplete', 'config_menusource', get_string('menu', 'block_frontpage_menu'),
            ['' => get_string('choosedots')] + $choices);
        $mform->setType('config_menusource', PARAM_RAW_TRIMMED);
        $mform->setDefault('config_menusource', $this->block->config->menusource ?? '');
        $mform->addRule('config_menusource', get_string('required'), 'required', null, 'client');
        $mform->addElement('select', 'config_profile', get_string('style', 'block_frontpage_menu'), [
            'compact' => get_string('profilecompact', 'block_frontpage_menu'),
            'wide' => get_string('profilewide', 'block_frontpage_menu'),
        ]);
        $mform->setDefault('config_profile', 'compact');
        $mform->addHelpButton('config_profile', 'profile', 'block_frontpage_menu');
        $mform->addElement('select', 'config_padding', get_string('density', 'block_frontpage_menu'), [
            'compact' => get_string('paddingcompact', 'block_frontpage_menu'),
            'normal' => get_string('paddingnormal', 'block_frontpage_menu'),
            'spacious' => get_string('paddingspacious', 'block_frontpage_menu'),
        ]);
        $mform->setDefault('config_padding', 'compact');
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
