<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\VueExample;

use Piwik\Menu\MenuAdmin;
use Piwik\Menu\MenuTop;

/**
 * This class allows you to add, remove or rename menu items.
 * To configure a menu (such as Admin Menu, Top Menu, User Menu...) simply call the corresponding methods as
 * described in the API-Reference http://developer.piwik.org/api-reference/Piwik/Menu/MenuAbstract
 */
class Menu extends \Piwik\Plugin\Menu
{
    public function configureTopMenu(MenuTop $menu)
    {
        // $menu->addItem('VueExample_MyTopItem', null, $this->urlForDefaultAction(), $orderId = 30);
    }

    public function configureAdminMenu(MenuAdmin $menu)
    {
        $menu->addPlatformItem('VueExample_MyVueExample', $this->urlForDefaultAction(), $orderId = 30);
        // reuse an existing category. Execute the showList() method within the controller when menu item was clicked
        // $menu->addManageItem('VueExample_MyUserItem', $this->urlForAction('showList'), $orderId = 30);
        // $menu->addPlatformItem('VueExample_MyUserItem', $this->urlForDefaultAction(), $orderId = 30);

        // or create a custom category
        // $menu->addItem('CoreAdminHome_MenuManage', 'VueExample_MyUserItem', $this->urlForDefaultAction(), $orderId = 30);
    }
}
