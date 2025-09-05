### How to Connect to an External Database in Joomla with PHP

Below is a PHP snippet allowing you to connect to an external database using the Joomla API.

```
// Define the external database driver options
$options = [
	'driver'   => 'mysql',          // The Database driver name
	'host'     => 'db.myhost.com',  // Database host name
	'user'     => 'username',       // User for database authentication
	'password' => 'password',       // Password for database authentication
	'database' => 'database_name',  // Database name
	'prefix'   => 'abc_'            // Database prefix (may be empty)
];

if (version_compare(JVERSION, '4.0', '>=')) {
    // Joomla 4+
    $db = (new \Joomla\Database\DatabaseFactory())>getDriver('mysqli', $options);
} else {
    // Joomla 3
    $db = \Joomla\Database\DatabaseDriver::getInstance($options);
}

// Use the database driver for your queries
$query = $db->getQuery(true);

$query
	->select($db->quoteName(array('column1', 'column2')))
	->from($db->quoteName('#__table'));

$db->setQuery($query);

$results = $db->loadObjectList();

```
