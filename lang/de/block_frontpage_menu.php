<?php
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
$string['pluginname'] = 'Menübuilder-Block';
$string['title'] = 'Blocktitel';
$string['menu'] = 'Menüquelle';
$string['style'] = 'Menüstil';
$string['padding'] = 'Menüabstand';
$string['density'] = 'Kompaktheit';
$string['fixedstyle'] = 'Kompaktes Blockmenü';
$string['profilecompact'] = 'Kompaktes vertikales Menü';
$string['profilewide'] = 'Breites horizontales Menü';
$string['profile_help'] = 'Nutze das kompakte Profil in einer Seitenspalte. Breite Profile sind für breite Inhaltsregionen vorgesehen.';
$string['invalidprofile'] = 'Das gewählte Menüprofil ist ungültig.';
$string['invalidsource'] = 'Die gewählte Menüquelle ist nicht mehr verfügbar.';
$string['sourcecentral'] = 'Zentral';
$string['sourcesegment'] = 'Segment';
$string['sourcelinkedsegment'] = 'Verknüpftes Segment';
$string['configuresource'] = 'Menü konfigurieren';
$string['configure'] = 'Block konfigurieren';
$string['notconfigured'] = 'Wählen Sie ein Menü aus dem Menübuilder für diesen Block aus.';
$string['novisibleentries'] = 'Das ausgewählte Menü hat in der aktuellen Ansicht keine sichtbaren Einträge.';
$string['frontpageunavailable'] = 'Die Menübuilder-Anbindung ist derzeit nicht verfügbar.';
$string['privacy:metadata'] = 'Der Menübuilder-Block speichert keine personenbezogenen Daten.';
$string['frontpage_menu:addinstance'] = 'Menübuilder-Block hinzufügen';
$string['frontpage_menu:myaddinstance'] = 'Menübuilder-Block zum Dashboard hinzufügen';
$string['authorityunavailable'] = 'Richten Sie den Menübuilder ein, bevor Sie diesen Block konfigurieren.';
$string['paddingcompact'] = 'Kompakt';
$string['paddingnormal'] = 'Normal';
$string['paddingspacious'] = 'Großzügig';

$string['pagehelp_menus_title'] = 'Menüblock-Hilfe';
$string['pagehelp_more'] = 'Mehr dazu im Hilfepanel';
$string['contexthelptopics'] = 'Hilfethemen';
$string['pagehelp_blocksource'] = 'Menüquelle';
$string['pagehelp_blocksource_help'] = ('Der Block verweist auf die aktuelle zentrale Definition. Bearbeite das Menü '
    . 'über seinen Quellverweis.');
$string['pagehelp_blocksource_article'] = ('<p>Wähle das zentrale Menü für die Ausgabe. Mehrere Blöcke dürfen '
    . 'denselben Schlüssel verwenden; Änderungen am zentralen Menü erscheinen in '
    . 'jedem Block. Der Quellhost bestimmt Menüstruktur und Sichtbarkeit.</p><p>Die '
    . 'Quellauswahl zeigt die Menüs des aktiven Anbieters. Der Block speichert den '
    . 'Quellverweis und kopiert keine Inhalte. Fehlt die Quelle oder bleibt sie nach '
    . 'der Sichtbarkeitsprüfung leer, sehen gewöhnliche Nutzer kein Menü; '
    . 'Bearbeiter erhalten einen Konfigurationshinweis.</p>');
$string['pagehelp_blockprofile'] = 'Profil und Dichte';
$string['pagehelp_blockprofile_help'] = ('Wähle Kompakt für vertikale oder Breit für horizontale Ausgabe. Richte '
    . 'Dich nach dem tatsächlich verfügbaren Platz Deines Themes.');
$string['pagehelp_blockprofile_article'] = (
        '<p><strong>Kompaktes vertikales Menü</strong> hält Zweige untereinander im '
    . 'Block. <strong>Breites horizontales Menü</strong> verteilt die obersten '
    . 'Einträge über die verfügbare Breite. Dein Theme bestimmt die Blockregionen '
    . 'und deren tatsächliche Breite.</p><p><strong>Dichte</strong> ändert die '
    . 'Abstände. Das Profil verändert weder die zentrale Definition noch deren '
    . 'Sichtbarkeitsbedingungen oder die Ausgabe in anderen Blöcken.</p>'
    );
$string['density_help'] = 'Passe die Abstände um das Menü an: Kompakt, Normal oder Großzügig.';

// Shared independent signed update protection.
$string['updateguard_heading'] = 'Update angehalten';
$string['updateguard_component'] = 'Das Paket für {$a} wurde abgewiesen.';
$string['updateguard_hint'] = 'Verwende ein freigegebenes Paket für die installierte Ausgabe. Du kannst den Vorgang erneut prüfen.';
$string['updateguard_unchanged'] = 'Dieser Vorgang hat keine Plugin-Dateien ersetzt.';
$string['updateguard_help'] = 'Das installierte Plugin prüft vor dem Ersetzen die Herausgebersignatur, den Paketinhalt, den erlaubten Updatekanal und die Kompatibilität. Eine gültige Signatur erlaubt keinen Wechsel auf eine andere Ausgabe. Wird ein Paket abgewiesen, stoppt die gesamte Sammelaktion.';
$string['updateguard_signature'] = 'Die Herausgebersignatur oder der Paketinhalt konnte nicht bestätigt werden.';
$string['updateguard_policy'] = 'Das Paket passt nicht zur installierten Ausgabe oder zum erlaubten Paketprofil.';
$string['updateguard_channel'] = 'Updates über diesen Kanal sind für dieses Plugin nicht freigegeben.';
$string['updateguard_metadata'] = 'Die Versions- oder Abhängigkeitsangaben sind nicht konsistent.';
$string['updateguard_dependency'] = 'Eine benötigte Plugin-Version fehlt. Aktualisiere die Abhängigkeit gemeinsam mit diesem Plugin oder vorher.';
$string['updateguard_approval'] = 'Die Pakete oder der installierte Stand haben sich seit der Vorschau geändert. Prüfe den Vorgang erneut.';
$string['updateguard_busy'] = 'Eine andere Installation läuft. Versuche es nach deren Abschluss erneut.';
$string['updateguard_installed'] = 'Der installierte Updateschutz ist unvollständig. Stelle die Dateien der zuletzt installierten freigegebenen Version wieder her.';
$string['updateguard_operation'] = 'Diese Kombination von Installationsaktionen wird nicht unterstützt. Starte einen einzelnen Updatevorgang erneut.';
$string['updateguard_failed'] = 'Das Update konnte nicht geprüft werden. Es wurde keine Installation gestartet.';
$string['updateguard_back'] = 'Zur Pluginübersicht';
// End shared independent signed update protection.
