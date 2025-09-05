### How to Check if the Current Page Is the Homepage in Joomla with PHP 

Below you can find a PHP snippet that will allow you to detect whether we are browsing the home page.

```
use Joomla\CMS\Factory;

$menu = Factory::getApplication()->getMenu();

// Determine if the user is viewing the front page
$isHomePage = ($menu->getActive() == $menu->getDefault());

if ($isHomePage)
{
    echo 'This is the front page!';
}

```
