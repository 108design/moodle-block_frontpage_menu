<?php
/**
 * Read-only customer help, limited to the current authoring context.
 *
 * @package block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license 108design source-available software license; see LICENSE.md
 */

// Copyright (C) 2026 Andreas Giesen. See LICENSE.md.
namespace block_frontpage_menu\output;

/**
 * Read-only customer help, limited to the current authoring context.
 */
final class context_help {
    /**
     * Contexts.
     */
    private const CONTEXTS = [ 'menus' => ['blocksource', 'blockprofile'] ];

    /**
     * @var ?string Context.
     */
    private static ?string $context = null;
    /**
     * @var bool Rendered.
     */
    private static bool $rendered = false;

    /**
     * Shared preview renderers must not add help to unregistered chooser contexts.
     *
     * @param string $context Native Moodle context.
     * @return bool
     */
    public static function registered(string $context): bool {
        return self::$context === $context;
    }

    /**
     * Register the assets needed by the current native page.
     *
     * @param string $context Native Moodle context.
     * @return void
     */
    public static function prepare(string $context): void {
        global $CFG, $PAGE;
        self::topics($context);
        self::$context = $context;
        $PAGE->requires->css(new \moodle_url('/blocks/frontpage_menu/styles/context_help.css', [
            'rev' => get_config('block_frontpage_menu', 'version'),
        ]));
        self::initialise();
    }

    /**
     * Dynamic forms collect requirements during render, after their definition has run.
     *
     * @return void
     */
    public static function initialise(): void {
        global $CFG, $PAGE;
        $module = (int)$CFG->version < 2025041400 ? 'context_help_legacy' : 'context_help';
        $PAGE->requires->js_call_amd('block_frontpage_menu/context_help_form', 'init');
        $PAGE->requires->js_call_amd('block_frontpage_menu/' . $module, 'init', [[
            'topic' => optional_param('frontpagemenuhelp', '', PARAM_ALPHA),
            'cssUrl' => (new \moodle_url('/blocks/frontpage_menu/styles/context_help.css', [
                'rev' => get_config('block_frontpage_menu', 'version'),
            ]))->out(false),
        ]]);
    }

    /**
     * Return the help topics available in the current editing context.
     *
     * @param string $context Native Moodle context.
     * @return array
     */
    private static function topics(string $context): array {
        if (!isset(self::CONTEXTS[$context])) {
            throw new \coding_exception('Unknown help context.');
        }
        return self::CONTEXTS[$context];
    }

    /**
     * Keep Moodle's help popover, using an information icon for our own context help.
     *
     * @param string $topic Registered contextual help topic.
     * @param string $context Native Moodle context.
     * @return string
     */
    public static function icon(string $topic, string $context = 'menus'): string {
        global $CFG, $PAGE;
        if (!in_array($topic, self::topics($context), true)) {
            throw new \coding_exception('Unknown help topic.');
        }
        $url = new \moodle_url($PAGE->url);
        $url->param('frontpagemenuhelp', $topic);
        $help = new \help_icon('pagehelp_' . $topic, 'block_frontpage_menu', $url->out(false));
        // Form labels and dynamic source configuration may request help before output starts.
        $renderer = $PAGE->get_renderer('core');
        $data = (array)$help->export_for_template($renderer);
        $data['completedoclink'] = \html_writer::link($url, get_string('pagehelp_more', 'block_frontpage_menu'));
        $data['legacy'] = (int)$CFG->version < 2025041400;
        $data['infoicon'] = (int)$CFG->version < 2026100500 ? 'i/info' : 'i/circleinfo';
        return $renderer->render_from_template('block_frontpage_menu/context_help_icon', $data);
    }

