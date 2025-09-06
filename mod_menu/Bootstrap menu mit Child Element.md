# wie kann man in joomla5 Bootstrap 5 menu mit child elementen erstellen?

In Joomla 5 hast du mehrere Möglichkeiten, ein Menü mit **Bootstrap 5** und **Child-Elementen (Untermenüs / Dropdowns)** umzusetzen.
Ich zeige dir den typischen Weg über das integrierte Joomla-Menümodul + Bootstrap 5 Markup.

---

## 1. Menü in Joomla anlegen

1. Gehe im Backend zu **Menüs → Main Menu** (oder ein eigenes Menü).
2. Erstelle Menüeinträge:

   * Ein Hauptmenüpunkt (z. B. "Produkte")
   * Darunter Unterpunkte (z. B. "Fleisch", "Wurst", "Getränke").
3. Joomla ordnet die Struktur automatisch hierarchisch.

---

## 2. Menümodul im Template veröffentlichen

1. Gehe zu **Inhalt → Module → Neu → Menü**.
2. Wähle dein Menü (z. B. Main Menu).
3. Weise es einer Modulposition zu (z. B. `menu` oder `navbar`).
4. In den **Moduloptionen** kannst du einstellen:

   * **Menü-Klasse**: z. B. `navbar-nav ms-auto` (Bootstrap-Klassen).
   * **Layout**: Standardmäßig gibt Joomla UL/LI aus → wir passen es mit einem Override an.

---

## 3. Override für Bootstrap 5 Dropdowns

Damit Bootstrap Dropdowns korrekt funktionieren, brauchst du ein **Template-Override**:

1. Gehe im Backend zu
   `System → Templates → Dein Template → Overrides → Module → mod_menu`.
2. Erstelle einen Override für `default.php`.
3. Passe das Markup an Bootstrap 5 an, z. B.:

```php
<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('bootstrap.dropdown');
?>

<ul class="navbar-nav">
    <?php foreach ($list as $i => &$item) : ?>
        <?php
        $class = 'nav-item';
        $linkClass = 'nav-link';

        if ($item->deeper) {
            $class .= ' dropdown';
            $linkClass .= ' dropdown-toggle';
        }

        if ($item->parent) {
            $class .= ' dropdown';
        }
        ?>

        <li class="<?php echo $class; ?>">
            <a 
              href="<?php echo $item->flink; ?>" 
              class="<?php echo $linkClass; ?>" 
              <?php if ($item->deeper) : ?>
                data-bs-toggle="dropdown" role="button" aria-expanded="false"
              <?php endif; ?>
            >
                <?php echo $item->title; ?>
            </a>

            <?php if ($item->deeper) : ?>
                <ul class="dropdown-menu">
            <?php elseif ($item->shallower) : ?>
                </li>
                <?php echo str_repeat('</ul></li>', $item->level_diff); ?>
            <?php else : ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
</ul>
```

---

## 4. JavaScript für Bootstrap Dropdown aktivieren

Falls dein Template Bootstrap 5 JS noch nicht geladen hat, lade es in `index.php` oder `templateDetails.xml`:

```php
use Joomla\CMS\HTML\HTMLHelper;
HTMLHelper::_('bootstrap.framework');
```

Oder einfach manuell die Bootstrap 5 Bundle JS (enthält Dropdown) einfügen.

---

## 5. Ergebnis

* **Top-Level-Menüpunkte** erscheinen als Navbar-Links.
* **Child-Elemente** erscheinen als Dropdown-Menü in Bootstrap-Stil.

* Funktioniert responsive inkl. Mobile-Toggle.
