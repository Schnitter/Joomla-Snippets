# wie kann man in joomla5 die Whitespaces entfernen?

In Joomla 5 kannst du Whitespaces im ausgegebenen HTML entfernen, indem du ein kleines **System-Plugin** erstellst, das den Output-Buffer filtert, bevor er an den Browser gesendet wird.

Das Prinzip:

* Joomla 5 feuert das Event `onAfterRender` nachdem alle Inhalte gerendert sind.
* Dort kannst du mit **Regex** oder PHP-Funktionen unnötige Leerzeichen, Tabs oder Zeilenumbrüche reduzieren.

---

### Beispiel: Whitespaces entfernen (System-Plugin)

```php
<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.RemoveWhitespace
 *
 * Plugin zum Entfernen von unnötigen Whitespaces aus dem HTML-Code
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

        // Nur im Site-Bereich (nicht im Backend)
        if ($app->isClient('administrator')) {
            return;
        }

        $buffer = $app->getBody();

        // Whitespaces optimieren: mehrere Leerzeichen, Tabs und Zeilenumbrüche reduzieren
        $buffer = preg_replace('/\s+/', ' ', $buffer);

        // Optional: Leerzeichen zwischen HTML-Tags entfernen
        $buffer = preg_replace('/>\s+</', '><', $buffer);

        $app->setBody($buffer);
    }
}
```

---

### Schritte zur Nutzung

1. **Ordnerstruktur erstellen:**

   ```
   plugins/system/removewhitespace/
   ├── removewhitespace.php
   └── removewhitespace.xml
   ```

2. **`removewhitespace.xml` (Manifest-Datei):**

   ```xml
   <?xml version="1.0" encoding="utf-8"?>
   <extension type="plugin" group="system" method="upgrade" version="5.0">
       <name>PLG_SYSTEM_REMOVEWHITESPACE</name>
       <author>Dein Name</author>
       <version>1.0.0</version>
       <description>Entfernt Whitespaces aus dem HTML-Code</description>
       <files>
           <filename plugin="removewhitespace">removewhitespace.php</filename>
       </files>
   </extension>
   ```

3. **ZIP erstellen** und über den Joomla-Installer hochladen.

4. Im Backend unter **System → Plugins → RemoveWhitespace** aktivieren.

---

⚠️ Hinweis:

* Nicht übertreiben, sonst können manche Inline-Skripte oder `<pre>`-Tags kaputtgehen.
* Am besten das Plugin so anpassen, dass es bestimmte Bereiche ignoriert (z. B. `<pre>`, `<code>`, `<textarea>`).