    /**
     * Called by Moodle's navbar callback only after a permitted page registers its help.
     *
     * @param \renderer_base $renderer Native renderer used for output.
     * @return string
     */
    public static function navbar(\renderer_base $renderer): string {
        global $CFG;
        if (self::$context === null) {
            return '';
        }
        $key = self::$context === 'pages' ? 'pagehelp_title' : 'pagehelp_' . self::$context . '_title';
        $label = get_string($key, 'block_frontpage_menu');
        return \html_writer::tag(
            'button',
            $renderer->pix_icon((int)$CFG->version < 2026100500 ? 'i/info' : 'i/circleinfo', ''),
            [

            'type' => 'button',
            'class' => 'nav-link icon-no-margin block-frontpage-menu-help-navbar',
            'data-frontpagemenu-help-open' => '', 'data-frontpagemenu-help-context' => self::$context,
            'aria-label' => $label, 'title' => $label,
            'aria-controls' => 'block-frontpage-menu-context-help', 'aria-expanded' => 'false',

            ]
        );
    }

    /**
     * Return the component output appended to the native page footer.
     *
     * @param \core\hook\output\before_standard_footer_html_generation $hook Native Moodle output hook.
     * @return void
     */
    public static function footer(\core\hook\output\before_standard_footer_html_generation $hook): void {
        if (self::$context !== null) {
            $hook->add_html(self::render());
        }
    }

    /**
     * Render the help panel for the registered page context.
     *
     * @param string $context Native Moodle context.
     * @return string
     */
    public static function render(string $context = 'menus'): string {
        global $CFG, $PAGE;
        if (self::$rendered) {
            return '';
        }
        self::$rendered = true;
        $key = $context === 'pages' ? 'pagehelp_title' : 'pagehelp_' . $context . '_title';
        $title = get_string($key, 'block_frontpage_menu');
        $close = \html_writer::tag('button', \html_writer::span('&#215;', '', ['aria-hidden' => 'true']), [
            'type' => 'button', 'class' => 'btn btn-secondary btn-sm block-frontpage-menu-help-close',
            'aria-label' => get_string('closebuttontitle', 'moodle'), 'data-frontpagemenu-help-close' => '1',
        ]);
        $options = '';
        $articles = '';
        foreach (self::topics($context) as $topic) {
            $label = get_string('pagehelp_' . $topic, 'block_frontpage_menu');
            $options .= \html_writer::tag('option', $label, ['value' => $topic]);
            $articles .= \html_writer::tag(
                'article',
                \html_writer::tag('h3', $label, [ 'class' => 'h5', 'tabindex' => '-1' ])
                . get_string('pagehelp_' . $topic . '_article', 'block_frontpage_menu'),
                [ 'data-frontpagemenu-help-article' => $topic, 'hidden' => 'hidden' ]
            );
        }
        $choice = \html_writer::tag('label', get_string('contexthelptopics', 'block_frontpage_menu'), [
            'for' => 'block-frontpage-menu-help-topic', 'class' => 'form-label',
        ]) . \html_writer::tag('select', $options, [
            'id' => 'block-frontpage-menu-help-topic', 'class' => 'form-select custom-select',
        ]);
        // Shared help-panel identity: no link or action; close remains beside the topic selector.
        $brand = \html_writer::tag('span', \html_writer::empty_tag('img', [
            'src' => $PAGE->get_renderer('core')->image_url('helpbrand', 'block_frontpage_menu')->out(false),
            'alt' => '', 'width' => 25, 'height' => 24,
        ]), [
            'class' => 'block-frontpage-menu-help-brand', 'role' => 'img', 'aria-label' => '108design',
            'title' => '108design', 'tabindex' => '0', 'data-toggle' => 'tooltip', 'data-bs-toggle' => 'tooltip',
        ]);
        $header = \html_writer::tag(
            'header',
            \html_writer::tag('h2', $title, [
            'id' => 'block-frontpage-menu-context-help-title', 'class' => 'sr-only visually-hidden', 'tabindex' => '-1',
            ]) . \html_writer::div($choice, 'block-frontpage-menu-help-choices') . $brand . $close,
            ['class' => 'block-frontpage-menu-help-header block-frontpage-menu-help-header-branded']
        );
        return \html_writer::tag('aside', $header
            . \html_writer::div($articles, 'block-frontpage-menu-help-content', ['tabindex' => '0']), [
                'id' => 'block-frontpage-menu-context-help', 'class' => 'block-frontpage-menu-context-help',
                'aria-labelledby' => 'block-frontpage-menu-context-help-title', 'hidden' => 'hidden',
                'data-frontpagemenu-help-url' => $PAGE->url->out(false),
            ]);
    }
}
