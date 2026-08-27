<?php
defined('MOODLE_INTERNAL') || die();

/** Render one canonical Frontpage menu in any Moodle block region. */
final class block_frontpage_menu extends block_base {
    public function init(): void {
        $this->title = get_string('pluginname', 'block_frontpage_menu');
    }

    public function specialization(): void {
        if (trim((string) ($this->config->title ?? '')) !== '') {
            $this->title = format_string($this->config->title);
        }
    }

    public function instance_allow_multiple(): bool {
        return true;
    }

    public function instance_config_save($data, $nolongerused = false) {
        unset($data->style); // Remove the pre-Phase-A legacy field; profile is the current presentation contract.
        if (($data->profile ?? '') === 'course-explorer') {
            $data->profile = 'wide';
        }
        return parent::instance_config_save($data, $nolongerused);
    }

    public function applicable_formats(): array {
        return ['all' => true];
    }

    public function get_content(): stdClass {
        global $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';
        if (!\block_frontpage_menu\local\authority::available()) {
            $this->content->text = $this->editing_placeholder(
                get_string('frontpageunavailable', 'block_frontpage_menu')
            );
            return $this->content;
        }
        $source = trim((string) ($this->config->menusource ?? ''));
        if ($source === '') {
            $this->content->text = $this->editing_placeholder(
                get_string('notconfigured', 'block_frontpage_menu')
            );
            return $this->content;
        }
        $storedprofile = (string) ($this->config->profile ?? '');
        $profile = $storedprofile === 'course-explorer' ? 'wide'
            : (in_array($storedprofile, ['compact', 'wide'], true) ? $storedprofile : 'compact');
        $options = ['style' => $profile === 'wide' ? 'secondary' : 'block',
            'padding' => (string) ($this->config->padding ?? 'compact'),
            'label' => $this->title];
        $sourceinfo = \block_frontpage_menu\local\authority::source_info($source);
        $amdcomponent = (string) ($sourceinfo['authority'] ??
            \block_frontpage_menu\local\authority::amd_component());
        if ($amdcomponent !== '') {
            $PAGE->requires->js_call_amd($amdcomponent . '/menu', 'init');
        }
        $rendered = \block_frontpage_menu\local\authority::render_source($source, $options);
        $this->content->text = trim($rendered) !== '' ? $rendered : $this->editing_placeholder(
            get_string('novisibleentries', 'block_frontpage_menu')
        );
        if ($sourceinfo !== null && \block_frontpage_menu\local\authority::can_manage()) {
            $this->content->footer = $this->source_footer($sourceinfo);
        }
        return $this->content;
    }

    /** Describe the live source to administrators and link to its authoritative editor. */
    private function source_footer(array $sourceinfo): string {
        global $OUTPUT;

        $type = in_array($sourceinfo['type'], ['central', 'segment', 'linkedsegment'], true)
            ? $sourceinfo['type'] : 'central';
        $label = get_string('source' . $type, 'block_frontpage_menu');
        $linklabel = get_string('configuresource', 'block_frontpage_menu');
        return html_writer::div(
            html_writer::div(
                html_writer::span($label, 'badge badge-secondary')
                . html_writer::span(format_string($sourceinfo['name']), 'text-truncate'),
                'd-flex align-items-center block-frontpage-menu-gap-2 block-frontpage-menu-min-w-0'
            )
            . html_writer::link($sourceinfo['editurl'],
                $OUTPUT->pix_icon('t/edit', '') . html_writer::span($linklabel), [
                    'class' => 'small d-inline-flex align-items-center block-frontpage-menu-gap-1 mt-2',
                ]),
            'local-frontpage-menu-block-source border-top pt-2 mt-2 text-muted small'
        );
    }

    /** Keep an empty block discoverable to editors without exposing configuration state to other users. */
    private function editing_placeholder(string $message): string {
        if (!$this->page->user_can_edit_blocks() && !$this->user_can_edit()) {
            return '';
        }
        $editurl = new moodle_url($this->page->url);
        $editurl->param('bui_editid', (int) $this->instance->id);
        return html_writer::div(
            html_writer::div($message, 'mb-2') .
            html_writer::link($editurl, get_string('configure', 'block_frontpage_menu'), [
                'class' => 'btn btn-sm btn-outline-primary',
            ]),
            'alert alert-info mb-0'
        );
    }

    public function instance_can_be_hidden(): bool {
        return true;
    }
}
