# wie kann man in joomla5 die Whitespaces entfernen? (Teil2)

wenn wir global Whitespaces optimieren, dürfen **`<pre>`, `<code>` und `<textarea>`** nicht verändert werden.
Dafür geht man so vor:

1. Diese Bereiche mit **Platzhaltern** sichern.
2. Den Rest des HTMLs optimieren.
3. Platzhalter wieder zurücksetzen.

---

### Angepasstes Plugin (mit Ausschluss von `pre`, `code`, `textarea`)

```php
<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.RemoveWhitespace
 *
 * Plugin zum Entfernen von unnötigen Whitespaces aus dem HTML-Code,
 * wobei <pre>, <code> und <textarea> ausgeschlossen werden.
 */

namespace Joomla\Plugin\System\RemoveWhitespace\Extension;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;

\defined('_JEXEC') or die;

final class RemoveWhitespace extends CMSPlugin
{
    /**
     * Event-Handler: Nach dem Rendern der Seite
     */
    public function onAfterRender(Event $event): void
    {
        $app = $this->getApplication();

        // Nur im Frontend ausführen
        if ($app->isClient('administrator')) {
            return;
        }

        $buffer = $app->getBody();

        // 1. Speichere <pre>, <code> und <textarea>-Blöcke zwischen Platzhaltern
        $placeholders = [];
        $buffer = preg_replace_callback(
            '#<(pre|code|textarea)(.*?)>(.*?)</\1>#is',
            function ($matches) use (&$placeholders) {
                $key = '###WHITESPACE_PROTECT_' . count($placeholders) . '###';
                $placeholders[$key] = $matches[0]; // kompletter Block wird gesichert
                return $key;
            },
            $buffer
        );

        // 2. Whitespaces im restlichen HTML reduzieren
        $buffer = preg_replace('/\s+/', ' ', $buffer);    // Mehrfach-Whitespace → einzelnes Leerzeichen
        $buffer = preg_replace('/>\s+</', '><', $buffer); // Leerzeichen zwischen Tags entfernen

        // 3. Gesicherte Blöcke zurücksetzen
        $buffer = strtr($buffer, $placeholders);

        $app->setBody($buffer);
    }
}
```

---

🔧 **Was dieses Plugin macht:**

* Findet alle `<pre>`, `<code>` und `<textarea>` Blöcke.
* Ersetzt sie temporär durch Platzhalter (`###WHITESPACE_PROTECT_x###`).
* Führt die Whitespaces-Reduzierung nur am übrigen HTML durch.
* Setzt danach die Originalblöcke unverändert wieder ein.


Damit bleiben Code-Beispiele, Textareas und Preformatted-Text **unverändert**.
