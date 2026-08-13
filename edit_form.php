<?php
defined('MOODLE_INTERNAL') || die();

/** Instance settings for a freely placed canonical Frontpage menu. */
final class block_frontpage_menu_edit_form extends block_edit_form {
    protected function specific_definition($mform): void {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        $mform->addElement('text', 'config_title', get_string('title', 'block_frontpage_menu'), [
            'maxlength' => 255,
        ]);
        $mform->setType('config_title', PARAM_TEXT);
        $choices = [];
        if (class_exists(\local_frontpage\menu::class)) {
            if (method_exists(\local_frontpage\menu::class, 'source_choices')) {
                foreach (\local_frontpage\menu::source_choices() as $group => $groupchoices) {
                    foreach ($groupchoices as $value => $label) {
                        $choices[$value] = $group . ' — ' . $label;
                    }
                }
            } else {
                $central = [];
                foreach (\local_frontpage\menu::choices() as $id => $label) {
                    $central['central:' . (int) $id] = $label;
                }
                if ($central) {
                    $choices[get_string('sourcecentral', 'block_frontpage_menu')] = $central;
                }
            }
        }
        $mform->addElement('autocomplete', 'config_menusource', get_string('menu', 'block_frontpage_menu'),
            ['' => get_string('choosedots')] + $choices);
        $mform->setType('config_menusource', PARAM_RAW_TRIMMED);
        $mform->setDefault('config_menusource', $this->block->config->menusource
            ?? (!empty($this->block->config->menuid) ? 'central:' . (int) $this->block->config->menuid : ''));
        $mform->addRule('config_menusource', get_string('required'), 'required', null, 'client');
        $mform->addElement('static', 'blockstyle', get_string('style', 'block_frontpage_menu'),
            get_string('fixedstyle', 'block_frontpage_menu'));
        $mform->addElement('select', 'config_padding', get_string('density', 'block_frontpage_menu'), [
            'compact' => get_string('menupaddingcompact', 'local_frontpage'),
            'normal' => get_string('menupaddingnormal', 'local_frontpage'),
            'spacious' => get_string('menupaddingspacious', 'local_frontpage'),
        ]);
        $mform->setDefault('config_padding', 'compact');
    }

    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);
        $source = trim((string) ($data['config_menusource'] ?? ''));
        if ($source !== '' && (!class_exists(\local_frontpage\menu::class)
                || (method_exists(\local_frontpage\menu::class, 'source_info')
                    ? \local_frontpage\menu::source_info($source) === null
                    : !preg_match('/^central:[1-9][0-9]*$/', $source)))) {
            $errors['config_menusource'] = get_string('invalidsource', 'block_frontpage_menu');
        }
        return $errors;
    }
}
