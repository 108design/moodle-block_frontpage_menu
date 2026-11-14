// This file is part of Moodle - https://moodle.org/
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for amd/src/context_help.js.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen
 * @license   See LICENSE.md for the full terms.
 */
// Copyright (C) 2026 Andreas Giesen. See LICENSE.md.
import {publish, subscribe} from 'core/pubsub';
import DrawerEvents from 'core/drawer_events';
import Drawers from 'theme_boost/drawers';
import {Popover} from 'theme_boost/popover';

/** Nonmodal contextual help; use native exclusive drawer coordination when available. */
export const init = config => {
    if (config.cssUrl) {
        const href = new URL(config.cssUrl, location.href).href;
        if (![...document.querySelectorAll('link[rel="stylesheet"]')].some(link => link.href === href)) {
            const style = document.createElement('link');
            style.rel = 'stylesheet';
            style.href = href;
            document.head.append(style);
        }
    }
    const panels = [...document.querySelectorAll('#block-frontpage-menu-context-help')];
    const panel = panels.shift();
    panels.forEach(duplicate => duplicate.remove());
    const buttons = [...document.querySelectorAll('.block-frontpage-menu-help-navbar')];
    const navbar = buttons.shift();
    buttons.forEach(duplicate => duplicate.remove());
    const navigation = document.getElementById('usernavigation');
    if (navbar && navigation && !navigation.contains(navbar)) {
        const before = navigation.querySelector(':scope > .divider, :scope > .usermenu');
        navigation.insertBefore(navbar, before);
    }
    const preparePopovers = () => { document.querySelectorAll('.block-frontpage-menu-context-help-icon').forEach(icon => Popover.getOrCreateInstance(icon, {container: icon.closest('.modal.show, dialog[open]') || document.body})); };
    preparePopovers();
    if (!panel || panel.dataset.initialised) return;
    new MutationObserver(preparePopovers).observe(document.body, {childList: true, subtree: true});
    panel.dataset.initialised = '1';
    document.body.append(panel);
    const heading = panel.querySelector('h2');
    const content = panel.querySelector('.block-frontpage-menu-help-content');
    const choice = panel.querySelector('select');
    const helpUrl = new URL(panel.dataset.frontpagemenuHelpUrl, location.href);
    const hasTopic = topic => [...choice.options].some(option => option.value === topic);
    let opener = null;
    let activeTopic = '';
    let ownsSpace = false;
    const exclusiveDrawers = Boolean(DrawerEvents.DRAWER_EXCLUSIVE_REQUESTED && DrawerEvents.DRAWER_EXCLUSIVE_RELEASED);
    document.body.classList.toggle('block-frontpage-menu-help-legacy-drawers', !exclusiveDrawers);

    const position = () => {
        const nav = document.querySelector('.navbar.fixed-top');
        const top = nav ? Math.max(0, nav.getBoundingClientRect().bottom) + 12 : 12;
        panel.style.setProperty('--block-frontpage-menu-help-top', `${top}px`);
    };
    const hide = (returnFocus = true, releaseSpace = true) => {
        if (panel.hidden) return;
        panel.hidden = true;
        document.body.classList.remove('block-frontpage-menu-help-open');
        document.querySelectorAll('[data-frontpagemenu-help-open]').forEach(button => button.setAttribute('aria-expanded', 'false'));
        if (ownsSpace) {
            ownsSpace = false;
            if (releaseSpace) publish(DrawerEvents.DRAWER_EXCLUSIVE_RELEASED, {region: 'right'});
        }
        if (returnFocus && opener?.isConnected) opener.focus();
    };
    const showTopic = topic => {
        const article = [...panel.querySelectorAll('[data-frontpagemenu-help-article]')]
            .find(node => node.dataset.frontpagemenuHelpArticle === topic);
        if (!article) return;
        panel.querySelectorAll('article').forEach(node => { node.hidden = node !== article; });
        choice.value = topic;
        if (activeTopic !== topic) content.scrollTop = 0;
        activeTopic = topic;
    };
    const show = (topic, trigger) => {
        if (topic && !hasTopic(topic)) return;
        if (trigger) opener = trigger;
        const modal = opener?.closest('.modal.show, dialog[open]');
        (modal || document.body).append(panel);
        showTopic(topic || activeTopic || choice.value);
        position();
        if (panel.hidden) {
            if (exclusiveDrawers) {
                publish(DrawerEvents.DRAWER_EXCLUSIVE_REQUESTED, {region: 'right'});
                ownsSpace = true;
            }
            panel.hidden = false;
            document.body.classList.add('block-frontpage-menu-help-open');
        }
        document.querySelectorAll('[data-frontpagemenu-help-open]').forEach(button => button.setAttribute('aria-expanded', 'true'));
        (panel.querySelector('article:not([hidden]) h3') || heading).focus();
    };
    document.addEventListener('click', event => {
        // Native information controls inside labels/disclosures must not change their host control.
        if (event.target.closest('.block-frontpage-menu-context-help-icon')?.closest('label, summary')) {
            event.preventDefault();
        }
        const close = event.target.closest('[data-frontpagemenu-help-close]');
        if (close) { hide(); return; }
        const button = event.target.closest('[data-frontpagemenu-help-open]');
        const link = event.target.closest('a[href]');
        let topic = '';
        if (link) {
            const url = new URL(link.href, window.location.href);
            if (url.origin === location.origin && url.pathname === helpUrl.pathname) {
                const requested = url.searchParams.get('frontpagemenuhelp') || '';
                if (hasTopic(requested)) topic = requested;
            }
        }
        if (!button && !topic) return;
        event.preventDefault();
        if (button && !panel.hidden) { hide(); return; }
        const popover = link?.closest('.popover');
        // Moodle adapters may describe the outer popover or its body; match the actual trigger.
        const describedIds = [popover?.id, popover?.querySelector('.popover-body')?.id].filter(Boolean);
        const icon = [...document.querySelectorAll('.help-icon[aria-describedby]')]
            .find(candidate => candidate.getAttribute('aria-describedby').split(/\s+/)
                .some(id => describedIds.includes(id)));
        const trigger = button || icon || document.querySelector('[data-frontpagemenu-help-open]');
        if (topic) {
            document.querySelectorAll('.help-icon').forEach(icon => Popover.getInstance(icon)?.hide());
        }
        show(topic, trigger);
    });
    choice.addEventListener('change', () => {
        showTopic(choice.value);
        panel.querySelector('article:not([hidden]) h3')?.focus();
    });
    document.addEventListener('keydown', event => {
        const modal = document.querySelector('.modal.show, dialog[open]');
        if (event.key !== 'Escape' || panel.hidden || (modal && !modal.contains(panel))) return;
        event.preventDefault();
        event.stopPropagation();
        hide();
    }, true);
    // Native tools win when explicitly reopened. Their DOM and input state are never replaced.
    document.addEventListener(Drawers.eventTypes.drawerShow, event => {
        if (event.target.classList.contains('drawer-right') && !panel.hidden) hide(false);
    });
    // A second overlay now owns the native exclusive request; do not release its claim.
    if (exclusiveDrawers) subscribe(DrawerEvents.DRAWER_EXCLUSIVE_REQUESTED, ({region} = {}) => {
        if (region === 'right' && ownsSpace) hide(false, false);
    });
    document.addEventListener('show.bs.modal', () => hide(false));
    const restorePanel = event => {
        if (event.target.contains(panel)) {
            hide(false);
            document.body.append(panel);
        }
    };
    document.addEventListener('hidden.bs.modal', restorePanel);
    window.addEventListener('resize', position);
    if (config.topic) show(config.topic);
};
