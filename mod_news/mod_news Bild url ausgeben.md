## wie kann man im einem Joomla override im modul News die Bild url ermitteln?


Um in einem Joomla-Override für das Modul "News" (vermutlich mod_articles_news) die Bild-URL eines Artikels zu ermitteln, musst du den Pfad zum Einleitungsbild (intro image) oder Vollbild (full article image) aus den Artikelparametern holen.

### 1. Wo du das machst

Overrides für das Modul mod_articles_news befinden sich typischerweise unter:

```
/templates/dein_template/html/mod_articles_news/
```

Du kannst dort z. B. die Datei default.php überschreiben oder eine eigene Layout-Datei erstellen.
<hr>
### 2. Zugriff auf die Bild-URL

In dem Modul erhältst du Artikelobjekte in einer Schleife, meistens so:

```
<?php foreach ($list as $item) : ?>
```

Jeder $item enthält Informationen zum Artikel, inkl. Bilder.

Bilddaten befinden sich in:
```
$item->images

```

Das ist ein JSON-String, den du zuerst dekodieren musst:

```
<?php
$images = json_decode($item->images);
?>
```

Dann kannst du auf die Bild-URLs zugreifen:

```
$introImage = isset($images->image_intro) ? $images->image_intro : '';
$fullImage = isset($images->image_fulltext) ? $images->image_fulltext : '';
```

### 3. Beispiel: Bild ausgeben
```
<?php foreach ($list as $item) : ?>
    <?php
        $images = json_decode($item->images);
        $imageUrl = !empty($images->image_intro) ? $images->image_intro : $images->image_fulltext;
    ?>
    
    <?php if (!empty($imageUrl)) : ?>
        <img src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>
    
    <h3><?php echo $item->title; ?></h3>
<?php endforeach; ?>
```
### 4. Hinweis zu Pfaden

Die Bildpfade in image_intro und image_fulltext sind meistens relativ, z. B.:

```
images/sampledata/fruitshop/apple.jpg
```

Daher kannst du sie direkt als src verwenden, solange dein Joomla korrekt konfiguriert ist. Wenn nötig, kannst du auch den vollständigen Pfad erzeugen:

```
JUri::base() . $imageUrl
```

### 5. Tipps
Achte auf das HTML-Encoding bei der Ausgabe.

Falls du benutzerdefinierte Felder für Bilder verwendest, musst du diese anders abfragen ($item->jcfields).
