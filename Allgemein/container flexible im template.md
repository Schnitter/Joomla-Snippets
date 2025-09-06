wie kann man man in joomla5 das template flexible mit container und container-fluid gestalten?

In Joomla 5 kannst du dein Template so aufbauen, dass du flexibel zwischen **`.container`** und **`.container-fluid`** (Bootstrap 5) umschalten kannst. Dafür gibt es verschiedene Ansätze, die sich je nach deinem Ziel kombinieren lassen.

---

## 🔹 1. Template-Layout flexibel machen

In deinem Template (z. B. `templates/dein-template/index.php`) kannst du die Bootstrap-Klassen dynamisch einbauen.
Beispiel:

```php
<?php
// Template-Parameter laden
$containerType = $this->params->get('container_type', 'container');
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
  <jdoc:include type="head" />
</head>
<body>
  <div class="<?php echo $containerType; ?>">
    <jdoc:include type="modules" name="top" style="xhtml" />
    <jdoc:include type="component" />
    <jdoc:include type="modules" name="footer" style="xhtml" />
  </div>
</body>
</html>
```

---

## 🔹 2. Template-Option im Backend (container/container-fluid)

Damit du im Backend flexibel umschalten kannst, definierst du die **Template-Parameter** in der `templateDetails.xml`:

```xml
<config>
  <fields name="params">
    <fieldset name="advanced">
      <field 
        name="container_type" 
        type="list" 
        default="container" 
        label="Container-Typ" 
        description="Wähle zwischen Bootstrap .container oder .container-fluid">
        <option value="container">Container (fixe Breite)</option>
        <option value="container-fluid">Container Fluid (volle Breite)</option>
      </field>
    </fieldset>
  </fields>
</config>
```

➡️ Jetzt erscheint im Joomla-Backend (unter **System → Templates → Stile → Dein Template**) eine Auswahl, mit der du flexibel zwischen `container` und `container-fluid` wechseln kannst.

---

## 🔹 3. Module mit eigenem Container

Wenn du für bestimmte **Modul-Positionen** unterschiedliche Container brauchst, kannst du es so lösen:

```php
<div class="container">
  <jdoc:include type="modules" name="sidebar" style="xhtml" />
</div>

<div class="container-fluid">
  <jdoc:include type="modules" name="footer" style="xhtml" />
</div>
```

---

## 🔹 4. Noch flexibler (Overrides)

Du kannst auch pro **Menüpunkt oder Seite** unterschiedliche Container nutzen, z. B. per

```php
$app   = \Joomla\CMS\Factory::getApplication();
$menu  = $app->getMenu();
$active= $menu->getActive();

if ($active && $active->id == 123) {
    $containerType = 'container-fluid';
} else {
    $containerType = 'container';
}
```

Damit steuerst du die Ausgabe seitenweise.

---

👉 So kannst du dein Joomla 5 Template flexibel gestalten:

* **Global** per Template-Option (empfohlen)
* **Pro Modulposition** (fix eingebaut)
* **Pro Seite / Menüpunkt** (per PHP-Abfrage)
