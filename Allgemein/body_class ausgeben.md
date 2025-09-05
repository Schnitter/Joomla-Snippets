#grabb body class



Als erstes holen wir uns eine Instanz der Application, muss nur einmal im Dokument gemacht werden
```

<?php $app = JFactory::getApplication(); ?>

```

Als nächstes holen wir uns vom aktuellen Menüpunkt die Seitenklasse und legen Sie in einer Variable ab
```
<?php $pageclass_sfx = $app->getParams()->get('pageclass_sfx', ''); ?>
```

anschließend den Code für die Body zeile
```
<body <?php echo (!empty($pageclass_sfx) ? ' class="' . $pageclass_sfx . '"': ''); ?>>
```