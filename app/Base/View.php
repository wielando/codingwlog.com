<?php

namespace Base;

class View
{
    private bool $backendMode = false;

    public function renderTemplate(string $template, array $params = [], bool $backendTemplate = false): false|string
    {
        $pathToView = ($backendTemplate) ? MAIN_PATH . '/backend/web/views/' : MAIN_PATH . '/web/views/';

        $templatePath = $pathToView . $template . '.php';

        if (file_exists($templatePath)) {

            // Starten des Output-Puffers, um die Ausgabe des Templates zu erfassen
            ob_start();

            // Extrahieren der Parameter, um sie in der Template-Datei verfügbar zu machen
            extract($params);

            // Inkludieren der Template-Datei
            include($templatePath);

            // Template-Ausgabe erfassen und zurückgeben
            $output = ob_get_clean();

            return $output;
        } else {
            // Hier kannst du Fehlerbehandlung hinzufügen, z.B. eine Fehlermeldung anzeigen
            return "Template not found.";
        }
    }

}
