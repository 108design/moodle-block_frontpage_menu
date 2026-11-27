<?php
// This file is part of Moodle - https://moodle.org/
/**
 * This file is part of a 108design source-available software product.
 *
 * Use and modification are permitted only under the Software License included
 * with this distribution. See LICENSE.md for the full terms.
 *
 * File documentation for lang/de/block_frontpage_menu.php.
 *
 * @package   block_frontpage_menu
 * @copyright 2026 Andreas Giesen <andreas@108design.com>
 * @license   108design source-available software license; see LICENSE.md
 */

$string['profile_help'] = 'Nutze das kompakte Profil in einer Seitenspalte. Breite Profile sind für breite Inhaltsregionen vorgesehen.';
$string['notconfigured'] = 'Wähle ein Menü aus dem Menübuilder für diesen Block aus.';
$string['authorityunavailable'] = 'Richte den Menübuilder ein, bevor du diesen Block konfigurierst.';
$string['pagehelp_blocksource_help'] = 'Der Block verweist auf die aktuelle zentrale Definition. Bearbeite das Menü über seinen Quellverweis.';
$string['pagehelp_blocksource_article'] = '<p>Wähle das zentrale Menü für die Ausgabe. Mehrere Blöcke dürfen denselben Schlüssel verwenden; Änderungen am zentralen Menü erscheinen in jedem Block. Der Quellhost bestimmt Menüstruktur und Sichtbarkeit.</p><p>Die Quellauswahl zeigt die Menüs des aktiven Anbieters. Der Block speichert den Quellverweis und kopiert keine Inhalte. Fehlt die Quelle oder bleibt sie nach der Sichtbarkeitsprüfung leer, sehen gewöhnliche Nutzer/innen kein Menü; Bearbeiter/innen erhalten einen Konfigurationshinweis.</p>';
$string['pagehelp_blockprofile_help'] = 'Wähle Kompakt für vertikale oder Breit für horizontale Ausgabe. Richte dich nach dem tatsächlich verfügbaren Platz deines Themes.';
$string['pagehelp_blockprofile_article'] = '<p><strong>Kompaktes vertikales Menü</strong> hält Zweige untereinander im Block. <strong>Breites horizontales Menü</strong> verteilt die obersten Einträge über die verfügbare Breite. Dein Theme bestimmt die Blockregionen und deren tatsächliche Breite.</p><p><strong>Dichte</strong> ändert die Abstände. Das Profil verändert weder die zentrale Definition noch deren Sichtbarkeitsbedingungen oder die Ausgabe in anderen Blöcken.</p>';
$string['density_help'] = 'Passe die Abstände um das Menü an: Kompakt, Normal oder Großzügig.';
$string['updateguard_hint'] = 'Verwende ein freigegebenes Paket für die installierte Ausgabe. Du kannst den Vorgang erneut prüfen.';
$string['updateguard_dependency'] = 'Eine benötigte Plugin-Version fehlt. Aktualisiere die Abhängigkeit gemeinsam mit diesem Plugin oder vorher.';
$string['updateguard_approval'] = 'Die Pakete oder der installierte Stand haben sich seit der Vorschau geändert. Prüfe den Vorgang erneut.';
$string['updateguard_busy'] = 'Eine andere Installation läuft. Versuche es nach deren Abschluss erneut.';
$string['updateguard_installed'] = 'Der installierte Updateschutz ist unvollständig. Stelle die Dateien der zuletzt installierten freigegebenen Version wieder her.';
$string['updateguard_operation'] = 'Diese Kombination von Installationsaktionen wird nicht unterstützt. Starte einen einzelnen Updatevorgang erneut.';
$string['updateinfo_choice'] = 'Kontrolliere vor dem Fortfahren die Paketquelle und Moodles Prüfergebnisse. Mit „{$a}“ unten kannst du abbrechen.';
