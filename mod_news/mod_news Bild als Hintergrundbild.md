# Wie kann man in joomla im overide news modul das Einleitungsbild als Hintergrundbild definieren?

Um in **Joomla** im **Override des News-Moduls (`mod_articles_news`)** das **Einleitungsbild (Intro Image)** als **Hintergrundbild** zu definieren, folgst du dieser **klaren Schritt-für-Schritt-Anleitung**:

---

## ✅ Ziel

> Das **Einleitungsbild eines Artikels** soll im Modul **`mod_articles_news`** als **CSS-Hintergrundbild** verwendet werden, anstatt als normales `<img>`-Tag.

---

## 🧱 Voraussetzungen

* Das Joomla-Modul **`mod_articles_news`** ist installiert.
* Du benutzt ein eigenes Template oder ein Child-Template.
* Du kannst Dateien im Template bearbeiten.

---

## 🔧 Schritt 1: Override erstellen

1. Gehe im Joomla-Backend zu:
   **Erweiterungen** > **Templates** > **Templates**.
2. Wähle dein aktives Template.
3. Klicke auf **"Erstelle Overrides"**.
4. Wähle: **mod\_articles\_news** → **default**.

> Dadurch wird folgendes erstellt:

```
/templates/[dein_template]/html/mod_articles_news/default.php
```

---

## ✍️ Schritt 2: Override bearbeiten

Öffne die Datei `default.php` im Ordner:

```
/templates/[dein_template]/html/mod_articles_news/default.php
```

Suche die foreach-Schleife, die die Artikel ausgibt:

```php
<?php foreach ($list as $item) : ?>
    ...
<?php endforeach; ?>
```

Jetzt holst du dir das **Einleitungsbild** und nutzt es im `style`-Attribut.

---

## 💡 Beispiel-Code

Ersetze den Inhalt in der Schleife z. B. durch folgenden Code:

```php
<?php foreach ($list as $item) : ?>
    <?php
        // Bilddaten auslesen
        $images = json_decode($item->images);
        $introImage = isset($images->image_intro) ? $images->image_intro : '';
    ?>

    <div class="news-item" style="background-image: url('<?php echo htmlspecialchars($introImage); ?>'); background-size: cover; background-position: center; padding: 20px; color: white; margin-bottom: 20px;">
        <h3><?php echo $item->title; ?></h3>

        <?php if ($params->get('show_introtext')) : ?>
            <div class="introtext">
                <?php echo $item->introtext; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
```

---

## 🎨 Optional: CSS-Auslagerung (bessere Lösung)

Du kannst die Styles auch in eine eigene CSS-Datei auslagern:

### HTML:

```php
<div class="news-item" style="--bg-url: url('<?php echo htmlspecialchars($introImage); ?>')">
```

### CSS:

```css
.news-item {
    background-image: var(--bg-url);
    background-size: cover;
    background-position: center;
    padding: 20px;
    color: white;
    margin-bottom: 20px;
}
```

---

## 📦 Optional: Fallback-Bild

Falls kein Einleitungsbild gesetzt ist:

```php
$introImage = !empty($images->image_intro) ? $images->image_intro : 'images/standard.jpg';
```

---

## ✅ Ergebnis

Das Einleitungsbild jedes Artikels wird als **Hintergrundbild** im Modul verwendet. So entsteht ein moderner "Card-Style"-Look direkt im `mod_articles_news`.

---