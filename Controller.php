<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\VueExample;

use Piwik\Piwik;
use Piwik\Menu\MenuAdmin;
use Piwik\Menu\MenuTop;

/**
 * A controller lets you for example create a page that can be added to a menu. For more information read our guide
 * http://developer.piwik.org/guides/mvc-in-piwik or have a look at the our API references for controller and view:
 * http://developer.piwik.org/api-reference/Piwik/Plugin/Controller and
 * http://developer.piwik.org/api-reference/Piwik/View
 */
class Controller extends \Piwik\Plugin\Controller
{
    public function index()
    {
        Piwik::checkUserHasSomeAdminAccess();
        return $this->renderTemplate('index', [
            'topMenu' => MenuTop::getInstance()->getMenu(),
            'adminMenu' => MenuAdmin::getInstance()->getMenu(),
            'answerToLife' => 42
        ]);
    }
}
