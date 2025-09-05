### How to Check If the Current User is Super User in Joomla with PHP

Below you can find a PHP snippet that will allow you to detect whether a user is a Super User.

```
use Joomla\CMS\Factory;

$isSuperUser = Factory::getUser()->authorise('core.admin');

if ($isSuperUser)
{
    echo "Hey Super User";
}
```